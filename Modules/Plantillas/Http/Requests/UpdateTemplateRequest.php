<?php

namespace Modules\Plantillas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return (new StoreTemplateRequest())->rules();
    }
}
