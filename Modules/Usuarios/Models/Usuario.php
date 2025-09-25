<?php

namespace Modules\Usuarios\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'activo',
        'organizacion_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function organizacion()
    {
        return $this->belongsTo(\Modules\Organizaciones\Models\Organizacion::class, 'organizacion_id');
    }
}
