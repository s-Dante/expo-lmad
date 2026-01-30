<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Student\EstudianteRepositoryInterface;
use App\Services\Student\EstudianteService;
use App\Models\AsistenciaEvento;

class EstudianteController extends Controller
{
    public function __construct(
        protected EstudianteRepositoryInterface $studentRepo,
        protected EstudianteService $studentService
    ) {}

    public function dashboard()
    {
        // Vista simple de bienvenida
        return view('student.dashboard');
    }

    public function asistenciaQr()
    {
        $estudiante = Auth::user()->estudiante;
        $asistio = $this->studentRepo->verificarAsistenciaGeneral($estudiante->id);
    
        return view('student.qr', compact('estudiante', 'asistio'));
    }

    public function index()
    {
        $estudianteId = Auth::user()->estudiante->id;
        $proyectos = $this->studentRepo->getProyectosDelEstudiante($estudianteId);

        return view('student.proyectos.index', compact('proyectos'));
    }

    public function edit($id)
    {
        $estudianteId = Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('student.proyectos.index')->with('error', 'Proyecto no encontrado.');
        }

        // Validación simple: Solo editar si es borrador o rechazado
        if (!in_array($proyecto->estatus, ['borrador', 'rechazado'])) {
            return redirect()->route('student.proyectos.index')->with('warning', 'El proyecto ya está en revisión.');
        }

        return view('student.proyectos.edit', compact('proyecto'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validar
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'poster' => 'nullable|image|max:5000', // 5MB max
            'codigo_acceso' => 'required' // Token de seguridad
        ]);

        $estudianteId = Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            abort(404);
        }

        // Validar Token (Candado de seguridad extra)
        if ($validated['codigo_acceso'] !== $proyecto->codigo_acceso) {
            return back()->withErrors(['codigo_acceso' => 'El código de seguridad es incorrecto.']);
        }

        // 2. Llamar al Servicio
        $this->studentService->procesarActualizacionProyecto(
            $proyecto,
            $validated,
            $request->file('poster')
        );

        return redirect()->route('student.proyectos.index')->with('success', 'Información enviada correctamente.');
    }
}