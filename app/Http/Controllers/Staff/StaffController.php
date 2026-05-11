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

    public function storeVisitante(Request $request)
    {
        $validated = $request->validate([
            'tipo_visitante' => 'required|in:alumno,visitante',
            'matricula'      => 'nullable|required_if:tipo_visitante,alumno|string',
            'nombre'         => 'required|string',
            'genero'         => 'nullable|in:M,F,O',
        ]);

        $tipo = $validated['tipo_visitante'] === 'alumno' 
            ? \App\Enums\TipoVisitante::Estudiante 
            : \App\Enums\TipoVisitante::Externo;

        \App\Models\Visitante::create([
            'tipo'            => $tipo,
            'matricula'       => $validated['tipo_visitante'] === 'alumno' ? $validated['matricula'] : null,
            'nombre_completo' => $validated['nombre'],
            'genero'          => $validated['genero'] ?: null,
        ]);

        return back()->with('success', 'Visitante registrado exitosamente.');
    }
}
