<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\AsistenciaGeneral;
use App\Models\Conferencista;
use App\Models\Evento;
use App\Models\Patrocinador;
use App\Models\Visitante;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Contrato para datos del Dashboard admin.
 */
interface DashboardRepositoryInterface
{
    public function getTotalAsistentes(): int;
    public function getAlumnosAsistidos(): int;
    public function getExternosConDesglose(): array;
    public function getTotalEventos(): int;
    public function getTotalConferencistas(): int;
    public function getTotalEmpresas(): int;
    public function getAsistenciaPorEvento(): Collection;
    public function getEventosDetallados(): Collection;
    public function getExpositoresDetallados(): Collection;
    public function getPatrocinadoresDetallados(): Collection;
    public function getReporteCompleto(): array;
}
