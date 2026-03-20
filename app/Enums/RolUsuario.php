<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Roles de usuario en el sistema.
 */
enum RolUsuario: string
{
    use EnumHelper;

    case Estudiante = 'estudiante';
    case Profesor   = 'profesor';
    case Admin      = 'admin';
    case SuperAdmin = 'super_admin';
    case Staff      = 'staff';

    /**
     * Label personalizado para 'super_admin'.
     */
    public function customLabel(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            default          => ucfirst($this->value),
        };
    }
}
