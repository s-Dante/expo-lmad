<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AsistenciaGeneral;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function registrarAsistenciaExpositor($matricula)
    {
        $expostor = Estudiante::where('matricula', $matricula)->first();

        if (!$expostor) {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado.'
            ], 404);
        }

        $asistenciaExistente = AsistenciaGeneral::where('estudiante_id', $expostor->id)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya habías registrado asistencia hoy.'
            ], 400);
        }

        $asistencia = AsistenciaGeneral::create([
            'estudiante_id' => $expostor->id,
            'hora_entrada' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada exitosamente.'
        ]);
    }
}
