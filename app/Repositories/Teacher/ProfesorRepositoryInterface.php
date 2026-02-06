<?php

namespace App\Repositories\Teacher;

use App\Models\Profesor;

interface ProfesorRepositoryInterface
{
    /**
     * Crea un proyecto, sus usuarios asociados y retorna los datos necesarios.
     * @return array Retorna ['proyecto' => $obj, 'codigo' => $str, 'usuarios' => $collection]
     */
    public function crearProyectoConEstudiantes(array $datos, Profesor $profesor): array;
}