<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Contrato para operaciones CRUD de usuarios Staff.
 */
interface StaffRepositoryInterface
{
    public function getAllStaff(): Collection;
    public function createStaffUser(array $data): User;
    public function updateStaffUser(User $user, array $data): User;
    public function deleteStaffUser(User $user): void;
}
