<?php

namespace Modules\Eventos\Notifications\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Envía un mensaje por WhatsApp usando la API de Twilio.
     *
     * @param string $to Número de destino (ejemplo: +573001112233)
     * @param string $message Contenido del mensaje
     * @return bool true si fue exitoso, false si falló
     */
    public function send(string $to, string $message): bool
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken  = env('TWILIO_AUTH_TOKEN');
        $from       = env('TWILIO_WHATSAPP_FROM');

        try {
            if (!$accountSid || !$authToken || !$from) {
                Log::error('❌ Faltan credenciales Twilio en el .env');
                return false;
            }

            $verify = env('APP_ENV') === 'production'; // activa SSL solo en producción

            $response = Http::withBasicAuth($accountSid, $authToken)
                ->withOptions(['verify' => $verify])
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                    'From' => 'whatsapp:' . $from,
                    'To'   => 'whatsapp:' . $to,
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("✅ WhatsApp enviado a {$to}: {$message}");
                return true;
            }

            Log::error('❌ Error WhatsApp Twilio: ' . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error('❌ Excepción WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
