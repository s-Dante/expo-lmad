<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\TipoEvento;
use App\Enums\EstatusEvento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación para crear un nuevo Evento.
 */
class StoreEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'titulo'              => ['required', 'string', 'max:255'],
            'tipo'                => ['required', Rule::in(TipoEvento::values())],
            'descripcion_evento'  => ['nullable', 'string'],
            'fecha_inicio_evento' => ['required', 'date'],
            'fecha_fin_evento'    => ['required', 'date', 'after:fecha_inicio_evento'],
            'ubicacion_evento'    => ['nullable', 'string', 'max:255'],
            'capacidad'           => ['nullable', 'integer', 'min:1'],
            'poster'              => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'conferencistas'      => ['nullable', 'array'],
            'conferencistas.*'    => ['exists:tbl_conferencistas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'              => 'El nombre del evento es obligatorio.',
            'tipo.required'                => 'Debe seleccionar un tipo de evento.',
            'tipo.in'                      => 'El tipo de evento seleccionado no es válido.',
            'fecha_inicio_evento.required' => 'La fecha y hora de inicio son obligatorias.',
            'fecha_fin_evento.required'    => 'La fecha y hora de fin son obligatorias.',
            'fecha_fin_evento.after'       => 'La fecha de fin debe ser posterior a la de inicio.',
            'poster.image'                 => 'El archivo debe ser una imagen.',
            'poster.max'                   => 'La imagen no debe superar los 4MB.',
        ];
    }
}
