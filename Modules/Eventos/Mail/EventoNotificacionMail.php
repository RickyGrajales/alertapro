<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Eventos\Models\Event;

class EventoNotificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;

    public function __construct(Event $evento)
    {
        $this->evento = $evento;
    }

    public function build()
    {
        return $this->subject("📅 Recordatorio: {$this->evento->titulo}")
                    ->view('emails.evento_notificacion')
                    ->with([
                        'titulo' => $this->evento->titulo,
                        'fecha' => $this->evento->due_date->format('d/m/Y'),
                        'descripcion' => $this->evento->descripcion,
                    ]);
    }
}
