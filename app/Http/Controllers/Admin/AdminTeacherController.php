<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherAccountRequest;
use App\Models\Profesor;
use App\Repositories\Admin\ProfesorAdminRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para gestión de cuentas de profesor desde admin.
 * Permite activar/desactivar cuentas de usuario para profesores del padrón.
 */
class AdminTeacherController extends Controller
{
    public function __construct(
        private readonly ProfesorAdminRepositoryInterface $profesorRepo
    ) {}

    /**
     * Muestra la vista de maestros con formulario y listado.
     */
    public function index(): View
    {
        return view('admin.teachers', [
            'profesoresSinCuenta' => $this->profesorRepo->getProfesoresSinCuenta(),
            'profesoresConCuenta' => $this->profesorRepo->getProfesoresConCuenta(),
        ]);
    }

    /**
     * Crea una cuenta de usuario para un profesor del padrón.
     */
    public function store(StoreTeacherAccountRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $profesor = Profesor::findOrFail($data['profesor_id']);

        $this->profesorRepo->crearCuentaProfesor($profesor, $data);

        return redirect()
            ->route('admin.teachers')
            ->with('success', 'Cuenta creada para ' . $profesor->nombre . ' ' . $profesor->apellido_paterno);
    }

    /**
     * Actualiza la cuenta de un profesor.
     */
    public function update(Request $request, Profesor $profesor): RedirectResponse
    {
        $data = $request->validate([
            'email'    => ['nullable', 'email', 'unique:tbl_usuarios,email,' . $profesor->usuario_id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $this->profesorRepo->actualizarCuentaProfesor($profesor, $data);

        return redirect()
            ->route('admin.teachers')
            ->with('success', 'Cuenta de ' . $profesor->nombre . ' actualizada correctamente.');
    }

    /**
     * Revoca (desactiva) la cuenta de un profesor.
     */
    public function destroy(Profesor $profesor): RedirectResponse
    {
        $this->profesorRepo->revocarCuentaProfesor($profesor);

        return redirect()
            ->route('admin.teachers')
            ->with('success', 'Cuenta de ' . $profesor->nombre . ' desactivada correctamente.');
    }
}
