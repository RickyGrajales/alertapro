<?php

namespace Modules\Organizaciones\Models;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    protected $table = 'organizaciones';

    protected $fillable = [
        'nombre', 'nit', 'tipo', 'representante', 'email', 'telefono',
        'direccion', 'ciudad', 'departamento', 'pagina_web', 'logo',
        'descripcion', 'activo'
    ];


    protected $casts = [
        'activo' => 'boolean',
    ];

    public function usuarios()
    {
        return $this->hasMany(\Modules\Usuarios\Models\Usuario::class, 'organizacion_id');
    }

    public function templates()
{
    return $this->belongsToMany(
        \Modules\Plantillas\Models\Template::class,
        'organizacion_plantilla',
        'organizacion_id',
        'plantilla_id'
    )->withTimestamps();
}
}
