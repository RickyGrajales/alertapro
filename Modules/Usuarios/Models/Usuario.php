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
     * 📲 Canal WhatsApp (Twilio)
     */
    public function routeNotificationForWhatsApp(): ?string
    {
        if (empty($this->telefono)) {
            return null;
        }

        // Normaliza el número (ej: 3171234567 → +573171234567)
        if (!str_starts_with($this->telefono, '+')) {
            return '+57' . ltrim($this->telefono, '0');
        }

        return $this->telefono;
    }
}
