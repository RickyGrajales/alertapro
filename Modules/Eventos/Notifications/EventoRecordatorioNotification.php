<?php

namespace Modules\Eventos\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
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
        $channels = ['database', 'mail'];

        if (!empty($notifiable->telefono)) {
            $channels[] = WhatsAppChannel::class; // Canal WhatsApp personalizado
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('🔔 Recordatorio de evento: ' . $this->evento->titulo)
                ->greeting('Hola ' . $notifiable->nombre . ',')
                ->line('Tienes un evento próximo:')
                ->line("📅 {$this->evento->titulo}")
                ->line("⏰ Fecha límite: " . $this->evento->due_date->format('d/m/Y H:i'))
                ->action('Ver evento', url("/eventos/{$this->evento->id}"))
                ->line('Por favor, revisa los detalles en AlertaPro.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => 'Recordatorio de evento',
            'mensaje' => "El evento '{$this->evento->titulo}' vence el {$this->evento->due_date->format('d/m/Y')}.",
            'evento_id' => $this->evento->id,
            'fecha' => now()->format('d/m/Y H:i'),
        ];
    }

    // Canal WhatsApp
    public function toWhatsApp($notifiable)
    {
        return " *Recordatorio de evento*\n\n"
            . "El evento *{$this->evento->titulo}* vence el *{$this->evento->due_date->format('d/m/Y')}*.\n\n"
            . " Ver detalles: " . url('/eventos/' . $this->evento->id);
    }
}
