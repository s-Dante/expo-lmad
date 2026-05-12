<?php

namespace App\Imports;

use App\Models\ProgramaAcademico;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Importa programas académicos desde Excel.
 *
 * Formato de columnas (primera fila = encabezado):
 * | nombre | abreviatura | descripcion |
 *
 * - nombre       (requerido) Nombre completo del programa
 * - abreviatura  (requerido) Siglas únicas, máx 10 caracteres
 * - descripcion  (opcional)
 */
class ProgramaAcademicoImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $nombre      = trim($row['nombre'] ?? '');
            $abreviatura = strtoupper(trim($row['abreviatura'] ?? ''));
            $descripcion = trim($row['descripcion'] ?? '') ?: null;

            if (!$nombre || !$abreviatura) continue;

            try {
                // Buscar con withTrashed() para detectar registros soft-deleted
                // que siguen ocupando el índice único en la BD.
                $existente = ProgramaAcademico::withTrashed()
                    ->where('abreviatura', $abreviatura)
                    ->first();

                // Si no lo encontramos por abreviatura, buscar por nombre
                // (puede que cambiaron la abreviatura pero el nombre es el mismo)
                if (!$existente) {
                    $existente = ProgramaAcademico::withTrashed()
                        ->where('nombre', $nombre)
                        ->first();
                }

                if ($existente) {
                    // Restaurar si estaba eliminado
                    if ($existente->trashed()) {
                        $existente->restore();
                    }
                    $existente->update([
                        'nombre'      => $nombre,
                        'abreviatura' => $abreviatura,
                        'descripcion' => $descripcion,
                        'estatus'     => true,
                    ]);
                    $this->actualizados++;
                } else {
                    ProgramaAcademico::create([
                        'nombre'      => $nombre,
                        'abreviatura' => $abreviatura,
                        'descripcion' => $descripcion,
                        'estatus'     => true,
                    ]);
                    $this->importados++;
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
            }
        }
    }

    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:255',
            'abreviatura' => 'required|string|max:10',
        ];
    }
}
