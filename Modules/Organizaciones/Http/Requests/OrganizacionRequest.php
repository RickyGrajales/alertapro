<?php

namespace Modules\Organizaciones\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // o verificar role si quieres más control
    }

    public function rules(): array
    {
        $id = $this->route('organizacion')?->id ?? null;

        return [
            'nombre' => 'required|string|max:150',
            'nit'    => 'required|string|max:20|unique:organizaciones,nit,' . $id,
            'email'  => 'required|email|unique:organizaciones,email,' . $id,
            'tipo'   => 'nullable|in:Fundación,Colegio,Universidad,ONG,Otro',
            'telefono' => 'nullable|string|max:20',
        ];
    }
}
