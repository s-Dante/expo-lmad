<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Proyecto;

class SuperAdminController extends Controller
{
    public function getDashboardInfo()
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

    public function revisionProyecto($id)
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

}

