<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Conferencista;
use App\Models\Evento;
use App\Models\Patrocinador;
use App\Models\Visitante;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Implementación Eloquent para datos del Dashboard admin.
 */
class EloquentDashboardRepository implements DashboardRepositoryInterface
{
    /**
     * Total de visitantes registrados (asistencia general).
     */
    public function getTotalAsistentes(): int
    {
        return Visitante::count();
    }

    /**
     * Total de visitantes que son alumnos.
     */
    public function getAlumnosAsistidos(): int
    {
        return Visitante::where('tipo', 'estudiante')->count();
    }

    /**
     * Externos con desglose por género.
     *
     * @return array{total: int, masculino: int, femenino: int, otro: int}
     */
    public function getExternosConDesglose(): array
    {
        $externos = Visitante::where('tipo', 'externo')->get();

        return [
            'total'     => $externos->count(),
            'masculino' => $externos->where('genero', 'M')->count(),
            'femenino'  => $externos->where('genero', 'F')->count(),
            'otro'      => $externos->where('genero', 'O')->count(),
        ];
    }

    /**
     * Cuenta total de eventos.
     */
    public function getTotalEventos(): int
    {
        return Evento::count();
    }

    /**
     * Cuenta total de conferencistas activos.
     */
    public function getTotalConferencistas(): int
    {
        return Conferencista::where('estatus', true)->count();
    }

    /**
     * Cuenta total de empresas/patrocinadores.
     */
    public function getTotalEmpresas(): int
    {
        return Patrocinador::count();
    }

    /**
     * Asistencia por evento para la tabla del dashboard.
     */
    public function getAsistenciaPorEvento(): Collection
    {
        return Evento::select('id', 'titulo')
            ->withCount('visitantes as total_asistentes')
            ->orderBy('total_asistentes', 'desc')
            ->get()
            ->map(fn($e) => [
                'titulo'    => $e->titulo,
                'asistentes' => $e->total_asistentes ?? 0,
            ]);
    }

    /**
     * Reporte detallado de eventos con sus asistentes.
     */
    public function getEventosDetallados(): Collection
    {
        return Evento::with('visitantes')->get();
    }

    /**
     * Listado completo de conferencistas.
     */
    public function getExpositoresDetallados(): Collection
    {
        return Conferencista::all();
    }

    /**
     * Listado completo de patrocinadores.
     */
    public function getPatrocinadoresDetallados(): Collection
    {
        return Patrocinador::all();
    }

    /**
     * Reporte completo para exportación.
     */
    public function getReporteCompleto(): array
    {
        return [
            'summary' => [
                'total_asistentes'     => $this->getTotalAsistentes(),
                'total_estudiantes'    => $this->getAlumnosAsistidos(),
                'total_externos'       => $this->getExternosConDesglose()['total'],
                'total_eventos'        => $this->getTotalEventos(),
                'total_conferencistas' => $this->getTotalConferencistas(),
                'total_patrocinadores' => $this->getTotalEmpresas(),
            ],
            'events'            => $this->getEventosDetallados(),
            'conferencistas'    => $this->getExpositoresDetallados(),
            'patrocinadores'    => $this->getPatrocinadoresDetallados(),
        ];
    }
}
