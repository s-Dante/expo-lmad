<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Patrocinador;
use App\Models\Visitante;
use App\Enums\TipoVisitante;
use Illuminate\Http\Request;

class StaffEmpresaController extends Controller
{
    /**
     * Lista todas las empresas / patrocinadores registradas en BD.
     */
    public function index()
    {
        $empresas = Patrocinador::orderBy('nombre')->get();

        return view('staff.empresas', compact('empresas'));
    }

    /**
     * Muestra el formulario dinámico para registrar representantes de una empresa.
     */
    public function asistencia($id)
    {
        $empresa = Patrocinador::findOrFail($id);

        return view('staff.empresas-asist', compact('empresa'));
    }

    /**
     * Registra múltiples representantes de una empresa.
     * Crea un Visitante por cada nombre y lo vincula al patrocinador.
     */
    public function registrarRepresentantes(Request $request, $id)
    {
        $empresa = Patrocinador::findOrFail($id);

        $request->validate([
            'nombres'   => 'required|array|min:1',
            'nombres.*' => 'required|string|max:255',
        ], [
            'nombres.required'   => 'Agrega al menos un representante.',
            'nombres.*.required' => 'El nombre no puede estar vacío.',
        ]);

        $nombres = array_filter(array_map('trim', $request->nombres));

        if (empty($nombres)) {
            return back()->with('error', 'Agrega al menos un nombre de representante.');
        }

        $registrados = 0;

        foreach ($nombres as $nombre) {
            // Crea el visitante como tipo Sponsor
            $visitante = Visitante::create([
                'tipo'            => TipoVisitante::Sponsor,
                'nombre_completo' => $nombre,
            ]);

            // Vincula al patrocinador (cargo es opcional, se deja null)
            $empresa->representantes()->attach($visitante->id, ['cargo' => null]);

            $registrados++;
        }

        return back()->with('exito', "Se registraron {$registrados} representante(s) de {$empresa->nombre} correctamente.");
    }
}
