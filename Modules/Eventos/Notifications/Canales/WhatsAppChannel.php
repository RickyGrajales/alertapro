<?php

namespace Modules\Eventos\Notifications\Canales;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Eventos\Services\WhatsAppService;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        try {
            $service = new WhatsAppService();
            $service->sendMessage($notifiable->telefono, $message);
            Log::info("📲 WhatsApp enviado a {$notifiable->telefono}");
        } catch (\Exception $e) {
            Log::error("❌ Error enviando WhatsApp: " . $e->getMessage());
        }
    }
}
