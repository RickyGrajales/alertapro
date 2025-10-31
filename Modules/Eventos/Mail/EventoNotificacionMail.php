<?php

namespace Modules\Eventos\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Eventos\Models\Event;

class EventoNotificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;

    /**
     * Crear una nueva instancia del correo.
     */
    public function __construct(Event $evento)
    {
        $this->evento = $evento;
    }

    /**
     * Construir el mensaje del correo.
     */
    public function build()
    {
        return $this->from('alertapro@notificaciones.com', 'AlertaPro Notificaciones')
            ->subject('📅 Recordatorio de evento: ' . $this->evento->titulo)
            ->view('eventos::emails.evento_recordatorio')
            ->with([
                'evento' => $this->evento,
                'responsable' => $this->evento->responsable,
            ]);
    }
}
