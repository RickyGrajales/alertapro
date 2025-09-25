<?php

namespace Modules\Usuarios\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use Notifiable, HasRoles;

    // Nombre de la tabla (de la migración del módulo)
    protected $table = 'usuarios';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',       // estado del usuario (1 = activo, 0 = inactivo)
        'organizacion_id', // FK para organizaciones
    ];

    // Campos que deben permanecer ocultos
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversiones de tipos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación con Organización
     */
    public function organizacion()
    {
        return $this->belongsTo(\Modules\Organizaciones\App\Models\Organizacion::class);
    }
}
