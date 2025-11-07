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
    protected $description = 'Envía notificaciones de recordatorio para eventos próximos a vencer.';

    public function handle()
    {
        $hoy = Carbon::now()->startOfDay();
        $manana = Carbon::now()->addDay()->endOfDay();

        $eventos = Event::whereBetween('due_date', [$hoy, $manana])
            ->whereIn('estado', ['Pendiente', 'En progreso'])
            ->with('responsable')
            ->get();

        if ($eventos->isEmpty()) {
            $this->info('📭 No hay eventos próximos a vencer.');
            Log::info('⏰ Comando ejecutado: sin eventos próximos a vencer.');
            return Command::SUCCESS;
        }

        foreach ($eventos as $evento) {
            $usuario = $evento->responsable;

            if ($usuario) {
                Notification::send($usuario, new EventoRecordatorioNotification($evento));
                Log::info("📨 Notificación enviada a {$usuario->nombre} ({$usuario->email} / {$usuario->telefono})");
            } else {
                Log::warning("⚠️ Evento {$evento->id} sin responsable asignado.");
            }
        }

        $this->info('🎯 Recordatorios enviados correctamente.');
        return Command::SUCCESS;
    }
}
