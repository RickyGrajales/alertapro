<?php

namespace Modules\Eventos\Notifications;

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
        return ['mail', 'database', 'whatsapp'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📌 Nuevo evento delegado: ' . $this->evento->titulo)
            ->greeting('Hola ' . $notifiable->nombre . ',')
            ->line("El evento **{$this->evento->titulo}** fue delegado por **{$this->delegador->nombre}**.")
            ->action('Ver evento', url('/eventos/' . $this->evento->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => 'Evento delegado',
            'mensaje' => "El evento '{$this->evento->titulo}' te fue delegado.",
            'evento_id' => $this->evento->id,
            'fecha' => now(),
        ];
    }

    public function toWhatsApp($notifiable)
    {
        return "📌 *Evento delegado*\n\n📅 {$this->evento->titulo}\n👤 Delegado por: {$this->delegador->nombre}\n📆 Fecha límite: {$this->evento->due_date->format('d/m/Y')}";
    }
}
