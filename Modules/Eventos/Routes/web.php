<?php

use Illuminate\Support\Facades\Route;
use Modules\Eventos\Http\Controllers\EventosController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('eventos', [EventosController::class, 'index'])->name('eventos.index');
    Route::get('eventos/crear', [EventosController::class, 'create'])->name('eventos.create');
    Route::post('eventos', [EventosController::class, 'store'])->name('eventos.store');
    Route::get('eventos/{evento}', [EventosController::class, 'show'])->name('eventos.show');
    Route::get('eventos/{evento}/editar', [EventosController::class, 'edit'])->name('eventos.edit');
    Route::put('eventos/{evento}', [EventosController::class, 'update'])->name('eventos.update');
    Route::delete('eventos/{evento}', [EventosController::class, 'destroy'])->name('eventos.destroy');

    //  Delegación de evento
    Route::get('eventos/{id}/delegar', [EventosController::class, 'mostrarFormularioDelegar'])->name('eventos.delegar.form');
    Route::post('eventos/{id}/delegar', [EventosController::class, 'delegar'])->name('eventos.delegar');
});
