<?php

namespace Modules\Reprogramaciones\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Eventos\Models\Evento;
use Modules\Usuarios\Models\Usuario;
use Modules\Reprogramaciones\Models\Reprogramacion;
use Carbon\Carbon;

class ReprogramacionSeeder extends Seeder
{
    public function run(): void
    {
        $evento = Evento::first();
        $usuario = Usuario::first();

        if (!$evento || !$usuario) {
            $this->command->warn('⚠️ No se encontraron eventos o usuarios para asociar reprogramaciones.');
            return;
        }

        Reprogramacion::create([
            'evento_id' => $evento->id,
            'fecha_anterior' => Carbon::now()->subDays(10),
            'nueva_fecha' => Carbon::now()->addDays(5),
            'motivo' => 'Reunión del equipo retrasada por capacitación interna.',
            'usuario_id' => $usuario->id,
        ]);

        Reprogramacion::create([
            'evento_id' => $evento->id,
            'fecha_anterior' => Carbon::now()->subDays(20),
            'nueva_fecha' => Carbon::now()->addDays(3),
            'motivo' => 'Cambio por disponibilidad del responsable.',
            'usuario_id' => $usuario->id,
        ]);

        $this->command->info('✅ Reprogramaciones creadas correctamente.');
    }
}
