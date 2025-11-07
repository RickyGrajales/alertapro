<?php

namespace Modules\Eventos\Notifications\Canales;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Eventos\Notifications\Services\WhatsAppService;

class WhatsAppChannel
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Envía la notificación por WhatsApp (usando el servicio Twilio o 360Dialog)
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            Log::warning('❌ La notificación no implementa toWhatsApp(): ' . get_class($notification));
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        $to = $notifiable->telefono ?? null;

        if (!$to) {
            Log::warning("❌ Usuario sin teléfono válido para WhatsApp: {$notifiable->email}");
            return;
        }

        Log::info("📲 Enviando WhatsApp a {$to}");
        $this->whatsapp->send($to, $message);
    }
}
