<?php

namespace Modules\Plantillas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // el middleware de rol debería controlar el acceso
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'recurrencia' => 'required|in:Nunca,Diaria,Semanal,Mensual,Anual',
            'activa' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.titulo' => 'required_with:items|string|max:255',
            'items.*.detalle' => 'nullable|string',
            'items.*.orden' => 'nullable|integer',
            'items.*.requerido' => 'nullable|boolean',
            'items.*.tipo' => 'nullable|string|max:50',
            'rules' => 'nullable|array',
            'rules.*.canal' => 'required_with:rules|string|max:50',
            'rules.*.offset_days' => 'nullable|integer',
            'rules.*.momento' => 'nullable|in:antes,despues',
            'rules.*.hora' => 'nullable|string',
            'organizaciones' => 'nullable|array',
            'organizaciones.*' => 'integer|exists:organizaciones,id',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('activa')) {
            $this->merge(['activa' => (bool) $this->input('activa')]);
        }
    }
}
