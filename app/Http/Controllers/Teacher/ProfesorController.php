<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Teacher\ProfesorRepositoryInterface;
use App\Services\Teacher\ProfesorEmailService;

use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\User;

class ProfesorController extends Controller
{
    public function __construct(
        protected ProfesorRepositoryInterface $profesorRepository,
        protected ProfesorEmailService $emailService
    ) {}

    public function cargarRegistroExpositores()
    {
        $profesor = Auth::user();
        $materiasProfesor = $profesor->profesor->materias()->with('planAcademico')->get();
        return view('teacher.registro-expositores', compact('materiasProfesor'));
    }

    public function cargarProyecto(Request $request)
    {
        $request->validate([
            'estudiantes' => 'required|array',
            'estudiantes.*.matricula' => 'required|exists:tbl_estudiantes,matricula',
            'estudiantes.*.nombre' => 'required|string',
            'profesor_id' => 'required',
            'periodo_semestral' => 'required',
            'materia_id' => 'required'
        ]);

        return DB::transaction(function () use ($request) {



            $profesorReal = Auth::user()->profesor;


            if (!$profesorReal) {
                return back()->withErrors(['msg' => 'El usuario autenticado no está registrado como profesor.']);
            }


            $codigo = Str::upper(Str::random(15));
            while (Proyecto::where('codigo_acceso', $codigo)->exists()) {
                $codigo = Str::upper(Str::random(15));
            }

            $proyecto = Proyecto::create([
                'profesor_id' => $profesorReal->id,
                'periodo_semestral' => $request->periodo_semestral,
                'slug' => Str::slug('proyecto-' . $codigo),
                'materia_id' => $request->materia_id,
                'codigo_acceso' => $codigo,
                'estatus' => 'borrador',
            ]);

            foreach ($request->estudiantes as $index => $estudianteData) {

                $estudiante = Estudiante::where('matricula', $estudianteData['matricula'])->first();

                $usuario = User::firstOrCreate(
                    ['email' => $estudiante->email],
                    [
                        'name' => $estudiante->matricula,
                        'nombre' => $estudiante->nombre,
                        'apellido_paterno' => $estudiante->apellido_paterno,
                        'apellido_materno' => $estudiante->apellido_materno,
                        'email' => $estudiante->email,
                        'password' => Hash::make($estudiante->matricula),
                        'rol' => 'estudiante',
                        'estatus' => 1,
                    ]
                );

                if (is_null($estudiante->usuario_id)) {
                    $estudiante->update(['usuario_id' => $usuario->id]);
                }

                $proyecto->autores()->attach($estudiante->id, [
                    'es_lider' => ($index === 0) ? 1 : 0,
                ]);

                $proyecto->multimedia()->create([
                    'tipo' => 'imagen',
                    'url' => '',
                    'titulo' => 'Pendiente...',
                    'descripcion' => null,
                    'es_portada' => true,
                ]);
            }
            return redirect()->back()->with('Exito', 'Proyecto registrado con éxito. Código: ' . $codigo);
        });

    }

    public function cargarProyecto2(Request $request)
    {
        // 1. Podriamos ahcer un FormRequest
        $validated = $request->validate([
            'estudiantes' => 'required|array',
            'estudiantes.*.matricula' => 'required|exists:tbl_estudiantes,matricula',
            'estudiantes.*.nombre' => 'required|string',
            'periodo_semestral' => 'required',
            'materia_id' => 'required'
        ]);

        $profesor = Auth::user()->profesor;
        if (!$profesor) {
            return back()->withErrors(['msg' => 'Usuario no es profesor.']);
        }

        // 2. Llamada al Repositorio
        $resultado = $this->profesorRepository->crearProyectoConEstudiantes($validated, $profesor);

        // 3. Llamada al Servicio (Correos)
        try {
            $this->emailService->enviarCorreosAsignacion(
                $resultado['proyecto'], 
                $resultado['codigo'], 
                $resultado['usuarios']
            );
        } catch (\Exception $e) {
            // Log::error('Error enviando correos: ' . $e->getMessage());
            return redirect()->back()->with('Warning', 'Proyecto creado, pero hubo un error enviando los correos.');
        }

        return redirect()->back()->with('Exito', 'Proyecto registrado y notificaciones enviadas. Código: ' . $resultado['codigo']);
    }

    public function listadoProyectos()
    {
        $usuario = Auth::user();
        $profesor = $usuario->profesor;
        $proyectosProfesor = Proyecto::where('profesor_id', $profesor->id)
            ->with(['autores', 'materia'])
            ->get();

        $materias = $usuario->profesor->materias()->with('planAcademico')->get();

        return view('teacher.lista-proyectos', compact('proyectosProfesor', 'materias'));

    }

    public function actualizarProyecto(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'estudiantes' => 'required|array',
            'estudiantes.*.matricula' => 'required|exists:tbl_estudiantes,matricula',
            'materia_id' => 'required',
            'periodo_semestral' => 'required',
            'codigo_acceso' => 'required|exists:tbl_proyectos,codigo_acceso',
        ]);


        return DB::transaction((function () use ($request) {

            $proyecto = Proyecto::where('codigo_acceso', $request->codigo_acceso)->firstOrFail();

            $proyecto->update([
                'materia_id' => $request->materia_id,
                'periodo_semestral' => $request->periodo_semestral,
            ]);

            // 1. Obtenemos el array original de estudiantes del request
            $estudiantesRequest = $request->input('estudiantes', []);

            $matriculas = [];
            foreach ($estudiantesRequest as $item) {
                if (!empty($item['matricula'])) {
                    $matriculas[] = $item['matricula'];
                }
            }

            $estudiantesDB = Estudiante::whereIn('matricula', $matriculas)->get();
            $datosSync = [];

            $contador = 0;

            foreach ($matriculas as $matricula) {
                $estudiante = $estudiantesDB->where('matricula', $matricula)->first();

                if ($estudiante) {
                    $datosSync[$estudiante->id] = [
                        'es_lider' => ($contador === 0) ? 1 : 0,
                    ];
                    $contador++;
                }
            }

            /*
            if (empty($datosSync)) {
                dd("Error: No se encontraron estudiantes para las matrículas enviadas", $matriculas);
            }
            */
            $proyecto->autores()->sync($datosSync);
            return redirect()->back()->with('Exito', 'Proyecto actualizado con éxito.');

        }));
    }
}
