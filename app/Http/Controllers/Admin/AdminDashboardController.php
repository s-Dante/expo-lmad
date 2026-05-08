<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\DashboardRepositoryInterface;
use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

/**
 * Controlador para el Dashboard admin con KPIs.
 */
class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly DashboardRepositoryInterface $dashboardRepo
    ) {}

    /**
     * Muestra el dashboard con métricas en tiempo real.
     */
    public function index(): View
    {
        $externos = $this->dashboardRepo->getExternosConDesglose();

        return view('admin.dashboard', [
            'totalAsistentes'     => $this->dashboardRepo->getTotalAsistentes(),
            'alumnos'             => $this->dashboardRepo->getAlumnosAsistidos(),
            'externos'            => $externos,
            'totalEventos'        => $this->dashboardRepo->getTotalEventos(),
            'totalConferencistas' => $this->dashboardRepo->getTotalConferencistas(),
            'totalEmpresas'       => $this->dashboardRepo->getTotalEmpresas(),
            'asistenciaEventos'   => $this->dashboardRepo->getAsistenciaPorEvento(),
        ]);
    }

    /**
     * Exporta el reporte del dashboard en formato Excel con múltiples pestañas.
     */
    public function exportar(): BinaryFileResponse
    {
        $reporte = $this->dashboardRepo->getReporteCompleto();
        $filename = 'Reporte_ExpoLMAD_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new DashboardExport($reporte), $filename);
    }
}
