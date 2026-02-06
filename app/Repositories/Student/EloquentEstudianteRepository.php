<?php

declare(strict_types=1);

namespace App\Repositories\Student;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

use App\Models\AsistenciaGeneral;
use App\Models\Software;

class EloquentEstudianteRepository implements EstudianteRepositoryInterface
{
    public function getProyectosDelEstudiante(int $estudianteId): Collection
    {
        // Buscamos proyectos donde el estudiante esté en la tabla pivote 'tbl_autores_proyecto'
        return Proyecto::whereHas('autores', function ($query) use ($estudianteId) {
            $query->where('tbl_estudiantes.id', $estudianteId);
        })
        ->with(['materia', 'profesor', 'multimedia']) // Eager loading para optimizar
        ->orderBy('id', 'desc')
        ->get();
    }

    public function findProyectoDelEstudiante(int $proyectoId, int $estudianteId): ?Proyecto
    {
        return Proyecto::where('id', $proyectoId)
            ->whereHas('autores', function ($query) use ($estudianteId) {
                $query->where('tbl_estudiantes.id', $estudianteId);
            })
            ->first();
    }

    public function updateDatosProyecto(Proyecto $proyecto, array $datos): bool
    {
        // Actualizamos campos básicos
        // Nota: El estatus se maneja en el Servicio, aquí solo persistencia pura
        return $proyecto->update([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
        ]);
    }

    public function verificarAsistenciaGeneral(int $estudianteId): bool
    {
        // Verifica si existe un registro en la tabla de asistencia general para este ID
        return AsistenciaGeneral::where('estudiante_id', $estudianteId)->exists();
    }

    public function getAllSoftwares()
    {
        return Software::where('estatus', true)->orderBy('nombre', 'asc')->get();
    }
}