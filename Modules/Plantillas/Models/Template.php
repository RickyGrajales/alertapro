<?php

namespace Modules\Plantillas\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = [
        'nombre',
        'descripcion',
        'recurrencia',
        'activa'
    ];

    public function items()
    {
        return $this->hasMany(TemplateItem::class, 'template_id');
    }

    public function notificationRules()
    {
        return $this->hasMany(NotificationRule::class, 'template_id');
    }


    public function organizaciones()
    {
        return $this->belongsToMany(
            \Modules\Organizaciones\Models\Organizacion::class,
            'organizacion_plantilla',
            'plantilla_id',
            'organizacion_id'
        );
    }
}
