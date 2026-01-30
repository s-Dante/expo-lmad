<?php

namespace App\Repositories\Student;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface EstudianteRepositoryInterface
{
    /**
     * Obtiene los proyectos asociados al estudiante logueado
     */
    public function getProyectosDelEstudiante(int $estudianteId): Collection;

    /**
     * Busca un proyecto específico validando que pertenezca al estudiante
     */
    public function findProyectoDelEstudiante(int $proyectoId, int $estudianteId): ?Proyecto;

    /**
     * Actualiza la información básica del proyecto
     */
    public function updateDatosProyecto(Proyecto $proyecto, array $datos): bool;

    /**
     * Verifica si el estudiante ha registrado asistencia general
     */
    public function verificarAsistenciaGeneral(int $estudianteId): bool;
}