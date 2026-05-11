<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Tipos de visitante en la exposición.
 */
enum TipoVisitante: string
{
    use EnumHelper;

    case Externo    = 'externo';
    case Estudiante = 'estudiante';
    case Sponsor    = 'sponsor';
    case Staff      = 'staff';
    case Profesor   = 'profesor';
    case Directivos = 'directivos';
}
