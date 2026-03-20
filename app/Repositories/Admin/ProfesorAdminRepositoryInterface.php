<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Profesor;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Contrato para la gestión de cuentas de profesor desde admin.
 */
interface ProfesorAdminRepositoryInterface
{
    /** Profesores del padrón que NO tienen cuenta de usuario. */
    public function getProfesoresSinCuenta(): Collection;

    /** Profesores del padrón que YA tienen cuenta de usuario. */
    public function getProfesoresConCuenta(): Collection;

    /** Crea una cuenta de usuario para un profesor del padrón. */
    public function crearCuentaProfesor(Profesor $profesor, array $data): User;

    /** Actualiza la cuenta de usuario de un profesor. */
    public function actualizarCuentaProfesor(Profesor $profesor, array $data): User;

    /** Revoca (elimina) la cuenta de usuario de un profesor. */
    public function revocarCuentaProfesor(Profesor $profesor): void;
}
