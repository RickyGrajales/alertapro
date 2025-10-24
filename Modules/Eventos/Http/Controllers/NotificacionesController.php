<?php

namespace Modules\Eventos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Eventos\Models\Event;
use Modules\Eventos\Models\NotificacionLog;
use Modules\Eventos\Mail\EventoNotificacionMail;
use Illuminate\Support\Facades\Mail;

class NotificacionesController extends Controller
{
    public function index()
    {
        $logs = NotificacionLog::with(['evento', 'usuario'])->latest()->paginate(10);
        return view('eventos::notificaciones.index', compact('logs'));
    }

    public function enviarManual($evento_id)
    {
        $evento = Event::with('responsable')->findOrFail($evento_id);
        $usuario = $evento->responsable;

        try {
            Mail::to($usuario->email)->send(new EventoNotificacionMail($evento));

            NotificacionLog::create([
                'evento_id'   => $evento->id,
                'user_id'     => $usuario->id,
                'canal'       => 'email',
                'destinatario'=> $usuario->email,
                'mensaje'     => "Notificación manual enviada para {$evento->titulo}",
                'enviado_en'  => now(),
                'exitoso'     => true,
            ]);

            return back()->with('success', "Notificación enviada a {$usuario->nombre}");
        } catch (\Exception $e) {
            NotificacionLog::create([
                'evento_id'   => $evento->id,
                'user_id'     => $usuario->id,
                'canal'       => 'email',
                'destinatario'=> $usuario->email,
                'mensaje'     => "Error al enviar notificación manual.",
                'exitoso'     => false,
                'error'       => $e->getMessage(),
            ]);

            return back()->with('error', " Error: {$e->getMessage()}");
        }
    }
}
