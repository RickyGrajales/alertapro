<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::middleware(['web', 'auth', 'verified', 'role:Admin'])
    ->group(function () {
        Route::resource('organizaciones', OrganizacionesController::class)
            ->parameters(['organizaciones' => 'organizacion']) // 👈 singular correcto
            ->names('organizaciones');
});

