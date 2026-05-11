<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Implementación Eloquent del repositorio de Eventos.
 */
class EloquentEventoRepository implements EventoRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return Evento::with('conferencistas')
            ->orderBy('fecha_inicio_evento', 'desc')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Evento
    {
        $data['slug'] = Str::slug($data['titulo'] . '-' . Str::random(5));

        return Evento::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Evento $evento, array $data): Evento
    {
        // Solo regenerar slug si cambió el título
        if (isset($data['titulo']) && $data['titulo'] !== $evento->titulo) {
            $data['slug'] = Str::slug($data['titulo'] . '-' . Str::random(5));
        }

        $evento->update($data);
        return $evento->fresh();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Evento $evento): void
    {
        $evento->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function syncConferencistas(Evento $evento, array $ids): void
    {
        $evento->conferencistas()->sync($ids);
    }
}
