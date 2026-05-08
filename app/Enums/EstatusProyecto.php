<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Estatus de un proyecto estudiantil.
 */
enum EstatusProyecto: string
{
    use EnumHelper;

    case Borrador  = 'borrador';
    case Enviado   = 'enviado';
    case Aprobado  = 'aprobado';
    case Rechazado = 'rechazado';
    case Eliminado = 'eliminado';
}
