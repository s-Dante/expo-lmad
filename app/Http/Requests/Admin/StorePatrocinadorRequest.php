<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\TierPatrocinador;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación para crear un nuevo Patrocinador/Empresa.
 */
class StorePatrocinadorRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre'          => ['required', 'string', 'max:255'],
            'es_patrocinador' => ['sometimes', 'boolean'],
            'tier'            => [
                'nullable',
                'required_if:es_patrocinador,1',
                Rule::in(TierPatrocinador::values()),
            ],
            'logo'            => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'website_url'     => ['nullable', 'url', 'max:500'],
        ];
    }

    /**
     * Mensajes de error personalizados.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required'          => 'El nombre de la empresa es obligatorio.',
            'tier.required_if'         => 'Debe seleccionar un grado de patrocinio.',
            'tier.in'                  => 'El grado de patrocinio seleccionado no es válido.',
            'logo.image'               => 'El archivo debe ser una imagen.',
            'logo.max'                 => 'La imagen no debe superar los 2MB.',
            'website_url.url'          => 'El enlace del sitio web debe ser una URL válida.',
        ];
    }
}
