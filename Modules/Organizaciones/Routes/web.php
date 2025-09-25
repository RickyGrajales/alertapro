<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('organizaciones', OrganizacionesController::class)->names('organizaciones');
});
