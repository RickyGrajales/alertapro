<?php

namespace Modules\Eventos\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Eventos\Models\Event;

class EventosSeeder extends Seeder
{
    public function run()
    {
        Event::firstOrcreate([
            'titulo' => 'Revisión mensual de seguridad',
            'descripcion' => 'Evento automático de control de seguridad.',
            'due_date' => now()->addDays(7),
            'estado' => 'Pendiente',
            'responsable_id' => 1,
            'plantilla_id' => null,
        ]);
    }
}
