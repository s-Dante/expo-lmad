<?php

declare(strict_types=1);

namespace App\Enums\Traits;

/**
 * Trait EnumHelper
 *
 * Proporciona métodos utilitarios para Backed Enums de PHP.
 * - label(): Nombre legible para UI.
 * - options(): Array [value => label] listo para <select> en Blade.
 * - values(): Array plano de valores para validación.
 */
trait EnumHelper
{
    /**
     * Retorna un label legible para la UI.
     * Convierte snake_case a Title Case y maneja casos especiales.
     *
     * @return string
     */
    public function label(): string
    {
        return match (true) {
            method_exists($this, 'customLabel') => $this->customLabel(),
            default => ucwords(str_replace('_', ' ', $this->value)),
        };
    }

    /**
     * Retorna un array [value => label] listo para usar en selects de Blade.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /**
     * Retorna un array plano con los valores del enum.
     * Útil para reglas de validación: Rule::in(TipoEvento::values())
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
