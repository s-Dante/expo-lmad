<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Profesor;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Implementación Eloquent para gestión de cuentas de profesor.
 */
class EloquentProfesorAdminRepository implements ProfesorAdminRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getProfesoresSinCuenta(): Collection
    {
        return Profesor::whereNull('usuario_id')
            ->orderBy('apellido_paterno')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getProfesoresConCuenta(): Collection
    {
        return Profesor::whereNotNull('usuario_id')
            ->with('usuario')
            ->orderBy('apellido_paterno')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function crearCuentaProfesor(Profesor $profesor, array $data): User
    {
        return DB::transaction(function () use ($profesor, $data) {
            $email = $data['email'] ?? $profesor->email;

            $usuario = User::create([
                'name'             => $profesor->numero_empleado,
                'nombre'           => $profesor->nombre,
                'apellido_paterno' => $profesor->apellido_paterno,
                'apellido_materno' => $profesor->apellido_materno,
                'email'            => $email,
                'password'         => Hash::make($data['password']),
                'rol'              => 'profesor',
                'estatus'          => true,
            ]);

            $profesor->update(['usuario_id' => $usuario->id]);

            // Si el email del profesor estaba vacío, actualizarlo
            if (empty($profesor->email) && !empty($email)) {
                $profesor->update(['email' => $email]);
            }

            return $usuario;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function actualizarCuentaProfesor(Profesor $profesor, array $data): User
    {
        $usuario = $profesor->usuario;

        $updateData = [];

        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (!empty($updateData)) {
            $usuario->update($updateData);
        }

        return $usuario->fresh();
    }

    /**
     * {@inheritDoc}
     */
    public function revocarCuentaProfesor(Profesor $profesor): void
    {
        DB::transaction(function () use ($profesor) {
            $usuario = $profesor->usuario;

            $profesor->update(['usuario_id' => null]);

            if ($usuario) {
                $usuario->update(['estatus' => false]);
            }
        });
    }
}
