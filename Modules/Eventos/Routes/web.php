<?php

use Illuminate\Support\Facades\Route;
use Modules\Eventos\Http\Controllers\EventosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('eventos', EventosController::class)->names('eventos');
});
