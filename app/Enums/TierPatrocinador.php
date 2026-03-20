<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Niveles de patrocinio para empresas patrocinadoras.
 */
enum TierPatrocinador: string
{
    use EnumHelper;

    case Bronce   = 'Bronce';
    case Plata    = 'Plata';
    case Oro      = 'Oro';
    case Diamante = 'Diamante';
    case Titanium = 'Titanium';
}
