<?php

namespace Modules\Eventos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Usuarios\Models\Usuario;
use Modules\Plantillas\Models\Template;

class Event extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'due_date',
        'estado',
        'responsable_id',
        'plantilla_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Relación con el usuario responsable (módulo Usuarios)
    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'responsable_id');
    }

    // Relación con la plantilla (módulo Plantillas)
    public function plantilla()
    {
        return $this->belongsTo(Template::class, 'plantilla_id');
    }

    // Accesor visual para badge de estado
    public function getEstadoBadgeAttribute()
    {
        return match ($this->estado) {
            'Completado' => '<span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">Completado</span>',
            'En Proceso' => '<span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-sm">En Proceso</span>',
            default => '<span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm">Pendiente</span>',
        };
    }

    // Placeholder para generación de checklist desde plantilla (Sprint siguiente)
    public function generarChecklistDesdePlantilla()
    {
        // Implementar en próximos sprints
    }
}

