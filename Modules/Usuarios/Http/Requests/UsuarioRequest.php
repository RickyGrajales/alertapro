<?php

namespace Modules\Usuarios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ya el middleware de Admin controla el acceso
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Si estamos en UPDATE, obtenemos el ID
        $id = $this->route('usuario') ?? null;

        return [
            'nombre' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                Rule::unique('usuarios', 'email')->ignore($id),
            ],

            'telefono' => ['nullable', 'string', 'max:20'],

            'password' => [
                $id ? 'nullable' : 'required', // requerido solo en create
                'min:6'
            ],

            'rol' => ['required', Rule::in(['Admin', 'Empleado'])],

            'activo' => ['required', Rule::in(['0', '1'])],

            'organizacion_id' => ['nullable', 'integer', 'exists:organizaciones,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique'   => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria al crear un usuario.',
            'rol.required' => 'Debe seleccionar un rol.',
            'activo.required' => 'Debe indicar si el usuario está activo.',
        ];
    }
}
