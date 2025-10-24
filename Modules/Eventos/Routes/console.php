<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Programar el comando del motor de notificaciones
Schedule::command('alertapro:notificar')->hourly(); // o dailyAt('08:00')

// Comando de ejemplo (opcional)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
