<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateItem extends Model
{
    use HasFactory;

    protected $table = 'template_items';

    protected $fillable = [
        'template_id',
        'nombre',
        'descripcion',
        'orden',
        'obligatorio',
    ];

    // Relación inversa
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
