<?php

namespace Modules\Eventos\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Eventos\Models\Event;

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
        $canales = ['mail', 'database'];

        if (!empty($notifiable->telefono)) {
            $canales[] = 'whatsapp';
        }

        return $canales;
    }

    public function toMail($notifiable)
    {
        \Log::info("📧 Enviando correo a: {$notifiable->email}");

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

    public function toWhatsApp($notifiable)
    {
        return "📅 *Recordatorio de evento:* {$this->evento->titulo}\n📆 Fecha límite: {$this->evento->due_date}\n💬 Estado: {$this->evento->estado}";
    }
}
