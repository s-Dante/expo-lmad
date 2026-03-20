<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Género del visitante externo.
 */
enum GeneroVisitante: string
{
    use EnumHelper;

    case Masculino = 'M';
    case Femenino  = 'F';
    case Otro      = 'O';

    /**
     * Label personalizado para mostrar nombre completo.
     */
    public function customLabel(): string
    {
        return match ($this) {
            self::Masculino => 'Masculino',
            self::Femenino  => 'Femenino',
            self::Otro      => 'Otro',
        };
    }
}
