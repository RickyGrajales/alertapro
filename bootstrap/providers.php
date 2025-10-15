<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proveedores del sistema base de Laravel
    |--------------------------------------------------------------------------
    */
    App\Providers\AppServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Módulos personalizados (Nwidart Modules)
    |--------------------------------------------------------------------------
    |
    | Cada módulo del sistema debe registrar su propio ServiceProvider aquí
    | para que Laravel cargue sus rutas, vistas, migraciones y traducciones.
    |
    */

    Modules\Usuarios\Providers\UsuariosServiceProvider::class,
    Modules\Organizaciones\Providers\OrganizacionesServiceProvider::class,
    Modules\Plantillas\Providers\PlantillasServiceProvider::class,
    Modules\Eventos\Providers\EventosServiceProvider::class,
    Modules\Reprogramaciones\Providers\ReprogramacionesServiceProvider::class,
];
