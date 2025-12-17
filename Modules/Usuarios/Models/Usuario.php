<?php

namespace Modules\Usuarios\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard_name = 'web';
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'password',
        'activo',
        'organizacion_id',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function organizacion()
    {
        return $this->belongsTo(
            \Modules\Organizaciones\Models\Organizacion::class,
            'organizacion_id'
        );
    }

    /**
     * 📲 Ruta oficial para WhatsApp (Laravel Notifications)
     */
    public function routeNotificationForWhatsApp()
    {
        if (!$this->telefono) {
            \Log::warning("❌ Usuario {$this->id} sin teléfono WhatsApp");
            return null;
        }

        // Normaliza formato internacional
        return str_starts_with($this->telefono, '+')
            ? $this->telefono
            : '+57' . ltrim($this->telefono, '0');
    }
}
