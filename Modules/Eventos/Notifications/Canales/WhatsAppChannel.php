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

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            Log::warning('❌ Notificación sin toWhatsApp(): ' . get_class($notification));
            return;
        }

        $to = $notifiable->telefono ?? null;
        if (!$to) {
            Log::warning("❌ Usuario sin teléfono WhatsApp: {$notifiable->email}");
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        Log::info("📲 Enviando WhatsApp a {$to}");
        $this->whatsapp->send($to, $message);
    }
}
