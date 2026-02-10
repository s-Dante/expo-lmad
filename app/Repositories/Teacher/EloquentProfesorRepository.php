<?php

namespace App\Repositories\Teacher;

use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Profesor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EloquentProfesorRepository implements ProfesorRepositoryInterface
{
    public function crearProyectoConEstudiantes(array $datos, Profesor $profesor): array
    {
        return DB::transaction(function () use ($datos, $profesor) {
            // 1. Generar Código Único
            $codigo = Str::upper(Str::random(15));
            while (Proyecto::where('codigo_acceso', $codigo)->exists()) {
                $codigo = Str::upper(Str::random(15));
            }

            // 2. Crear el Proyecto Base
            $proyecto = Proyecto::create([
                'profesor_id' => $profesor->id,
                'periodo_semestral' => $datos['periodo_semestral'],
                'slug' => Str::slug('proyecto-' . $codigo), // Slug temporal
                'materia_id' => $datos['materia_id'],
                'codigo_acceso' => $codigo,
                'estatus' => 'borrador',
            ]);

            $usuariosNotificar = [];

            // 3. Procesar Estudiantes
            foreach ($datos['estudiantes'] as $index => $estudianteData) {
                // Buscar estudiante existente en tbl_estudiantes
                $estudiante = Estudiante::where('matricula', $estudianteData['matricula'])->first();

                if (!$estudiante) {
                    continue; // O lanzar excepción si es estricto
                }

                // Crear o recuperar Usuario para Login
                $usuario = User::firstOrCreate(
                    ['email' => $estudiante->email],
                    [
                        'name' => $estudiante->matricula,
                        'nombre' => $estudiante->nombre,
                        'apellido_paterno' => $estudiante->apellido_paterno,
                        'apellido_materno' => $estudiante->apellido_materno,
                        'email' => $estudiante->email,
                        'password' => Hash::make($estudiante->matricula),
                        'rol' => 'estudiante',
                        'estatus' => 1,
                    ]
                );

                // Vincular Estudiante con Usuario si no lo estaba
                if (is_null($estudiante->usuario_id)) {
                    $estudiante->update(['usuario_id' => $usuario->id]);
                }

                // Adjuntar a la tabla pivote tbl_autores_proyecto
                // El primero (index 0) es el líder
                $esLider = ($index === 0);
                $proyecto->autores()->attach($estudiante->id, [
                    'es_lider' => $esLider,
                ]);

                // Guardamos usuario para devolverlo y mandar correos despues
                $usuariosNotificar[] = [
                    'user' => $usuario,
                    'es_lider' => $esLider
                ];
            }

            // 4. Crear Placeholder Multimedia
            $proyecto->multimedia()->create([
                'tipo' => 'imagen',
                'url' => '', // Se llenará cuando el alumno suba el poster
                'titulo' => 'Pendiente...',
                'es_portada' => true,
            ]);

            return [
                'proyecto' => $proyecto,
                'codigo' => $codigo,
                'usuarios' => $usuariosNotificar
            ];
        });
    }
}