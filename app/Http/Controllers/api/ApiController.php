<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class ApiController extends Controller
{
    public function buscarEstudiante($matricula)
    {
        $estudiante = Estudiante::where('matricula', $matricula)->first();

        if ($estudiante) {
            return response()->json([
                'success' => true,
                'nombre' => $estudiante->nombre . ' ' . $estudiante->apellido_paterno . ' ' . $estudiante->apellido_materno
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado'
            ], 404);
        }
    }

    public function obtenerProyectoPorToken($token)
    {
        $proyecto = Proyecto::where('codigo_acceso', $token)
            ->with(['autores', 'materia.planAcademico'])
            ->first();

        if ($proyecto) {

            return response()->json([
                'success' => true,
                'data' => $proyecto
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ]);
        }


}

}
