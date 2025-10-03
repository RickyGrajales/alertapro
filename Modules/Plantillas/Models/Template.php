<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;

    protected $table = 'templates';

    protected $fillable = [
        'nombre',
        'descripcion',
        'recurrencia',
        'activo',
    ];

    // Relación con ítems
    public function items()
    {
        return $this->hasMany(TemplateItem::class, 'template_id');
    }

    // Relación con reglas
    public function rules()
    {
        return $this->hasMany(NotificationRule::class, 'template_id');
    }

    // Eliminar en cascada
    protected static function booted()
    {
        static::deleting(function ($template) {
            $template->items()->delete();
            $template->rules()->delete();
        });
    }
}
