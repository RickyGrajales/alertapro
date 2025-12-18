<?php

namespace App\Http\Controllers;

use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;
use Modules\Organizaciones\Models\Organizacion;
use Modules\Eventos\Models\NotificacionLog;


class DashboardController extends Controller
{
    public function index()
    {
        // ======================
        // KPIs PRINCIPALES
        // ======================
        $eventosActivos = Event::where('estado', 'Activo')->count();
        $usuarios = Usuario::count();
        $organizaciones = Organizacion::count();
        $notificaciones = NotificacionLog::count();

        // ======================
        // ESTADOS DE EVENTOS
        // ======================
        $pendientes   = Event::where('estado', 'Pendiente')->count();
        $enProceso    = Event::where('estado', 'En Proceso')->count();
        $completados  = Event::where('estado', 'Completado')->count();

        // ======================
        // ACTIVIDAD RECIENTE
        // ======================
        $actividades = NotificacionLog::latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'usuario'     => $log->user->nombre ?? 'Sistema',
                    'descripcion' => $log->mensaje,
                    'fecha'       => $log->created_at->diffForHumans(),
                ];
            });

        // ======================
        // PRÓXIMOS EVENTOS
        // ======================
        $proximosEventos = Event::whereDate('due_date', '>=', now())
            ->whereDate('due_date', '<=', now()->addDays(7))
            ->orderBy('due_date', 'asc')
            ->get();

        return view('dashboard', compact(
            'eventosActivos',
            'usuarios',
            'organizaciones',
            'notificaciones',
            'pendientes',
            'enProceso',
            'completados',
            'actividades',
            'proximosEventos'
        ));
    }
}
