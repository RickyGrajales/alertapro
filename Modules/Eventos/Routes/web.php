<?php

use Illuminate\Support\Facades\Route;
use Modules\Eventos\Http\Controllers\EventosController;
use Modules\Eventos\Http\Controllers\NotificacionesController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {

    // 🗓️ EVENTOS
    Route::get('eventos', [EventosController::class, 'index'])->name('eventos.index');
    Route::get('eventos/crear', [EventosController::class, 'create'])->name('eventos.create');
    Route::post('eventos', [EventosController::class, 'store'])->name('eventos.store');
    Route::get('eventos/{evento}', [EventosController::class, 'show'])->name('eventos.show');
    Route::get('eventos/{evento}/editar', [EventosController::class, 'edit'])->name('eventos.edit');
    Route::put('eventos/{evento}', [EventosController::class, 'update'])->name('eventos.update');
    Route::delete('eventos/{evento}', [EventosController::class, 'destroy'])->name('eventos.destroy');

    // 👤 DELEGACIÓN DE EVENTOS
    Route::get('eventos/{id}/delegar', [EventosController::class, 'mostrarFormularioDelegar'])
        ->name('eventos.delegar.form');
    Route::post('eventos/{id}/delegar', [EventosController::class, 'delegar'])
        ->name('eventos.delegar');

    // 🔔 NOTIFICACIONES
    Route::get('notificaciones', [NotificacionesController::class, 'index'])
        ->name('notificaciones.index');

    Route::get('notificaciones/enviar/{evento}', [NotificacionesController::class, 'enviarManual'])
        ->name('notificaciones.enviar');

    Route::get('notificaciones/leidas/todas', [NotificacionesController::class, 'marcarTodasComoLeidas'])
        ->name('notificaciones.marcar-todas'); // 🔹 nombre corregido
});
