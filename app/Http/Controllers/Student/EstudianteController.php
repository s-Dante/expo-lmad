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
        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;

        $proyectos = $this->studentRepo->getProyectosDelEstudiante($estudianteId);

        $conteoProyectos = $proyectos->count();
        $conteoPendientes = $proyectos->whereIn('estatus', ['borrador', 'enviado'])->count();
        $conteoAprobados = $proyectos->where('estatus', 'aprobado')->count();


        return view('student.dashboard', compact('conteoProyectos', 'conteoPendientes', 'conteoAprobados'));
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
        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');
        }

        if (!in_array($proyecto->estatus, ['borrador', 'rechazado'])) {
            return redirect()->route('estudiante.proyectos.index')->with('warning', 'El proyecto ya está en revisión.');
        }

        $esLider = $proyecto->autores()
            ->where('tbl_estudiantes.id', $estudianteId)
            ->wherePivot('es_lider', true)
            ->exists();

        if (!$esLider) {
            return redirect()->route('estudiante.proyectos.index')
                ->with('error', 'Solo el líder del equipo tiene permisos para registrar o editar la información.');
        }

        $softwares = $this->studentRepo->getAllSoftwares();

        return view('student.proyectos.edit', compact('proyecto', 'softwares'));
    }

    public function update(Request $request, $id)
    {
        // Validación extendida
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string|min:20',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'link_youtube' => 'required|url', // Obligatorio según tu descripción
            'link_drive' => 'nullable|url',
            'link_github' => 'nullable|url',
            'softwares' => 'required|array|min:1', // Al menos 1 software
            'softwares.*' => 'exists:tbl_softwares,id',
            'codigo_acceso' => 'required',
            'enviar_revision' => 'nullable' // Checkbox
        ]);

        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) abort(404);

        $esLider = $proyecto->autores()
            ->where('tbl_estudiantes.id', $estudianteId)
            ->wherePivot('es_lider', true)
            ->exists();

        if (!$esLider) {
            abort(403, 'Acción no autorizada. Solo el líder puede guardar cambios.');
        }

        if ($validated['codigo_acceso'] !== $proyecto->codigo_acceso) {
            return back()->withErrors(['codigo_acceso' => 'El código de seguridad es incorrecto.'])->withInput();
        }

        // Llamada al servicio
        $this->studentService->procesarActualizacionProyecto(
            $proyecto,
            $validated,
            $request->file('poster')
        );

        return redirect()->route('estudiante.proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }


    public function show($id)
    {
        $estudianteId = Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('student.proyectos.index')->with('error', 'Proyecto no encontrado.');
        }

        return view('student.proyectos.show', compact('proyecto'));
    }
}
