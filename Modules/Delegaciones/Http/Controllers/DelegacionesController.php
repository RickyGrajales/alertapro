<?php

namespace Modules\Delegaciones\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Delegaciones\Models\Delegacion;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\DB;

class DelegacionesController extends Controller
{
    public function index()
    {
        $delegaciones = Delegacion::with(['evento', 'de', 'para'])->latest()->get();
        return view('delegaciones::index', compact('delegaciones'));
    }

    public function create($evento_id)
    {
        $evento = Event::with('responsable')->findOrFail($evento_id);
        $usuarios = Usuario::select('id', 'nombre', 'email')->orderBy('nombre')->get();
        return view('delegaciones::create', compact('evento', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'to_user_id' => 'required|exists:usuarios,id|different:'.auth()->id(),
            'motivo' => 'required|string|max:1000',
        ]);

       DB::transaction(function () use ($request) {
        $evento = Event::findOrFail($request->evento_id);

        $delegacion = Delegacion::create([
            'evento_id' => $evento->id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'motivo' => $request->motivo,
        ]);

        // Actualizar responsable del evento
        $evento->update(['responsable_id' => $request->to_user_id]);

        // Enviar notificación al nuevo responsable
        $nuevoResponsable = \Modules\Usuarios\Models\Usuario::find($request->to_user_id);
        $delegador = auth()->user();

        $nuevoResponsable->notify(new \App\Notifications\EventoDelegadoNotification($evento, $delegador));
    });

    return redirect()->route('eventos.index')
                     ->with('success', '✅ Evento delegado y notificación enviada.');
    }
    

    public function show($id)
    {
        $delegacion = Delegacion::with(['evento', 'de', 'para'])->findOrFail($id);
        return view('delegaciones::show', compact('delegacion'));
    }

    public function destroy($id)
    {
        $delegacion = Delegacion::findOrFail($id);
        $delegacion->delete();
        return redirect()->route('delegaciones.index')
                         ->with('success', '🗑️ Delegación eliminada.');
    }
}
