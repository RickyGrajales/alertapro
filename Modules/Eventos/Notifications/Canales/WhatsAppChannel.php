<?php

namespace Modules\Eventos\Notifications\Canales;

use Modules\Eventos\Notifications\Services\WhatsAppService;

class WhatsAppChannel
{
    public function send($notifiable, $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        $phone = $notifiable->telefono ?? null;

        if ($phone) {
            (new WhatsAppService())->send($phone, $message);
        }
    }
}
