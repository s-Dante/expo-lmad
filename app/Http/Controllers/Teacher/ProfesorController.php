<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\User;

class ProfesorController extends Controller
{
    public function cargarRegistroExpositores()
    {
        $profesor = auth()->user();

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

        dd($request->all());

            $profesorReal = auth()->user()->profesor;
            

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
                    ['llave_acceso' => $estudiante->matricula],
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
}
