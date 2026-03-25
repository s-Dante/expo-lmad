<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Patrocinador;
use App\Enums\TierPatrocinador;
use Illuminate\View\View;

/**
 * Controlador público para la vista de Patrocinadores (Nuestras Estrellas).
 * Sirve los patrocinadores agrupados por tier para que front-end
 * pueda renderizar la vista.
 */
class GuestPatrocinadorController extends Controller
{
    public function index(): View
    {
        // Traer solo empresas marcadas como patrocinadores, ordenadas por tier
        $patrocinadores = Patrocinador::where('es_patrocinador', true)
            ->whereNotNull('tier')
            ->where('tier', '!=', TierPatrocinador::Ninguno->value)
            ->orderBy('tier')
            ->get();

        // Agrupar por tier para que la vista los pueda renderizar por sección
        $porTier = $patrocinadores->groupBy('tier');

        // TODO: Quitar el dd() cuando front-end haya validado los datos
        //dd($porTier->toArray());

        return view('guest.patrocinadores', compact('patrocinadores', 'porTier'));
    }
}
