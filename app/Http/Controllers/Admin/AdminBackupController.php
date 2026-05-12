<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

/**
 * Exporta e importa la base de datos y los archivos de storage.
 *
 * Rutas (bajo middleware auth + role:admin):
 *   GET  /admin/backup                → vista con botones
 *   GET  /admin/backup/exportar-sql   → descarga .sql con toda la BD
 *   GET  /admin/backup/exportar-storage → descarga .zip con storage/app/public
 *   POST /admin/backup/importar-sql   → sube un .sql y lo ejecuta
 */
class AdminBackupController extends Controller
{
    // ──────────────────────────────────────────────────────────────────────────
    // Vista principal
    // ──────────────────────────────────────────────────────────────────────────
    public function index()
    {
        return view('admin.backup');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Exportar base de datos completa como archivo .sql
    // Intenta primero con mysqldump; si no está disponible usa el dump PHP puro.
    // ──────────────────────────────────────────────────────────────────────────
    public function exportarSQL()
    {
        $filename = 'expo_lmad_bd_' . now()->format('Y-m-d_His') . '.sql';

        $sql = $this->generarSQL();

        return response($sql, 200, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length'      => strlen($sql),
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Exportar carpeta storage/app/public como .zip
    // ──────────────────────────────────────────────────────────────────────────
    public function exportarStorage()
    {
        $storageDir = storage_path('app/public');
        $zipPath    = storage_path('app/private/storage_backup_' . now()->format('Y-m-d_His') . '.zip');

        if (!is_dir($storageDir)) {
            return back()->with('backup_error', 'La carpeta de storage está vacía o no existe todavía.');
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('backup_error', 'No se pudo crear el archivo ZIP.');
        }

        $this->agregarCarpetaAZip($zip, $storageDir, 'storage');
        $zip->close();

        return response()->download($zipPath, basename($zipPath))->deleteFileAfterSend(true);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Importar un archivo .sql subido y ejecutarlo contra la BD actual.
    // ──────────────────────────────────────────────────────────────────────────
    public function importarSQL(Request $request)
    {
        $request->validate([
            'archivo_sql' => 'required|file|mimes:sql,txt|max:102400', // máx 100 MB
        ], [
            'archivo_sql.required' => 'Selecciona un archivo .sql para importar.',
            'archivo_sql.mimes'    => 'El archivo debe ser .sql o .txt.',
            'archivo_sql.max'      => 'El archivo no puede superar los 100 MB.',
        ]);

        $contenido = file_get_contents($request->file('archivo_sql')->getRealPath());

        if (empty(trim($contenido))) {
            return back()->with('backup_error', 'El archivo SQL está vacío.');
        }

        try {
            // Deshabilitar foreign key checks durante la importación
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::unprepared($contenido);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return back()->with('backup_exito', 'Base de datos importada correctamente.');
        } catch (\Throwable $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return back()->with('backup_error', 'Error al ejecutar el SQL: ' . $e->getMessage());
        }
    }

    // ──────────────────────────────────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Genera el SQL completo de la BD usando PDO (sin depender de mysqldump).
     * Exporta el esquema (CREATE TABLE) y todos los datos (INSERT INTO).
     */
    private function generarSQL(): string
    {
        $pdo      = DB::getPdo();
        $database = config('database.connections.mysql.database');
        $lines    = [];

        $lines[] = '-- ============================================================';
        $lines[] = '-- Expo LMAD — Backup completo de base de datos';
        $lines[] = '-- Generado: ' . now()->toDateTimeString();
        $lines[] = '-- Base de datos: ' . $database;
        $lines[] = '-- ============================================================';
        $lines[] = '';
        $lines[] = 'SET NAMES utf8mb4;';
        $lines[] = 'SET FOREIGN_KEY_CHECKS = 0;';
        $lines[] = '';

        // Lista de todas las tablas
        $tablas = $pdo->query("SHOW TABLES FROM `{$database}`")->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tablas as $tabla) {
            $lines[] = "-- ----------------------------------------------------------";
            $lines[] = "-- Tabla: `{$tabla}`";
            $lines[] = "-- ----------------------------------------------------------";

            // Esquema: DROP + CREATE
            $createRow = $pdo->query("SHOW CREATE TABLE `{$tabla}`")->fetch(\PDO::FETCH_ASSOC);
            $createSQL = $createRow['Create Table'] ?? $createRow[array_key_last($createRow)];

            $lines[] = "DROP TABLE IF EXISTS `{$tabla}`;";
            $lines[] = $createSQL . ';';
            $lines[] = '';

            // Datos: INSERT en lotes de 500 filas
            $stmt = $pdo->query("SELECT * FROM `{$tabla}`");
            $filas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (!empty($filas)) {
                $columnas = '`' . implode('`, `', array_keys($filas[0])) . '`';
                $lotes    = array_chunk($filas, 500);

                foreach ($lotes as $lote) {
                    $valores = array_map(function ($fila) use ($pdo) {
                        $vals = array_map(function ($v) use ($pdo) {
                            return $v === null ? 'NULL' : $pdo->quote((string) $v);
                        }, array_values($fila));
                        return '(' . implode(', ', $vals) . ')';
                    }, $lote);

                    $lines[] = "INSERT INTO `{$tabla}` ({$columnas}) VALUES";
                    $lines[] = implode(",\n", $valores) . ';';
                }
                $lines[] = '';
            }
        }

        $lines[] = 'SET FOREIGN_KEY_CHECKS = 1;';
        $lines[] = '';
        $lines[] = '-- Fin del backup';

        return implode("\n", $lines);
    }

    /**
     * Agrega recursivamente una carpeta al ZipArchive.
     */
    private function agregarCarpetaAZip(ZipArchive $zip, string $dir, string $prefix): void
    {
        $archivos = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($archivos as $archivo) {
            if (!$archivo->isDir()) {
                $rutaReal     = $archivo->getRealPath();
                $rutaRelativa = $prefix . '/' . substr($rutaReal, strlen($dir) + 1);
                $zip->addFile($rutaReal, $rutaRelativa);
            }
        }
    }
}
