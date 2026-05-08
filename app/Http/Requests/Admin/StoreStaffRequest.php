<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear una cuenta de usuario Staff.
 */
class StoreStaffRequest extends FormRequest
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
        $userId = $this->route('staff')?->id;

        return [
            'llave_acceso' => ['required', 'string', 'max:50', 'unique:tbl_usuarios,llave_acceso,' . $userId],
            'password'     => [$userId ? 'nullable' : 'required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'llave_acceso.required' => 'La clave de acceso es obligatoria.',
            'llave_acceso.unique'   => 'Esta clave de acceso ya está en uso.',
            'password.required'     => 'La contraseña es obligatoria.',
            'password.min'          => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}
