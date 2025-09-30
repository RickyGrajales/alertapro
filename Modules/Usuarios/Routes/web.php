<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsuariosController;

// Rutas protegidas para Usuarios (solo Admin)
Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::resource('usuarios', UsuariosController::class)->names('usuarios');

});
