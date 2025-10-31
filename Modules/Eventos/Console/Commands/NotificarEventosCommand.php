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
    protected $description = 'Envía notificaciones de recordatorio para eventos próximos a vencer.';

    /**
     * Ejecuta el comando.
     */
    public function handle()
    {
        $hoy = Carbon::now()->startOfDay();
        $manana = Carbon::now()->addDay()->endOfDay();

        // Filtramos eventos entre hoy y mañana y que estén activos o pendientes
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
            if ($evento->responsable && $evento->responsable->email) {
                try {
                    Notification::send($evento->responsable, new EventoRecordatorioNotification($evento));
                    $this->info("✅ Notificación enviada a {$evento->responsable->nombre}");
                    Log::info("📩 Recordatorio enviado a {$evento->responsable->email}");
                } catch (\Throwable $e) {
                    Log::error("❌ Error notificando a {$evento->responsable->nombre}: " . $e->getMessage());
                    $this->error("⚠️ Error con {$evento->responsable->nombre}");
                }
            } else {
                Log::warning("⚠️ Evento {$evento->id} sin responsable asignado o sin email.");
            }
        }

        $this->info('🎯 Recordatorios enviados correctamente.');
        return Command::SUCCESS;
    }
}
