<?php

declare(strict_types=1);

namespace App\Repositories\Proyecto;

use App\Models\Proyecto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder; // <--- Importante para el type hinting del whereHas

class EloquentProyectoRepository implements ProyectoRepositoryInterface
{
    /**
     * Obtiene los proyectos paginados para la galería del portafolio
     */
    public function obtenerParaGaleria(?string $categoriaSlug = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Proyecto::query()
            ->where('estatus', 'aprobado') 
            ->with([
                // Carga la materia Y su categoría (para mostrar "Videojuegos" en la tarjeta del proyecto)
                'materia.categoria', 
                'portada'
            ])
            ->latest(); 

        // CAMBIO PRINCIPAL: Filtrado por relación
        if ($categoriaSlug && $categoriaSlug !== 'todos') {
            // "Fíltrame los proyectos DONDE la relación 'materia' -> 'categoria' tenga un slug igual a..."
            $query->whereHas('materia.categoria', function (Builder $q) use ($categoriaSlug) {
                $q->where('slug', $categoriaSlug);
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Obtiene el detalle de un proyecto en especifico
     */
    public function obtenerDetallePorSlug(string $slug): ?Proyecto
    {
        return Proyecto::query()
            ->where('slug', $slug)
            ->where('estatus', 'aprobado')
            ->with([
                'materia.categoria', // <-- Necesario para mostrar la categoría en el detalle
                'profesor',
                'autores',
                'multimedia',
                'softwares'
            ])
            ->first();
    }
}