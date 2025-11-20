<?php

namespace Modules\Organizaciones\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ya validas rol Admin por middleware, así que aquí permitimos:
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('organizacion')?->id; // para update

        return [
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:50|unique:organizaciones,nit,' . $id,
            'tipo' => 'nullable|string|max:100',
            'representante' => 'nullable|string|max:150',
            'email' => 'nullable|email|unique:organizaciones,email,' . $id,
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'pagina_web' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'templates' => 'nullable|array',
            'templates.*' => 'integer|exists:templates,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nit.required' => 'El NIT es obligatorio.',
            'nit.unique' => 'El NIT ya está registrado.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo ya está registrado.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'Solo se permiten JPG, JPEG o PNG.',
        ];
    }
}
