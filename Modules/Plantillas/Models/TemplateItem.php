<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
    protected $table = 'template_items';

    protected $fillable = [
        'template_id',
        'titulo',
        'detalle',
        'orden',
        'requerido',
        'tipo'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
