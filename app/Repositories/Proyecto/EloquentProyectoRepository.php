<?php

declare(strict_types=1);

namespace App\Repositories\Proyecto;

use App\Models\Proyecto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EloquentProyectoRepository implements ProyectoRepositoryInterface
{
    /**
     * Obtiene los proyectos paginados para la galería del protafolio
     */
    public function obtenerParaGaleria(?string $categoria = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Proyecto::query()
            // 1. Corregido: Usamos 'aprobado' según tu ENUM en la migración
            ->where('estatus', 'aprobado') 
            ->with([
                'materia:id,nombre', // Traemos solo lo necesario
                'portada'            // Eager loading de la imagen
            ])
            ->latest(); 

        // 2. Corregido: Filtramos directamente sobre la tabla proyectos
        // Ya no necesitamos 'whereHas' porque agregaste el campo 'categoria' al proyecto.
        if ($categoria && $categoria !== 'todos') {
            $query->where('categoria', $categoria);
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
            ->where('estatus', 'aprobado') // Seguridad: solo mostramos aprobados
            ->with([
                'materia',           // Para ver de qué materia es
                'profesor',          // Quién lo supervisó
                'autores',           // Estudiantes (incluye pivot es_lider)
                'multimedia',        // Todas las fotos/videos (no solo la portada)
                'softwares'          // Iconos de software usado
            ])
            ->first();
    }
}