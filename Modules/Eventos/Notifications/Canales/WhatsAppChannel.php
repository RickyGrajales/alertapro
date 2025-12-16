<?php

namespace Modules\Eventos\Notifications\Canales;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Eventos\Notifications\Services\WhatsAppService;

class WhatsAppChannel
{
    protected WhatsAppService $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            Log::warning('❌ Notificación sin toWhatsApp(): ' . get_class($notification));
            return;
        }

        // 🔑 Laravel obtiene el destino desde el modelo
        $to = $notifiable->routeNotificationFor('whatsapp');

        if (!$to) {
            Log::warning('❌ Usuario sin ruta WhatsApp: ' . get_class($notifiable));
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        Log::info("📲 Enviando WhatsApp a {$to}");

        $this->whatsapp->send($to, $message);
    }
}
