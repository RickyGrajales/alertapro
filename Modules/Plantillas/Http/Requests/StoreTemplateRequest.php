<?php

namespace Modules\Plantillas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150|unique:templates,nombre',
            'descripcion' => 'nullable|string',
            'recurrencia' => 'required|in:Nunca,Diaria,Semanal,Mensual,Anual',
            'activa' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.titulo' => 'required_with:items|string|max:255',
            'items.*.detalle' => 'nullable|string',
            'items.*.orden' => 'nullable|integer',
            'items.*.requerido' => 'nullable|boolean',
            'rules' => 'nullable|array',
            'rules.*.canal' => 'required_with:rules|string',
            'rules.*.offset_days' => 'nullable|integer',
            'rules.*.momento' => 'nullable|in:antes,despues',
            'organizaciones' => 'nullable|array',
            'organizaciones.*' => 'integer|exists:organizaciones,id',
        ];
    }
}
