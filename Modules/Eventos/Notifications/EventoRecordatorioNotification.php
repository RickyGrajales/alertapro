<?php

namespace Modules\Eventos\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Eventos\Models\Event;
use Modules\Eventos\Notifications\Canales\WhatsAppChannel;


class EventoRecordatorioNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $evento;

    public function __construct(Event $evento)
    {
        $this->evento = $evento;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("⏰ Recordatorio: {$this->evento->titulo}")
            ->greeting("Hola {$notifiable->nombre},")
            ->line("Te recordamos que el evento **{$this->evento->titulo}** tiene fecha límite el **{$this->evento->due_date->format('d/m/Y')}**.")
            ->action('Ver evento', url("/eventos/{$this->evento->id}"))
            ->line('Por favor verifica tu panel de tareas en AlertaPro.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => 'Recordatorio de evento',
            'mensaje' => "Tu evento '{$this->evento->titulo}' vence pronto.",
            'evento_id' => $this->evento->id,
            'fecha' => now(),
        ];
    }
}
