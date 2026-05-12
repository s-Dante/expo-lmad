<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventoRequest;
use App\Models\Evento;
use App\Repositories\Admin\EventoRepositoryInterface;
use App\Repositories\Admin\ConferencistaRepositoryInterface;
use App\Enums\TipoEvento;
use App\Enums\EstatusEvento;
use App\Services\ImagenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para la gestión de Eventos.
 */
class AdminEventoController extends Controller
{
    public function __construct(
        private readonly EventoRepositoryInterface $eventoRepo,
        private readonly ConferencistaRepositoryInterface $conferencistaRepo
    ) {}

    /**
     * Muestra la vista de eventos con listado y formulario.
     */
    public function index(): View
    {
        return view('admin.events', [
            'eventos'        => $this->eventoRepo->getAll(),
            'conferencistas' => $this->conferencistaRepo->getAllForDropdown(),
            'tiposEvento'    => TipoEvento::options(),
        ]);
    }

    /**
     * Almacena un nuevo evento.
     */
    public function store(StoreEventoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Manejo del poster
        if ($request->hasFile('poster')) {
            $data['poster_evento'] = ImagenService::guardarWebp(
                $request->file('poster'),
                'eventos/posters',
                nombreBase: $data['titulo'] ?? null
            );
        }

        // Extraer conferencistas antes de crear
        $conferencistas = $data['conferencistas'] ?? [];
        unset($data['conferencistas'], $data['poster']);

        $evento = $this->eventoRepo->create($data);

        // Sincronizar conferencistas
        if (!empty($conferencistas)) {
            $this->eventoRepo->syncConferencistas($evento, $conferencistas);
        }

        return redirect()
            ->route('admin.events')
            ->with('success', 'Evento registrado correctamente.');
    }

    /**
     * Actualiza un evento existente.
     */
    public function update(StoreEventoRequest $request, Evento $evento): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster_evento'] = ImagenService::guardarWebp(
                $request->file('poster'),
                'eventos/posters',
                nombreBase: $data['titulo'] ?? null
            );
        }

        $conferencistas = $data['conferencistas'] ?? [];
        unset($data['conferencistas'], $data['poster']);

        $this->eventoRepo->update($evento, $data);

        $this->eventoRepo->syncConferencistas($evento, $conferencistas);

        return redirect()
            ->route('admin.events')
            ->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Elimina (soft-delete) un evento.
     */
    public function destroy(Evento $evento): RedirectResponse
    {
        $this->eventoRepo->delete($evento);

        return redirect()
            ->route('admin.events')
            ->with('success', 'Evento eliminado correctamente.');
    }
}
