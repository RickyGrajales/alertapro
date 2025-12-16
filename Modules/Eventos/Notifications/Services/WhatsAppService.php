<?php

namespace Modules\Eventos\Notifications\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function send(string $to, string $message): bool
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken  = env('TWILIO_AUTH_TOKEN');
        $from       = env('TWILIO_WHATSAPP_FROM');

        if (!$accountSid || !$authToken || !$from) {
            Log::error('❌ Faltan credenciales Twilio en el .env');
            return false;
        }

        try {
            $response = Http::withBasicAuth($accountSid, $authToken)
                ->withOptions([
                    'verify' => false, // 🔴 CLAVE: en XAMPP debe ser false
                ])
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                    'From' => 'whatsapp:' . $from,
                    'To'   => 'whatsapp:' . $to,
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("✅ WhatsApp enviado a {$to}");
                return true;
            }

            Log::error('❌ Twilio error: ' . $response->body());
            return false;

        } catch (\Throwable $e) {
            Log::error('❌ Excepción WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
