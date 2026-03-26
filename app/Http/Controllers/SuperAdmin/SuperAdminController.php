<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Visitante;
use App\Models\Evento;
use App\Models\Patrocinador;

class SuperAdminController extends Controller
{
    public function getInfoDashboard()
    {
        $totalVisitantes = Visitante::count();
        $visitantesExternos = Visitante::where('tipo', '!=', 'estudiante')->count();
        $visitantesInstitucionales = Visitante::where('tipo', 'estudiante')->count();
        $visitanteM = Visitante::where('genero', 'M')->count();
        $visitanteF = Visitante::where('genero', 'F')->count();
        $visitanteO = Visitante::where('genero', 'O')->count();
        $eventos = Evento::count();
        $patrocinadores = Patrocinador::count();

        $listaEventos = Evento::withCount('visitantes')->get();

        try {
            return response()->json([
                'total_visitantes' => $totalVisitantes,
                'visitantes_institucionales' => $visitantesInstitucionales,
                'visitantes_externos' => $visitantesExternos,
                'visitante_f' => $visitanteF,
                'visitante_m' => $visitanteM,
                'visitante_o' => $visitanteO,
                'eventos' => $eventos,
                'patrocinadores' => $patrocinadores,
                'nombre_eventos' => $listaEventos->map(function ($evento) {
                    return [
                        'nombre' => $evento->titulo,
                        'visitantes_count' => $evento->visitantes_count,
                        'capacidad' => $evento->capacidad,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }
    public function getProyectosInfo()
    {
        $expositores = User::where('rol', 'estudiante')->count();
        $proyectosTotal = Proyecto::count();
        $proyectosAceptados = Proyecto::where('estatus', 'aprobado')->count();
        $proyectosRechazados = Proyecto::where('estatus', 'rechazado')->count();

        return response()->json([
            'expositores' => $expositores,
            'proyectos_total' => $proyectosTotal,
            'proyectos_aceptados' => $proyectosAceptados,
            'proyectos_rechazados' => $proyectosRechazados,
        ]);
    }

    public function paginaProyectos()
    {
        $materias = \App\Models\Materia::all();
        $profesores = \App\Models\Profesor::all();

        $proyectosRevision = Proyecto::where('estatus', 'enviado')
            ->with(['materia', 'profesor'])
            ->get();

        $proyectosAprobados = Proyecto::where('estatus', 'aprobado')
            ->with(['materia', 'profesor'])
            ->get();

        //$proyectosAprobados = Proyecto::where('estatus', 'aprobado');

        return view('superadmin.proyectos', compact('materias', 'profesores', 'proyectosRevision', 'proyectosAprobados'));
    }

    public function paginaRevisionProyecto($id)
    {
        $proyecto = Proyecto::with(['materia', 'profesor', 'autores', 'multimedia'])->findOrFail($id);
        //dd($proyecto);
        return view('superadmin.revision-proyecto', compact('proyecto'));
    }

    public function actualizarRevisionProyecto(Request $request)
    {

        $proyecto = Proyecto::findOrFail($request->proyecto_id);

        $proyecto->estatus = $request->accion;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->retroalimentacion = $request->mensaje;
        $proyecto->save();

        return response()->json([
            'mensaje' => 'Datos recibidos correctamente',
            'recibido' => $request->all()
        ]);

    }
    public function mandarRevisionProyecto($id)
    {

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->estatus = 'enviado';
        $proyecto->save();

        return response()->json([
            'mensaje' => 'Proyecto enviado para revisión'
        ]);

    }

}

