<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Tipos de evento disponibles en la exposición.
 */
enum TipoEvento: string
{
    use EnumHelper;

    case Conferencia = 'conferencia';
    case Taller      = 'taller';
    case Seminario   = 'seminario';
    case Webinar     = 'webinar';
}
