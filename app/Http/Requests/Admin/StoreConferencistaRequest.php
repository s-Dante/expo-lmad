<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear/actualizar un Conferencista (Guest).
 */
class StoreConferencistaRequest extends FormRequest
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
        $conferencistaId = $this->route('conferencista')?->id;

        return [
            'nombre'           => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'nickname'         => ['nullable', 'string', 'max:100', 'unique:tbl_conferencistas,nickname,' . $conferencistaId],
            'biografia'        => ['nullable', 'string'],
            'email'            => ['nullable', 'email', 'unique:tbl_conferencistas,email,' . $conferencistaId],
            'telefono'         => ['nullable', 'string', 'max:20'],
            'empresa'          => ['nullable', 'string', 'max:255'],
            'cargo'            => ['nullable', 'string', 'max:255'],
            'foto'             => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'           => 'El nombre del conferencista es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'email.email'               => 'Debe proporcionar un correo electrónico válido.',
            'email.unique'              => 'Este correo ya está registrado para otro conferencista.',
            'nickname.unique'           => 'Este nickname ya está en uso.',
        ];
    }
}
