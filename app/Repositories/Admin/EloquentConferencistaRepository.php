<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Conferencista;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementación Eloquent del repositorio de Conferencistas.
 */
class EloquentConferencistaRepository implements ConferencistaRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return Conferencista::with('eventos')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllForDropdown(): Collection
    {
        return Conferencista::select('id', 'nombre', 'apellido_paterno', 'apellido_materno', 'nickname', 'empresa')
            ->where('estatus', true)
            ->orderBy('nombre')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Conferencista
    {
        return Conferencista::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Conferencista $conferencista, array $data): Conferencista
    {
        $conferencista->update($data);
        return $conferencista->fresh();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Conferencista $conferencista): void
    {
        $conferencista->delete();
    }
}
