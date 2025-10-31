<?php

namespace Modules\Eventos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Eventos\Models\Event;
use Modules\Eventos\Models\NotificacionLog;
use Modules\Eventos\Mail\EventoNotificacionMail;
use Modules\Eventos\Notifications\Services\WhatsAppService;

class NotificacionesController extends Controller
{
    /**
     * Muestra el historial de notificaciones.
     */
    public function index()
    {
        $logs = NotificacionLog::with(['evento', 'usuario'])
            ->latest()
            ->paginate(10);

        return view('eventos::notificaciones.index', compact('logs'));
    }

    /**
     * Envía notificación manual (email + WhatsApp) para un evento.
     */
    public function enviarManual($evento_id)
    {
        $evento = Event::with('responsable')->findOrFail($evento_id);
        $usuario = $evento->responsable;

        if (!$usuario) {
            return back()->with('error', 'El evento no tiene responsable asignado.');
        }

        $exitoCorreo = false;
        $exitoWhatsApp = false;
        $errorCorreo = null;
        $errorWhatsApp = null;

        // === Envío de correo ===
        try {
            Mail::to($usuario->email)->send(new EventoNotificacionMail($evento));
            $exitoCorreo = true;

            NotificacionLog::create([
                'evento_id'    => $evento->id,
                'user_id'      => $usuario->id,
                'canal'        => 'email',
                'destinatario' => $usuario->email,
                'mensaje'      => "Notificación manual enviada a {$usuario->nombre} para el evento {$evento->titulo}",
                'enviado_en'   => now(),
                'exitoso'      => true,
            ]);
        } catch (\Exception $e) {
            $errorCorreo = $e->getMessage();
            NotificacionLog::create([
                'evento_id'    => $evento->id,
                'user_id'      => $usuario->id,
                'canal'        => 'email',
                'destinatario' => $usuario->email,
                'mensaje'      => "Error al enviar correo del evento {$evento->titulo}",
                'exitoso'      => false,
                'error'        => $errorCorreo,
            ]);
            Log::error("❌ Error enviando correo: $errorCorreo");
        }

        // === Envío de WhatsApp ===
        try {
            $mensaje = "📅 *Recordatorio de evento:* {$evento->titulo}\n📆 Fecha límite: {$evento->due_date?->format('d/m/Y')}\n💬 Estado: {$evento->estado}";
            $whatsapp = app(WhatsAppService::class);
            $resultado = $whatsapp->send($usuario->telefono ?? '+573000000000', $mensaje);

            if ($resultado) {
                $exitoWhatsApp = true;
                NotificacionLog::create([
                    'evento_id'    => $evento->id,
                    'user_id'      => $usuario->id,
                    'canal'        => 'whatsapp',
                    'destinatario' => $usuario->telefono ?? '+573000000000',
                    'mensaje'      => $mensaje,
                    'enviado_en'   => now(),
                    'exitoso'      => true,
                ]);
            } else {
                throw new \Exception('Error desconocido al enviar WhatsApp.');
            }
        } catch (\Exception $e) {
            $errorWhatsApp = $e->getMessage();
            NotificacionLog::create([
                'evento_id'    => $evento->id,
                'user_id'      => $usuario->id,
                'canal'        => 'whatsapp',
                'destinatario' => $usuario->telefono ?? 'N/A',
                'mensaje'      => "Error al enviar WhatsApp del evento {$evento->titulo}",
                'exitoso'      => false,
                'error'        => $errorWhatsApp,
            ]);
            Log::error("❌ Error enviando WhatsApp: $errorWhatsApp");
        }

        // === Resultado ===
        if ($exitoCorreo || $exitoWhatsApp) {
            return back()->with('success', "✅ Notificación enviada a {$usuario->nombre} por correo y/o WhatsApp.");
        }

        return back()->with('error', "❌ Error al enviar notificaciones. Detalles: Correo({$errorCorreo}) - WhatsApp({$errorWhatsApp})");
    }

    /**
     * Marca todas las notificaciones como leídas.
     */
    public function marcarLeidas()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Todas las notificaciones fueron marcadas como leídas.');
    }
}
