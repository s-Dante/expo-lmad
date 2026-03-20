<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelper;

/**
 * Estados posibles de un evento.
 */
enum EstatusEvento: string
{
    use EnumHelper;

    case Programado = 'programado';
    case EnCurso    = 'en_curso';
    case Finalizado = 'finalizado';
    case Cancelado  = 'cancelado';

    /**
     * Label personalizado para 'en_curso'.
     */
    public function customLabel(): string
    {
        return match ($this) {
            self::EnCurso => 'En Curso',
            default       => ucwords(str_replace('_', ' ', $this->value)),
        };
    }
}
