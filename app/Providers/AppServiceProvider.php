<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Modules\Eventos\Notifications\Canales\WhatsAppChannel;
use Modules\Eventos\Notifications\Services\WhatsAppService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Notification::extend('whatsapp', function ($app) {
            return new WhatsAppChannel(
                $app->make(WhatsAppService::class)
            );
        });
    }
}
