<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Modules\Eventos\Http\Controllers\EventosController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

// Login y Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Notificaciones (leer todas)
    Route::get('/notificaciones/leer-todas', function () {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return back()->with('success', '✅ Todas las notificaciones marcadas como leídas.');
    })->name('notificaciones.leer-todas');

    

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | MÓDULOS (vinculados a Nwidart Modules)
    |--------------------------------------------------------------------------
    */
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [\Modules\Usuarios\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios.index');
    });

    Route::prefix('organizaciones')->group(function () {
        Route::get('/', [\Modules\Organizaciones\Http\Controllers\OrganizacionesController::class, 'index'])->name('organizaciones.index');
    });

    Route::prefix('plantillas')->group(function () {
        Route::get('/', [\Modules\Plantillas\Http\Controllers\PlantillasController::class, 'index'])->name('plantillas.index');
    });

    Route::prefix('eventos')->group(function () {
        Route::get('/', [\Modules\Eventos\Http\Controllers\EventosController::class, 'index'])->name('eventos.index');
    });
    

    Route::prefix('reprogramaciones')->group(function () {
        Route::get('/', [\Modules\Reprogramaciones\Http\Controllers\ReprogramacionesController::class, 'index'])->name('reprogramaciones.index');
    });

    // NUEVA RUTA DE DELEGACIÓN
    Route::post('eventos/{id}/delegar', [EventosController::class, 'delegar'])->name('eventos.delegar');
});

// Laravel Breeze / Jetstream (si aplica)
require __DIR__.'/auth.php';
