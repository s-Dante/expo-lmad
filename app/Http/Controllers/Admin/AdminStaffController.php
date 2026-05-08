<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Models\User;
use App\Repositories\Admin\StaffRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para gestión de cuentas Staff.
 */
class AdminStaffController extends Controller
{
    public function __construct(
        private readonly StaffRepositoryInterface $staffRepo
    ) {}

    /**
     * Muestra la vista de staff con formulario y listado.
     */
    public function index(): View
    {
        return view('admin.staff', [
            'staffUsers' => $this->staffRepo->getAllStaff(),
        ]);
    }

    /**
     * Crea una nueva cuenta staff.
     */
    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $this->staffRepo->createStaffUser($request->validated());

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Cuenta staff creada correctamente.');
    }

    /**
     * Actualiza una cuenta staff existente.
     */
    public function update(StoreStaffRequest $request, User $staff): RedirectResponse
    {
        $this->staffRepo->updateStaffUser($staff, $request->validated());

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Cuenta staff actualizada correctamente.');
    }

    /**
     * Desactiva una cuenta staff.
     */
    public function destroy(User $staff): RedirectResponse
    {
        $this->staffRepo->deleteStaffUser($staff);

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Cuenta staff desactivada correctamente.');
    }
}
