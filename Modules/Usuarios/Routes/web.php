<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsuariosController;

// Rutas protegidas para Usuarios
Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::resource('usuarios', UsuariosController::class)->names('usuarios');
});

Route::middleware(['auth', 'verified', 'role:Admin|Supervisor'])->group(function () {
    Route::resource('organizaciones', OrganizacionesController::class)->names('organizaciones');
});