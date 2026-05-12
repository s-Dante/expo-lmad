<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatrocinadorRequest;
use App\Http\Requests\Admin\UpdatePatrocinadorRequest;
use App\Models\Patrocinador;
use App\Repositories\Admin\PatrocinadorRepositoryInterface;
use App\Enums\TierPatrocinador;
use App\Services\ImagenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para la gestión de Patrocinadores/Empresas.
 * Skinny Controller: delega toda la lógica de datos al Repositorio.
 */
class AdminPatrocinadorController extends Controller
{
    public function __construct(
        private readonly PatrocinadorRepositoryInterface $patrocinadorRepo
    ) {}

    /**
     * Muestra la vista de empresas con el listado y formulario de creación.
     */
    public function index(): View
    {
        return view('admin.companies', [
            'patrocinadores' => $this->patrocinadorRepo->getAll(),
            'tiers'          => TierPatrocinador::options(),
        ]);
    }

    /**
     * Almacena una nueva empresa/patrocinador.
     */
    public function store(StorePatrocinadorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Manejo del logo si se subió uno
        if ($request->hasFile('logo')) {
            $data['logo_url'] = ImagenService::guardarWebp(
                $request->file('logo'),
                'patrocinadores/logos',
                nombreBase: $data['nombre'] ?? null
            );
        }

        // Normalizar es_patrocinador como booleano real
        $data['es_patrocinador'] = !empty($data['es_patrocinador']);

        // Si no es patrocinador, limpiar el tier
        if (!$data['es_patrocinador']) {
            $data['tier'] = null;
        }

        // Remover campo de archivo que no va a la BD
        unset($data['logo']);

        $this->patrocinadorRepo->create($data);

        return redirect()
            ->route('admin.companies')
            ->with('success', 'Empresa registrada correctamente.');
    }

    /**
     * Actualiza una empresa/patrocinador existente.
     */
    public function update(UpdatePatrocinadorRequest $request, Patrocinador $patrocinador): RedirectResponse
    {
        $data = $request->validated();

        // Manejo del logo si se subió uno nuevo
        if ($request->hasFile('logo')) {
            $data['logo_url'] = ImagenService::guardarWebp(
                $request->file('logo'),
                'patrocinadores/logos',
                nombreBase: $data['nombre'] ?? $patrocinador->nombre
            );
        }

        // Normalizar es_patrocinador como booleano real
        $data['es_patrocinador'] = !empty($data['es_patrocinador']);

        // Si no es patrocinador, limpiar el tier
        if (!$data['es_patrocinador']) {
            $data['tier'] = null;
        }

        // Remover campo de archivo que no va a la BD
        unset($data['logo']);

        $this->patrocinadorRepo->update($patrocinador, $data);

        return redirect()
            ->route('admin.companies')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Elimina (soft-delete) una empresa/patrocinador.
     */
    public function destroy(Patrocinador $patrocinador): RedirectResponse
    {
        $this->patrocinadorRepo->delete($patrocinador);

        return redirect()
            ->route('admin.companies')
            ->with('success', 'Empresa eliminada correctamente.');
    }
}
