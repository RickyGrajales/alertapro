<?php

namespace Modules\Eventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;
use Carbon\Carbon;

class NotificacionLog extends Model
{
    use HasFactory;

    protected $table = 'notificacion_logs';

    protected $fillable = [
        'evento_id',
        'user_id',
        'canal',
        'destinatario',
        'mensaje',
        'enviado_en',
        'exitoso',
        'error',
    ];

    /**
     * Casts automáticos para tipos de datos.
     * Esto hace que 'enviado_en' se maneje como fecha Carbon.
     */
    protected $casts = [
        'enviado_en' => 'datetime',
        'exitoso'    => 'boolean',
    ];

    /**
     * Relaciones con otros modelos.
     */
    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    /**
     * Accesor para formatear automáticamente la fecha en vistas.
     */
    public function getEnviadoEnFormattedAttribute()
    {
        return $this->enviado_en
            ? Carbon::parse($this->enviado_en)->format('d/m/Y H:i')
            : '-';
    }
}
