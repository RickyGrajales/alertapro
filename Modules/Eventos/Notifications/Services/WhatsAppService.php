<?php

namespace Modules\Eventos\Notifications\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function send(string $to, string $message): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('TWILIO_AUTH_TOKEN'),
            ])->post('https://api.twilio.com/2010-04-01/Accounts/' . env('TWILIO_ACCOUNT_SID') . '/Messages.json', [
                'From' => 'whatsapp:' . env('TWILIO_WHATSAPP_FROM'),
                'To' => 'whatsapp:' . $to,
                'Body' => $message,
            ]);

            Log::info('✅ WhatsApp enviado a ' . $to);
            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('❌ Error enviando WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
