<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Eventos\Models\Event;


class EventoDelegadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $evento;
    protected $delegador;

    public function __construct(Event $evento, $delegador)
    {
        $this->evento = $evento;
        $this->delegador = $delegador;
    }

    public function via($notifiable)
    {
        return ['database']; // Solo se guarda en base de datos
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => 'Evento delegado',
            'mensaje' => "El evento '{$this->evento->titulo}' te ha sido delegado por {$this->delegador->nombre}.",
            'evento_id' => $this->evento->id,
            'fecha' => now()->format('d/m/Y H:i'),
        ];
    }

    /**
     * Respaldo opcional (si usas API o broadcasting más adelante).
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
