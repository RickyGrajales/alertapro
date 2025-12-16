<?php

namespace Modules\Eventos\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Registro explícito de listeners del módulo Eventos.
     *
     * @var array
     */
    protected $listen = [
        // Aquí puedes agregar eventos en el futuro
        // \Modules\Eventos\Events\EventoCreado::class => [
        //     \Modules\Eventos\Listeners\EnviarNotificacionEvento::class,
        // ],
    ];

    /**
     * IMPORTANTE:
     * No se tipa esta propiedad para evitar error fatal en PHP.
     */
    protected static $shouldDiscoverEvents = false;
}
