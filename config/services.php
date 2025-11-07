<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Este archivo almacena las credenciales para servicios externos como
    | Mailgun, Postmark, AWS, Twilio y otros. Aquí es donde Laravel busca
    | las configuraciones de cada servicio.
    |
    */

    // 🔹 Postmark
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    // 🔹 Resend
    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    // 🔹 Amazon SES
    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 🔹 Slack (para notificaciones internas)
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // 🔹 Twilio (para WhatsApp y SMS)
    'twilio' => [
        'sid'   => env('TWILIO_ACCOUNT_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'from'  => env('TWILIO_WHATSAPP_FROM'), // Ejemplo: 'whatsapp:+14155238886'
    ],

];
