<?php

namespace App\Imports;

use App\Models\Materia;
use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;
use App\Models\Categoria;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

/**
 * Importa catálogo de materias desde Excel.
 *
 * Formato de columnas (primera fila = encabezado):
 * | clave | nombre | abreviatura | descripcion | creditos | semestre | plan_nombre | programa_abreviatura | categoria_nombre |
 *
 * - clave                (opcional)  Clave SIASE de la materia
 * - nombre               (requerido)
 * - abreviatura          (opcional)  Siglas cortas de la materia
 * - descripcion          (opcional)
 * - creditos             (requerido) Número entero
 * - semestre             (requerido) Número entero del 1 al 12
 * - plan_nombre          (requerido) Nombre exacto del plan, Ej: "Plan 2019"
 * - programa_abreviatura (requerido) Abreviatura del programa, Ej: "LMAD"
 * - categoria_nombre     (requerido) Nombre de la categoría. Si no existe, se crea automáticamente.
 */
class MateriaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    private array $cachePlanes     = [];
    private array $cacheProgramas  = [];
    private array $cacheCategorias = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $clave        = trim($row['clave'] ?? '') ?: null;
            $nombre       = trim($row['nombre'] ?? '');
            $abreviatura  = trim($row['abreviatura'] ?? '') ?: null;
            $descripcion  = trim($row['descripcion'] ?? '') ?: null;
            $creditos     = (int)($row['creditos'] ?? 0);
            $semestre     = (int)($row['semestre'] ?? 0);
            $planNombre   = trim($row['plan_nombre'] ?? '');
            $abrevProg    = strtoupper(trim($row['programa_abreviatura'] ?? ''));
            $catNombre    = trim($row['categoria_nombre'] ?? '');

            if (!$nombre || !$creditos || !$semestre || !$planNombre || !$abrevProg || !$catNombre) {
                $this->errores[] = "Fila " . ($i + 2) . ": faltan campos requeridos (nombre, creditos, semestre, plan_nombre, programa_abreviatura, categoria_nombre).";
                continue;
            }

            // Resolver programa académico
            if (!isset($this->cacheProgramas[$abrevProg])) {
                $this->cacheProgramas[$abrevProg] = ProgramaAcademico::where('abreviatura', $abrevProg)->first();
            }
            $programa = $this->cacheProgramas[$abrevProg];

            if (!$programa) {
                $this->errores[] = "Fila " . ($i + 2) . ": Programa '{$abrevProg}' no encontrado.";
                continue;
            }

            // Resolver plan académico
            $cacheKeyPlan = $abrevProg . '::' . $planNombre;
            if (!isset($this->cachePlanes[$cacheKeyPlan])) {
                $this->cachePlanes[$cacheKeyPlan] = PlanAcademico::where('nombre', $planNombre)
                    ->where('programa_academico_id', $programa->id)
                    ->first();
            }
            $plan = $this->cachePlanes[$cacheKeyPlan];

            if (!$plan) {
                $this->errores[] = "Fila " . ($i + 2) . ": Plan '{$planNombre}' no encontrado para el programa '{$abrevProg}'.";
                continue;
            }

            // Resolver (o crear) categoría
            if (!isset($this->cacheCategorias[$catNombre])) {
                $this->cacheCategorias[$catNombre] = Categoria::firstOrCreate(
                    ['slug' => Str::slug($catNombre)],
                    ['nombre' => $catNombre]
                );
            }
            $categoria = $this->cacheCategorias[$catNombre];

            try {
                // Buscar materia existente por clave + plan, o por nombre + plan
                $existente = null;
                if ($clave) {
                    $existente = Materia::where('clave', $clave)
                        ->where('plan_academico_id', $plan->id)
                        ->first();
                }
                if (!$existente) {
                    $existente = Materia::where('nombre', $nombre)
                        ->where('plan_academico_id', $plan->id)
                        ->first();
                }

                $datos = [
                    'clave'           => $clave,
                    'nombre'          => $nombre,
                    'abreviatura'     => $abreviatura,
                    'descripcion'     => $descripcion,
                    'creditos'        => $creditos,
                    'semestre'        => $semestre,
                    'plan_academico_id'=> $plan->id,
                    'categoria_id'    => $categoria->id,
                ];

                if ($existente) {
                    $existente->update($datos);
                    $this->actualizados++;
                } else {
                    Materia::create($datos);
                    $this->importados++;
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": Error de base de datos - " . $e->getMessage();
            }
        }
    }
}
