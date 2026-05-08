<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear una cuenta de usuario para un profesor.
 */
class StoreTeacherAccountRequest extends FormRequest
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
            'profesor_id' => ['required', 'exists:tbl_profesores,id'],
            'email'       => ['required', 'email', 'unique:tbl_usuarios,email'],
            'password'    => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'profesor_id.required' => 'Debe seleccionar un profesor del padrón.',
            'profesor_id.exists'   => 'El profesor seleccionado no existe en el padrón.',
            'email.required'       => 'El correo electrónico es obligatorio.',
            'email.email'          => 'Debe proporcionar un correo electrónico válido.',
            'email.unique'         => 'Este correo ya está registrado en el sistema.',
            'password.required'    => 'La contraseña es obligatoria.',
            'password.min'         => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
