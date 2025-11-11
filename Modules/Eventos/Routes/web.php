<?php

use Illuminate\Support\Facades\Route;
use Modules\Eventos\Http\Controllers\EventosController;
use Modules\Eventos\Http\Controllers\NotificacionesController;
use Modules\Eventos\Http\Controllers\DocumentosController;

/*
|--------------------------------------------------------------------------
| Rutas del módulo EVENTOS
|--------------------------------------------------------------------------
| - Admin puede crear, editar, eliminar, delegar, notificar.
| - Empleado solo puede ver sus eventos.
|--------------------------------------------------------------------------
*/

// 🟦 Rutas accesibles para cualquier usuario autenticado
Route::middleware(['web', 'auth', 'verified'])->group(function () {

    // Listado y vista individual (Admin y Empleado)
    Route::get('eventos', [EventosController::class, 'index'])->name('eventos.index');
    Route::get('eventos/{evento}', [EventosController::class, 'show'])->name('eventos.show');

    // Notificaciones (ver e historial)
    Route::get('notificaciones', [NotificacionesController::class, 'index'])->name('notificaciones.index');
    Route::get('notificaciones/leidas/todas', [NotificacionesController::class, 'marcarTodasComoLeidas'])
        ->name('notificaciones.marcar-todas');

    Route::prefix('eventos/{evento_id}/documentos')->group(function () {
    Route::get('/', [DocumentosController::class, 'index'])->name('documentos.index');
    Route::post('/', [DocumentosController::class, 'store'])->name('documentos.store');
    Route::get('/descargar/{id}', [DocumentosController::class, 'download'])->name('documentos.download');
    Route::delete('/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy');
});

// 🟩 Rutas exclusivas del rol ADMIN
Route::middleware(['web', 'auth', 'verified', 'role:Admin'])->group(function () {

    // CRUD completo de eventos
    Route::get('eventos/crear', [EventosController::class, 'create'])->name('eventos.create');
    Route::post('eventos', [EventosController::class, 'store'])->name('eventos.store');
    Route::get('eventos/{evento}/editar', [EventosController::class, 'edit'])->name('eventos.edit');
    Route::put('eventos/{evento}', [EventosController::class, 'update'])->name('eventos.update');
    Route::delete('eventos/{evento}', [EventosController::class, 'destroy'])->name('eventos.destroy');

    // Delegación de eventos
    Route::get('eventos/{id}/delegar', [EventosController::class, 'mostrarFormularioDelegar'])
        ->name('eventos.delegar.form');
    Route::post('eventos/{id}/delegar', [EventosController::class, 'delegar'])
        ->name('eventos.delegar');

    // Notificaciones manuales
    Route::get('notificaciones/enviar/{evento}', [NotificacionesController::class, 'enviarManual'])
        ->name('notificaciones.enviar');
});
