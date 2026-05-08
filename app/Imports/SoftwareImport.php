<?php

namespace App\Imports;

use App\Models\Software;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

/**
 * Importa catálogo de softwares desde Excel.
 *
 * Formato de columnas (primera fila = encabezado):
 * | nombre | descripcion |
 *
 * - nombre      (requerido) Nombre único del software, Ej: "Unity 2022"
 * - descripcion (opcional)
 */
class SoftwareImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errores = [];
    public int   $importados = 0;
    public int   $actualizados = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $nombre      = trim($row['nombre'] ?? '');
            $descripcion = trim($row['descripcion'] ?? '') ?: null;

            if (!$nombre) continue;

            try {
                $existente = Software::where('nombre', $nombre)->first();

                if ($existente) {
                    $existente->update(['descripcion' => $descripcion]);
                    $this->actualizados++;
                } else {
                    Software::create([
                        'nombre'      => $nombre,
                        'descripcion' => $descripcion,
                        'estatus'     => true,
                    ]);
                    $this->importados++;
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($i + 2) . ": Error de base de datos - " . $e->getMessage();
            }
        }
    }
}
