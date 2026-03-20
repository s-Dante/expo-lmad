<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Implementación Eloquent para gestión de usuarios Staff.
 */
class EloquentStaffRepository implements StaffRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAllStaff(): Collection
    {
        return User::where('rol', 'staff')
            ->where('estatus', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function createStaffUser(array $data): User
    {
        return User::create([
            'name'             => $data['llave_acceso'],
            'nombre'           => $data['nombre'] ?? 'Staff',
            'apellido_paterno' => $data['apellido_paterno'] ?? '',
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'email'            => $data['llave_acceso'] . '@staff.expo',
            'password'         => Hash::make($data['password']),
            'llave_acceso'     => $data['llave_acceso'],
            'rol'              => 'staff',
            'estatus'          => true,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function updateStaffUser(User $user, array $data): User
    {
        $updateData = [];

        if (!empty($data['llave_acceso'])) {
            $updateData['llave_acceso'] = $data['llave_acceso'];
            $updateData['name'] = $data['llave_acceso'];
        }

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return $user->fresh();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteStaffUser(User $user): void
    {
        $user->update(['estatus' => false]);
    }
}
