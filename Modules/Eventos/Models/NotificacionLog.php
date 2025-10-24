<?php

namespace Modules\Eventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;

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
        'error'
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
