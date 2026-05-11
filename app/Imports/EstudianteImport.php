<?php

namespace App\Imports;

use App\Models\Estudiante;
use App\Models\ProgramaAcademico;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

/**
 * Importa padrón de estudiantes desde Excel.
 *
 * Formato de columnas (primera fila = encabezado):
 * | matricula | nombre | apellido_paterno | apellido_materno | semestre | email | programa_abreviatura |
 *
 * - matricula            (requerido) Matrícula única UANL, Ej: "1985623"
 * - nombre               (requerido)
 * - apellido_paterno     (requerido)
 * - apellido_materno     (opcional)
 * - semestre             (requerido) Número entero del 1 al 12
 * - email                (opcional)  Ej: "1985623@uanl.edu.mx"
 * - programa_abreviatura (requerido) Abreviatura del programa, Ej: "LMAD"
 */
class EstudianteImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    private array $cacheProgramas = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $matricula    = trim((string)($row['matricula'] ?? ''));
            $nombre       = trim($row['nombre'] ?? '');
            $apellidoPat  = trim($row['apellido_paterno'] ?? '');
            $apellidoMat  = trim($row['apellido_materno'] ?? '') ?: null;
            $semestre     = (int)($row['semestre'] ?? 0);
            $email        = strtolower(trim($row['email'] ?? '')) ?: null;
            $abreviatura  = strtoupper(trim($row['programa_abreviatura'] ?? ''));

            if (!$matricula || !$nombre || !$apellidoPat || !$semestre || !$abreviatura) {
                $this->errores[] = "Fila " . ($i + 2) . ": faltan campos requeridos (matricula, nombre, apellido_paterno, semestre, programa_abreviatura).";
                continue;
            }

            // Resolver programa académico
            if (!isset($this->cacheProgramas[$abreviatura])) {
                $this->cacheProgramas[$abreviatura] = ProgramaAcademico::where('abreviatura', $abreviatura)->first();
            }
            $programa = $this->cacheProgramas[$abreviatura];

            if (!$programa) {
                $this->errores[] = "Fila " . ($i + 2) . ": Programa '{$abreviatura}' no encontrado. Impórtalo primero.";
                continue;
            }

            try {
                $existente = Estudiante::where('matricula', $matricula)->first();

                if ($existente) {
                    $existente->update([
                        'nombre'                => $nombre,
                        'apellido_paterno'      => $apellidoPat,
                        'apellido_materno'      => $apellidoMat,
                        'semestre'              => $semestre,
                        'email'                 => $email ?? $existente->email,
                        'programa_academico_id' => $programa->id,
                    ]);
                    $this->actualizados++;
                } else {
                    Estudiante::create([
                        'matricula'             => $matricula,
                        'nombre'                => $nombre,
                        'apellido_paterno'      => $apellidoPat,
                        'apellido_materno'      => $apellidoMat,
                        'semestre'              => $semestre,
                        'email'                 => $email,
                        'programa_academico_id' => $programa->id,
                    ]);
                    $this->importados++;
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": Error de base de datos - " . $e->getMessage();
            }
        }
    }
}
