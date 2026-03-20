<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\DashboardRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
     * Exporta el reporte del dashboard.
     * Por ahora exporta como CSV; se migrará a Excel con Maatwebsite cuando se instale.
     */
    public function exportar(): Response
    {
        $reporte = $this->dashboardRepo->getReporteCompleto();

        $csvContent = "\xEF\xBB\xBF"; // BOM para UTF-8

        // Resumen de Asistencias
        $csvContent .= "--- RESUMEN DE ASISTENCIAS ---\n";
        $csvContent .= "Categoría,Total\n";
        $csvContent .= "Total de asistidos,{$reporte['total_asistentes']}\n";
        $csvContent .= "Alumnos,{$reporte['alumnos']}\n";
        $csvContent .= "Externos,{$reporte['externos']['total']}\n";
        $csvContent .= "Masculino,{$reporte['externos']['masculino']}\n";
        $csvContent .= "Femenino,{$reporte['externos']['femenino']}\n";
        $csvContent .= "No binario,{$reporte['externos']['otro']}\n\n";

        // Datos Generales
        $csvContent .= "--- DATOS GENERALES ---\n";
        $csvContent .= "Categoría,Total\n";
        $csvContent .= "Eventos,{$reporte['total_eventos']}\n";
        $csvContent .= "Expositores,{$reporte['total_conferencistas']}\n";
        $csvContent .= "Empresas,{$reporte['total_empresas']}\n\n";

        // Asistencia por Conferencia
        $csvContent .= "--- ASISTENCIA POR CONFERENCIA ---\n";
        $csvContent .= "Conferencia,Asistentes\n";
        foreach ($reporte['asistencia_eventos'] as $evento) {
            $titulo = str_replace('"', '""', $evento['titulo']);
            $csvContent .= "\"{$titulo}\",{$evento['asistentes']}\n";
        }

        $filename = 'Reporte_ExpoLMAD_' . date('Y-m-d') . '.csv';

        return response($csvContent, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
