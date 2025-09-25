<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsuariosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('usuarios', UsuariosController::class)->names('usuarios');
});
