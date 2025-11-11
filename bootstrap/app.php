<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Middlewares locales y de Spatie (según disponibilidad)
use App\Http\Middleware\RoleMiddleware as LocalRoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Alias de middlewares
        // Se usa el RoleMiddleware local para evitar incompatibilidades en Laravel 12.
        $middleware->alias([
            'role' => LocalRoleMiddleware::class,
        ]);

        // ✅ Si Spatie está disponible, registra los demás
        if (class_exists(PermissionMiddleware::class)) {
            $middleware->alias([
                'permission' => PermissionMiddleware::class,
                'role_or_permission' => RoleOrPermissionMiddleware::class,
            ]);
        }
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // ⏰ Tareas programadas (cron)
        $schedule->command('alertapro:notificar')->dailyAt('08:00');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
