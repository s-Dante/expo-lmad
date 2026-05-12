<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\ProgramaAcademico;
use App\Enums\EstatusProyecto;
use Illuminate\Http\JsonResponse;

/**
 * API externa para el proyecto Bolsa de Trabajo.
 *
 * Todas las rutas de este controlador están protegidas por el middleware
 * 'ext.token' que valida el header Authorization: Bearer <token>.
 *
 * Solo se exponen proyectos con estatus 'aprobado'.
 *
 * Rutas disponibles (prefijo /api/ext/):
 *   GET  expositores              → listado de todos los alumnos con proyecto aprobado
 *   GET  estudiante/{matricula}   → perfil del alumno + sus proyectos aprobados
 *   GET  proyecto/{slug}          → detalle completo de un proyecto
 *   GET  programas                → catálogo de programas académicos (para filtros)
 *   GET  categorias               → catálogo de categorías de proyectos (para filtros)
 */
class ExternalApiController extends Controller
{
    // ──────────────────────────────────────────────────────────────────────────
    // 1. GET /api/ext/expositores
    //    Lista todos los estudiantes que tienen al menos un proyecto aprobado.
    //    Ideal para la página de listado del job board.
    // ──────────────────────────────────────────────────────────────────────────
    public function expositores(): JsonResponse
    {
        // Obtener todos los proyectos aprobados con sus autores y relaciones básicas
        $proyectos = Proyecto::with([
                'autores.programaAcademico',
                'materia.categoria',
                'portada',
            ])
            ->where('estatus', EstatusProyecto::Aprobado->value)
            ->get();

        // Agrupar por estudiante para que cada alumno aparezca una sola vez
        // aunque tenga varios proyectos
        $expositoresMap = [];

        foreach ($proyectos as $proyecto) {
            foreach ($proyecto->autores as $autor) {
                $matricula = $autor->matricula;

                if (!isset($expositoresMap[$matricula])) {
                    $expositoresMap[$matricula] = [
                        'matricula'          => $matricula,
                        'nombre'             => $autor->nombre,
                        'apellido_paterno'   => $autor->apellido_paterno,
                        'apellido_materno'   => $autor->apellido_materno,
                        'nombre_completo'    => trim("{$autor->nombre} {$autor->apellido_paterno} {$autor->apellido_materno}"),
                        'semestre'           => $autor->semestre,
                        'email'              => $autor->email,
                        'programa_academico' => $autor->programaAcademico?->nombre,
                        'programa_abreviatura' => $autor->programaAcademico?->abreviatura,
                        'proyectos'          => [],
                    ];
                }

                // Añade el proyecto a la lista del alumno (sin duplicados)
                $expositoresMap[$matricula]['proyectos'][] = [
                    'id'         => $proyecto->id,
                    'slug'       => $proyecto->slug,
                    'titulo'     => $proyecto->titulo,
                    'descripcion'=> $proyecto->descripcion,
                    'categoria'  => $proyecto->materia?->categoria?->nombre,
                    'periodo'    => $proyecto->periodo_semestral,
                    'portada_url'=> $proyecto->portada?->url,
                    'es_lider'   => (bool) $autor->pivot->es_lider,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'total'   => count($expositoresMap),
            'data'    => array_values($expositoresMap),
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 2. GET /api/ext/estudiante/{matricula}
    //    Perfil completo del estudiante + sus proyectos aprobados.
    //    Ideal para la página de detalle / "CV" del alumno en el job board.
    // ──────────────────────────────────────────────────────────────────────────
    public function estudiante(string $matricula): JsonResponse
    {
        $estudiante = Estudiante::with('programaAcademico')
            ->where('matricula', $matricula)
            ->first();

        if (!$estudiante) {
            return response()->json([
                'success' => false,
                'message' => "No se encontró ningún estudiante con la matrícula {$matricula}.",
            ], 404);
        }

        // Solo proyectos aprobados donde este alumno es autor
        $proyectos = Proyecto::with([
                'autores',
                'materia.categoria',
                'softwares',
                'multimedia',
                'portada',
                'profesor',
            ])
            ->where('estatus', EstatusProyecto::Aprobado->value)
            ->whereHas('autores', fn ($q) => $q->where('matricula', $matricula))
            ->get()
            ->map(fn ($p) => $this->formatProyecto($p, $matricula));

        if ($proyectos->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "El estudiante con matrícula {$matricula} no tiene proyectos aprobados en la EXPO.",
            ], 404);
        }

        return response()->json([
            'success'    => true,
            'estudiante' => [
                'matricula'           => $estudiante->matricula,
                'nombre'              => $estudiante->nombre,
                'apellido_paterno'    => $estudiante->apellido_paterno,
                'apellido_materno'    => $estudiante->apellido_materno,
                'nombre_completo'     => trim("{$estudiante->nombre} {$estudiante->apellido_paterno} {$estudiante->apellido_materno}"),
                'semestre'            => $estudiante->semestre,
                'email'               => $estudiante->email,
                'programa_academico'  => $estudiante->programaAcademico?->nombre,
                'programa_abreviatura'=> $estudiante->programaAcademico?->abreviatura,
            ],
            'proyectos'  => $proyectos,
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 3. GET /api/ext/proyecto/{slug}
    //    Detalle completo de un proyecto (autores, multimedia, softwares, etc.)
    //    Útil si el job board quiere mostrar la página de un proyecto directamente.
    // ──────────────────────────────────────────────────────────────────────────
    public function proyecto(string $slug): JsonResponse
    {
        $proyecto = Proyecto::with([
                'autores.programaAcademico',
                'materia.categoria',
                'materia.planAcademico.programa',
                'softwares',
                'multimedia',
                'portada',
                'profesor',
            ])
            ->where('slug', $slug)
            ->where('estatus', EstatusProyecto::Aprobado->value)
            ->first();

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado o no disponible.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->formatProyecto($proyecto),
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 4. GET /api/ext/programas
    //    Catálogo de programas académicos activos.
    //    Útil para mostrar filtros por carrera en el job board.
    // ──────────────────────────────────────────────────────────────────────────
    public function programas(): JsonResponse
    {
        $programas = ProgramaAcademico::where('estatus', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'abreviatura', 'descripcion']);

        return response()->json([
            'success' => true,
            'total'   => $programas->count(),
            'data'    => $programas,
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 5. GET /api/ext/categorias
    //    Categorías de proyectos que tienen al menos un proyecto aprobado.
    //    Útil para filtros de búsqueda en el job board.
    // ──────────────────────────────────────────────────────────────────────────
    public function categorias(): JsonResponse
    {
        // Obtenemos las categorías de proyectos aprobados a través de materia
        $categoriasIds = Proyecto::where('estatus', EstatusProyecto::Aprobado->value)
            ->with('materia.categoria')
            ->get()
            ->pluck('materia.categoria')
            ->filter()
            ->unique('id')
            ->values()
            ->map(fn ($c) => [
                'id'     => $c->id,
                'nombre' => $c->nombre,
            ]);

        return response()->json([
            'success' => true,
            'total'   => $categoriasIds->count(),
            'data'    => $categoriasIds,
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Helper privado: formatea un proyecto para la respuesta JSON
    // ──────────────────────────────────────────────────────────────────────────
    private function formatProyecto(Proyecto $proyecto, ?string $matriculaFiltro = null): array
    {
        return [
            'id'              => $proyecto->id,
            'slug'            => $proyecto->slug,
            'titulo'          => $proyecto->titulo,
            'descripcion'     => $proyecto->descripcion,
            'periodo'         => $proyecto->periodo_semestral,
            'categoria'       => $proyecto->materia?->categoria?->nombre,
            'materia'         => $proyecto->materia?->nombre,
            'portada_url'     => $proyecto->portada?->url,
            'softwares'       => $proyecto->softwares?->pluck('nombre'),
            'multimedia'      => $proyecto->multimedia?->map(fn ($m) => [
                'tipo'        => $m->tipo,
                'url'         => $m->url,
                'titulo'      => $m->titulo,
                'descripcion' => $m->descripcion,
                'es_portada'  => $m->es_portada,
            ]),
            'autores'         => $proyecto->autores?->map(fn ($a) => [
                'matricula'        => $a->matricula,
                'nombre_completo'  => trim("{$a->nombre} {$a->apellido_paterno} {$a->apellido_materno}"),
                'programa'         => $a->programaAcademico?->abreviatura,
                'semestre'         => $a->semestre,
                'es_lider'         => (bool) $a->pivot->es_lider,
            ]),
            'profesor'        => $proyecto->profesor
                ? trim("{$proyecto->profesor->nombre} {$proyecto->profesor->apellido_paterno} {$proyecto->profesor->apellido_materno}")
                : null,
        ];
    }
}
