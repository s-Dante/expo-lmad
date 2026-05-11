<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreConferencistaRequest;
use App\Models\Conferencista;
use App\Repositories\Admin\ConferencistaRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para la gestión de Conferencistas (Guests/Invitados).
 */
class AdminConferencistaController extends Controller
{
    public function __construct(
        private readonly ConferencistaRepositoryInterface $conferencistaRepo
    ) {}

    /**
     * Muestra la vista de conferencistas con listado y formulario.
     */
    public function index(): View
    {
        return view('admin.guest', [
            'conferencistas' => $this->conferencistaRepo->getAll(),
        ]);
    }

    /**
     * Almacena un nuevo conferencista.
     */
    public function store(StoreConferencistaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto_url'] = $request->file('foto')
                ->store('conferencistas/fotos', 'public');
        }

        unset($data['foto']);

        $this->conferencistaRepo->create($data);

        return redirect()
            ->route('admin.guest')
            ->with('success', 'Conferencista registrado correctamente.');
    }

    /**
     * Actualiza un conferencista existente.
     */
    public function update(StoreConferencistaRequest $request, Conferencista $conferencista): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto_url'] = $request->file('foto')
                ->store('conferencistas/fotos', 'public');
        }

        unset($data['foto']);

        $this->conferencistaRepo->update($conferencista, $data);

        return redirect()
            ->route('admin.guest')
            ->with('success', 'Conferencista actualizado correctamente.');
    }

    /**
     * Elimina (soft-delete) un conferencista.
     */
    public function destroy(Conferencista $conferencista): RedirectResponse
    {
        $this->conferencistaRepo->delete($conferencista);

        return redirect()
            ->route('admin.guest')
            ->with('success', 'Conferencista eliminado correctamente.');
    }
}
