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

    public function usuarios()
    {
        return $this->hasMany(\Modules\Usuarios\Models\Usuario::class, 'organizacion_id');
    }
}
