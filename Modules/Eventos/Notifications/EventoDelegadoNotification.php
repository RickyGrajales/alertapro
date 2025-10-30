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

    /**
     * Canales por los que se envía la notificación.
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'whatsapp'];
    }

    /**
     * Contenido del correo electrónico (Brevo).
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📌 Nuevo evento delegado: ' . $this->evento->titulo)
            ->greeting('Hola ' . $notifiable->nombre . ',')
            ->line("Te informamos que el evento **{$this->evento->titulo}** te ha sido delegado por **{$this->delegador->nombre}**.")
            ->line('Por favor, revisa los detalles y continúa con la gestión asignada.')
            ->action('Ver evento', url('/eventos/' . $this->evento->id))
            ->line('Gracias por tu compromiso con el proyecto Atrapasueños.');
    }

    /**
     * Contenido para la base de datos.
     */
    public function toDatabase($notifiable)
    {
        return [
            'titulo' => 'Evento delegado',
            'mensaje' => "El evento '{$this->evento->titulo}' te ha sido delegado por {$this->delegador->nombre}.",
            'evento_id' => $this->evento->id,
            'fecha' => now()->format('d/m/Y H:i'),
        ];
    }


    public function toWhatsapp($notifiable)
{
    $mensaje = "Hola {$notifiable->nombre}, se te ha delegado el evento '{$this->evento->titulo}' para el día {$this->evento->due_date->format('d/m/Y')}.";

    app(\Modules\Eventos\Notifications\Services\WhatsAppService::class)
        ->send($notifiable->telefono, $mensaje);
}


    /**
     * Opcional (para API o broadcast futuro)
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
