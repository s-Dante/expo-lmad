<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Student\EstudianteRepositoryInterface;
use App\Services\Student\EstudianteService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Models\AsistenciaEvento;

class EstudianteController extends Controller
{
    public function __construct(
        protected EstudianteRepositoryInterface $studentRepo,
        protected EstudianteService $studentService
    ) {
    }

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

        $qrCode = QrCode::size(300)
            ->errorCorrection('H')
            ->generate($estudiante->matricula);

        return view('student.qr', compact('estudiante', 'asistio', 'qrCode'));
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

    public function firts_Show($id)
    {
        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');
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

        return view('student.proyectos.create', compact('proyecto', 'softwares'));
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

        $estudianteId = Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto)
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');

        $esLider = $proyecto->autores()
            ->where('tbl_estudiantes.id', $estudianteId)
            ->wherePivot('es_lider', true)
            ->exists();

        if (!$esLider) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Acción no autorizada. Solo el líder puede guardar cambios.');
        }

        if ($validated['codigo_acceso'] !== $proyecto->codigo_acceso) {
            return back()->with('error', 'El código de seguridad es incorrecto.')->withInput();
        }

        // Llamada al servicio
        $this->studentService->procesarActualizacionProyecto(
            $proyecto,
            $validated,
            $request->file('poster')
        );

        return redirect()->route('estudiante.proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    /*

    DANTE: 
    1. Hace falta una consulta que permita enviar las
        modificaciones (descripción, links (3) y portada) solo pidiedon el ID del proyecto.

    2. Tambien necesitamos una consulta que nos permita cambiar el estatus del proyecto como 
        a "enviado" para cuando el alumno reenvie sus cambios.

    */
    public function updateEdit(Request $request, $id)
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

        if (!$proyecto)
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');

        $esLider = $proyecto->autores()
            ->where('tbl_estudiantes.id', $estudianteId)
            ->wherePivot('es_lider', true)
            ->exists();

        if (!$esLider) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Acción no autorizada. Solo el líder puede guardar cambios.');
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

        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');
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

        return view('student.proyectos.show', compact('proyecto', 'softwares'));
    }

    public function send(Request $request, $id)
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

        if (!$proyecto)
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');

        $esLider = $proyecto->autores()
            ->where('tbl_estudiantes.id', $estudianteId)
            ->wherePivot('es_lider', true)
            ->exists();

        if (!$esLider) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Acción no autorizada. Solo el líder puede guardar cambios.');
        }

        if ($validated['codigo_acceso'] !== $proyecto->codigo_acceso) {
            return back()->withErrors(['codigo_acceso' => 'El código de seguridad es incorrecto.'])->withInput();
        }

        $validated['enviar_revision'] = true;
        // Llamada al servicio
        $this->studentService->procesarActualizacionProyecto(
            $proyecto,
            $validated,
            $request->file('poster')
        );

        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');
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

        return view('student.proyectos.show', compact('proyecto', 'softwares'));
    }

    public function show($id)
    {
        $estudianteId = \Illuminate\Support\Facades\Auth::user()->estudiante->id;
        $proyecto = $this->studentRepo->findProyectoDelEstudiante($id, $estudianteId);

        if (!$proyecto) {
            return redirect()->route('estudiante.proyectos.index')->with('error', 'Proyecto no encontrado.');
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

        return view('student.proyectos.show', compact('proyecto', 'softwares'));
    }
}