<?php

namespace App\Imports;

use App\Models\Profesor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

/**
 * Importa padrón de profesores desde Excel.
 *
 * | numero_empleado | nombre | apellido_paterno | apellido_materno | email | materias |
 *
 * - numero_empleado  (opcional) Número único de empleado UANL. Si no se provee, se auto-genera.
 * - nombre           (requerido)
 * - apellido_paterno (requerido)
 * - apellido_materno (opcional)
 * - email            (opcional) Correo institucional
 * - materias         (opcional) Lista separada por comas de claves, nombres o abreviaturas de materias
 */
class ProfesorImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $nombre         = trim($row['nombre'] ?? '');
            $apellidoPat    = trim($row['apellido_paterno'] ?? '');
            $apellidoMat    = trim($row['apellido_materno'] ?? '') ?: null;
            $email          = strtolower(trim($row['email'] ?? '')) ?: null;
            $numEmpleado    = trim((string)($row['numero_empleado'] ?? ''));
            $materiasStr    = trim((string)($row['materias'] ?? '')); // Comma-separated list

            if (!$nombre || !$apellidoPat) {
                $this->errores[] = "Fila " . ($i + 2) . ": nombre y apellido_paterno son requeridos.";
                continue;
            }

            // Si no hay num_empleado, buscamos por nombre completo
            $query = Profesor::query();
            if ($numEmpleado) {
                $query->where('numero_empleado', $numEmpleado);
            } else {
                $query->where('nombre', $nombre)
                      ->where('apellido_paterno', $apellidoPat)
                      ->where('apellido_materno', $apellidoMat);
            }

            try {
                $existente = $query->first();

                // Si no se proporcionó numEmpleado y no existe en DB, generamos uno dummy
                if (!$numEmpleado && !$existente) {
                    $numEmpleado = 'EMP-' . strtoupper(substr($nombre, 0, 2) . substr($apellidoPat, 0, 2)) . '-' . rand(1000, 9999);
                }

                if ($existente) {
                    $existente->update([
                        'nombre'           => $nombre,
                        'apellido_paterno' => $apellidoPat,
                        'apellido_materno' => $apellidoMat,
                        'email'            => $email ?? $existente->email,
                    ]);
                    $profesor = $existente;
                    $this->actualizados++;
                } else {
                    $profesor = Profesor::create([
                        'numero_empleado'  => $numEmpleado ?: $existente->numero_empleado, // Asegurar que tenga uno
                        'nombre'           => $nombre,
                        'apellido_paterno' => $apellidoPat,
                        'apellido_materno' => $apellidoMat,
                        'email'            => $email,
                    ]);
                    $this->importados++;
                }

                // Sync Materias y Programas
                if ($materiasStr) {
                    // Si el campo dice "todas", se liga con todas las materias de la BD
                    if (strtolower($materiasStr) === 'todas') {
                        $materiasDb = \App\Models\Materia::with('planAcademico')->get();
                    } else {
                        $nombresMaterias = array_map('trim', explode(',', $materiasStr));

                        // Buscar materias por nombre, clave o abreviatura
                        $materiasDb = \App\Models\Materia::with('planAcademico')
                            ->where(function ($q) use ($nombresMaterias) {
                                $q->whereIn('nombre', $nombresMaterias)
                                  ->orWhereIn('clave', $nombresMaterias)
                                  ->orWhereIn('abreviatura', $nombresMaterias);
                            })
                            ->get();
                    }

                    if ($materiasDb->count() > 0) {
                        // Sincronizar materias
                        $profesor->materias()->syncWithoutDetaching($materiasDb->pluck('id')->toArray());

                        // Sincronizar programas académicos basándose en las materias
                        $programasIds = $materiasDb->pluck('planAcademico.programa_academico_id')->filter()->unique()->toArray();
                        if (!empty($programasIds)) {
                            $profesor->programasAcademicos()->syncWithoutDetaching($programasIds);
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": Error de base de datos - " . $e->getMessage();
            }
        }
    }
}
