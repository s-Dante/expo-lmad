<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\EstudianteImport;
use App\Imports\MateriaImport;
use App\Imports\PlanAcademicoImport;
use App\Imports\ProfesorImport;
use App\Imports\ProgramaAcademicoImport;
use App\Imports\SoftwareImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controlador para la importación masiva de datos desde archivos Excel.
 *
 * Cada endpoint acepta un archivo .xlsx / .xls / .csv y pobla la tabla
 * correspondiente. Los registros existentes se ACTUALIZAN (upsert), los
 * nuevos se INSERTAN.
 *
 * ORDEN RECOMENDADO de importación (por dependencias):
 *  1. Programas Académicos
 *  2. Planes Académicos     (depende de Programas)
 *  3. Softwares
 *  4. Profesores
 *  5. Estudiantes           (depende de Programas)
 *  6. Materias              (depende de Planes + Categorías)
 */
class AdminImportController extends Controller
{
    /** Vista principal de importación */
    public function index(): View
    {
        return view('admin.importar');
    }

    // ── PROGRAMAS ACADÉMICOS ─────────────────────────────────────────────────
    public function importarProgramas(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new ProgramaAcademicoImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('programas', $import);
    }

    // ── PLANES ACADÉMICOS ─────────────────────────────────────────────────────
    public function importarPlanes(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new PlanAcademicoImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('planes', $import);
    }

    // ── SOFTWARES ────────────────────────────────────────────────────────────
    public function importarSoftwares(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new SoftwareImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('softwares', $import);
    }

    // ── PROFESORES ───────────────────────────────────────────────────────────
    public function importarProfesores(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new ProfesorImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('profesores', $import);
    }

    // ── ESTUDIANTES ──────────────────────────────────────────────────────────
    public function importarEstudiantes(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new EstudianteImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('estudiantes', $import);
    }

    // ── MATERIAS ─────────────────────────────────────────────────────────────
    public function importarMaterias(Request $request): RedirectResponse
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120']);

        $import = new MateriaImport();
        Excel::import($import, $request->file('archivo'));

        return $this->respuesta('materias', $import);
    }

    // ── Helper ───────────────────────────────────────────────────────────────
    private function respuesta(string $tipo, object $import): RedirectResponse
    {
        $msg = "✅ {$import->importados} registro(s) importados, {$import->actualizados} actualizados.";

        if (!empty($import->errores)) {
            $errTxt = implode(' | ', array_slice($import->errores, 0, 5));
            if (count($import->errores) > 5) {
                $errTxt .= ' ... y ' . (count($import->errores) - 5) . ' errores más.';
            }
            return redirect()
                ->route('admin.importar')
                ->with('import_success_' . $tipo, $msg)
                ->with('import_errors_'  . $tipo, $errTxt);
        }

        return redirect()
            ->route('admin.importar')
            ->with('import_success_' . $tipo, $msg);
    }
}
