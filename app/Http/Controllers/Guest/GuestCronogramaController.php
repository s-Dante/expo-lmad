<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\View\View;

/**
 * Controlador público para la vista de Cronograma.
 * Sirve los eventos con sus conferencistas para que front-end
 * pueda renderizar el cronograma con datos reales.
 */
class GuestCronogramaController extends Controller
{
    public function index(): View
    {
        $eventos = Evento::with('conferencistas')
            ->orderBy('fecha_inicio_evento')
            ->get();

        // TODO: Quitar el dd() cuando front-end haya validado los datos
        //dd($eventos->toArray());

        return view('guest.cronograma', compact('eventos'));
    }
}
