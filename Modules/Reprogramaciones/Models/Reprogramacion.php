<?php

namespace Modules\Reprogramaciones\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reprogramacion extends Model
{

    use HasFactory;

    protected $table = 'reprogramaciones'; 

    protected $fillable = [
        'evento_id',
        'usuario_id',
        'fecha_anterior',
        'nueva_fecha',
        'motivo',
        'evidencia',
    ];

    protected $casts = [
        'fecha_anterior' => 'date',
        'nueva_fecha' => 'date',
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
