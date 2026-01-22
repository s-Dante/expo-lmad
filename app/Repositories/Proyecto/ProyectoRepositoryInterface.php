<?php

declare(strict_types=1);

namespace App\Repositories\Proyecto;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProyectoRepositoryInterface
{
    /**
     * Obtiene los proyectos paginados para la galería pública.
     * Filtra por categoría si se proporciona.
     */
    public function obtenerParaGaleria(?string $categoria = null, int $perPage = 12): LengthAwarePaginator;

    public function obtenerDetallePorSlug(string $slug): ?\App\Models\Proyecto;
}
