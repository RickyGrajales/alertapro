<?php

namespace Modules\Eventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoEvento extends Model
{
    use HasFactory;

    protected $table = 'documentos_evento';

    protected $fillable = [
        'evento_id',
        'user_id',
        'nombre',
        'ruta',
        'tipo',
    ];

    // Relación con evento
    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(\Modules\Usuarios\Models\Usuario::class, 'user_id');
    }
}
