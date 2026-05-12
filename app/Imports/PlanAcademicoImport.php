<?php

namespace App\Imports;

use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

/**
 * Importa planes académicos desde Excel.
 *
 * Formato de columnas (primera fila = encabezado):
 * | nombre | programa_abreviatura |
 *
 * - nombre               (requerido) Ej: "Plan 2019"
 * - programa_abreviatura (requerido) Abreviatura del programa padre, Ej: "LMAD"
 */
class PlanAcademicoImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    /** Cache de programas para evitar N queries */
    private array $cacheProgramas = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $nombre       = trim($row['nombre'] ?? '');
            $abreviatura  = strtoupper(trim($row['programa_abreviatura'] ?? ''));

            if (!$nombre || !$abreviatura) {
                $this->errores[] = "Fila " . ($i + 2) . ": nombre y programa_abreviatura son requeridos.";
                continue;
            }

            // Resolver programa académico por abreviatura
            if (!isset($this->cacheProgramas[$abreviatura])) {
                $this->cacheProgramas[$abreviatura] = ProgramaAcademico::where('abreviatura', $abreviatura)->first();
            }
            $programa = $this->cacheProgramas[$abreviatura];

            if (!$programa) {
                $this->errores[] = "Fila " . ($i + 2) . ": No se encontró el programa '{$abreviatura}'. Impórtalo primero.";
                continue;
            }

            try {
                // withTrashed() para detectar registros soft-deleted que bloquean el unique index
                $existente = PlanAcademico::withTrashed()
                    ->where('nombre', $nombre)
                    ->where('programa_academico_id', $programa->id)
                    ->first();

                if ($existente) {
                    if ($existente->trashed()) {
                        $existente->restore();
                    }
                    $existente->update(['estatus' => true]);
                    $this->actualizados++;
                } else {
                    PlanAcademico::create([
                        'nombre'               => $nombre,
                        'programa_academico_id' => $programa->id,
                        'estatus'              => true,
                    ]);
                    $this->importados++;
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
            }
        }
    }
}
