<?php

namespace Modules\Delegaciones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;

class Delegacion extends Model
{
    use HasFactory;

    protected $table = 'delegaciones';

    protected $fillable = [
        'evento_id',
        'from_user_id',
        'to_user_id',
        'motivo',
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public function de()
    {
        return $this->belongsTo(Usuario::class, 'from_user_id');
    }

    public function para()
    {
        return $this->belongsTo(Usuario::class, 'to_user_id');
    }
}
