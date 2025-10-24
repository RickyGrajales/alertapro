<?php

namespace Modules\Eventos\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Eventos\Models\Event;
use Modules\Eventos\Notifications\EventoRecordatorioNotification;
use Carbon\Carbon;

class NotificarEventosCommand extends Command
{
    /**
     * Nombre del comando.
     */
    protected $signature = 'alertapro:notificar';

    /**
     * Descripción del comando.
     */
    protected $description = 'Envía notificaciones de eventos próximos a vencer o reprogramados.';

    /**
     * Ejecución del comando.
     */
    public function handle()
    {
        Log::info('🕐 Ejecutando comando alertapro:notificar...');

        $hoy = Carbon::today();
        $manana = Carbon::tomorrow();

        // Buscar eventos cuya fecha límite sea HOY o MAÑANA
        $eventos = Event::whereBetween('due_date', [$hoy, $manana])
                        ->with('responsable')
                        ->get();

        if ($eventos->isEmpty()) {
            $this->info('No hay eventos próximos a vencer.');
            Log::info('✅ No hay eventos próximos a notificar.');
            return Command::SUCCESS;
        }

        foreach ($eventos as $evento) {
            $responsable = $evento->responsable;
            if ($responsable) {
                Notification::send($responsable, new EventoRecordatorioNotification($evento));
                Log::info("📩 Notificación enviada a {$responsable->nombre} por el evento {$evento->titulo}");
            }
        }

        $this->info('✅ Notificaciones enviadas correctamente.');
        Log::info('✅ Proceso completado correctamente.');

        return Command::SUCCESS;
    }
}
