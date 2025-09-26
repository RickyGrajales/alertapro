<?php

namespace Modules\Organizaciones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizacion extends Model
{
    use HasFactory;

    protected $table = 'organizaciones';

    protected $fillable = [
        'nombre',
        'nit',
        'tipo',
        'representante',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'departamento',
        'pagina_web',
        'logo',
        'descripcion',
        'activo',
    ];

    /**
     * Relación con Usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(\Modules\Usuarios\Models\Usuario::class, 'organizacion_id');
    }
}
