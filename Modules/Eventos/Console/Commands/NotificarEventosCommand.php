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
    protected $signature = 'alertapro:notificar';
    protected $description = 'Envía notificaciones de recordatorio para eventos próximos a vencer';

    public function handle()
    {
        $eventos = Event::whereBetween('due_date', [Carbon::now(), Carbon::now()->addDay()])->get();

        if ($eventos->isEmpty()) {
            $this->info('No hay eventos próximos a vencer.');
            return;
        }

        foreach ($eventos as $evento) {
            if ($evento->responsable) {
                Notification::send($evento->responsable, new EventoRecordatorioNotification($evento));
                Log::info("📩 Recordatorio enviado a {$evento->responsable->nombre}");
            }
        }

        $this->info('✅ Recordatorios enviados correctamente.');
    }
}
