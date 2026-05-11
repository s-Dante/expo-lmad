<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Repositories\Admin\DashboardRepositoryInterface;
use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function __construct(
        private readonly DashboardRepositoryInterface $dashboardRepo
    ) {}

    /**
     * Muestra el dashboard del SuperAdmin con datos reales.
     */
    public function dashboard(): View
    {
        $externos = $this->dashboardRepo->getExternosConDesglose();

        return view('superadmin.dashboard', [
            'totalAsistentes'   => $this->dashboardRepo->getTotalAsistentes(),
            'alumnos'           => $this->dashboardRepo->getAlumnosAsistidos(),
            'externos'          => $externos,
            'totalEventos'      => $this->dashboardRepo->getTotalEventos(),
            'totalEmpresas'     => $this->dashboardRepo->getTotalEmpresas(),
            'asistenciaEventos' => $this->dashboardRepo->getAsistenciaPorEvento(),
        ]);
    }

    /**
     * Exporta el reporte completo en Excel (mismo formato que Admin).
     */
    public function exportar(): BinaryFileResponse
    {
        $reporte = $this->dashboardRepo->getReporteCompleto();
        $filename = 'Reporte_ExpoLMAD_SuperAdmin_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new DashboardExport($reporte), $filename);
    }

    public function getDashboardInfo()
    {
        // Mantener por compatibilidad (llamadas AJAX legacy si existen)
        return response()->json([
            'expositores'          => \App\Models\User::where('rol', 'estudiante')->count(),
            'proyectos_total'      => Proyecto::count(),
            'proyectos_aceptados'  => Proyecto::where('estatus', 'aprobado')->count(),
            'proyectos_rechazados' => Proyecto::where('estatus', 'rechazado')->count(),
        ]);
    }

    public function paginaProyectos()
    {
        $materias  = \App\Models\Materia::all();
        $profesores = \App\Models\Profesor::all();

        $proyectosRevision = Proyecto::where('estatus', 'enviado')
            ->with(['materia', 'profesor'])
            ->get();

        $proyectosAprobados = Proyecto::where('estatus', 'aprobado')
            ->with(['materia', 'profesor'])
            ->get();

        return view('superadmin.proyectos', compact('materias', 'profesores', 'proyectosRevision', 'proyectosAprobados'));
    }

    public function paginaRevisionProyecto($id)
    {
        $proyecto = Proyecto::with(['materia', 'profesor', 'autores', 'multimedia'])->findOrFail($id);
        return view('superadmin.revision-proyecto', compact('proyecto'));
    }

    public function actualizarRevisionProyecto(Request $request)
    {
        $proyecto = Proyecto::findOrFail($request->proyecto_id);
        $proyecto->estatus         = $request->accion;
        $proyecto->descripcion     = $request->descripcion;
        $proyecto->retroalimentacion = $request->mensaje;
        $proyecto->save();

        return response()->json([
            'mensaje'  => 'Datos recibidos correctamente',
            'recibido' => $request->all()
        ]);
    }

    public function mandarRevisionProyecto($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->estatus = 'enviado';
        $proyecto->save();

        return response()->json(['mensaje' => 'Proyecto enviado para revisión']);
    }
}
