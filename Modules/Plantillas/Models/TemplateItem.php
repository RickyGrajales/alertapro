<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateItem extends Model
{
    protected $table = 'template_items';

    protected $fillable = [
        'template_id',
        'titulo',
        'detalle',
        'orden',
        'requerido',
        'tipo',
    ];

    protected $casts = [
        'requerido' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
