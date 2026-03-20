<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Patrocinador;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementación Eloquent del repositorio de Patrocinadores.
 */
class EloquentPatrocinadorRepository implements PatrocinadorRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return Patrocinador::with('representantes')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllForDropdown(): Collection
    {
        return Patrocinador::select('id', 'nombre', 'tier')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Patrocinador
    {
        return Patrocinador::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Patrocinador $patrocinador, array $data): Patrocinador
    {
        $patrocinador->update($data);
        return $patrocinador->fresh();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Patrocinador $patrocinador): void
    {
        $patrocinador->delete();
    }
}
