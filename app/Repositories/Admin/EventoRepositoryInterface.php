<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Collection;

/**
 * Contrato para operaciones CRUD de Eventos.
 */
interface EventoRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): Evento;
    public function update(Evento $evento, array $data): Evento;
    public function delete(Evento $evento): void;
    public function syncConferencistas(Evento $evento, array $ids): void;
}
