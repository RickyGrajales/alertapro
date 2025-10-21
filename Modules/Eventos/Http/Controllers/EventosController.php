<?php

namespace Modules\Eventos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Eventos\Models\Event;
use Modules\Usuarios\Models\Usuario;
use Modules\Plantillas\Models\Template;
use Modules\Reprogramaciones\Models\Reprogramacion;
use App\Notifications\EventoDelegadoNotification;


class EventosController extends Controller
{
    // Listar
    public function index()
    {
        $eventos = Event::with(['responsable', 'plantilla'])
            ->orderBy('due_date', 'desc')
            ->paginate(10);

        return view('eventos::index', compact('eventos'));
    }

    // Formulario crear
    public function create()
    {
        $usuarios = Usuario::select('id', 'nombre', 'email')->get();
        $plantillas = Template::select('id', 'nombre')->get();

        return view('eventos::create', compact('usuarios', 'plantillas'));
    }

    // Guardar
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255|unique:eventos,titulo',
            'descripcion' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'responsable_id' => 'required|exists:usuarios,id',
            'plantilla_id' => 'nullable|exists:templates,id',
        ]);

        $validated['estado'] = 'Pendiente';

        $evento = Event::create($validated);

        if ($evento->plantilla_id && method_exists($evento, 'generarChecklistDesdePlantilla')) {
            $evento->generarChecklistDesdePlantilla();
        }

        return redirect()->route('eventos.index')->with('success', ' Evento creado correctamente.');
    }

    // Ver
    public function show(Event $evento)
    {
        $evento->load(['responsable', 'plantilla.items']);
        return view('eventos::show', compact('evento'));
    }

    // Editar (form)
    public function edit(Event $evento)
    {
        $usuarios = Usuario::select('id', 'nombre', 'email')->get();
        $plantillas = Template::select('id', 'nombre')->get();

        return view('eventos::edit', compact('evento', 'usuarios', 'plantillas'));
    }

    // Actualizar
    public function update(Request $request, Event $evento)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255|unique:eventos,titulo,' . $evento->id,
            'descripcion' => 'nullable|string',
            'due_date' => 'required|date',
            'estado' => 'required|in:Pendiente,En Proceso,Completado',
            'responsable_id' => 'required|exists:usuarios,id',
            'plantilla_id' => 'nullable|exists:templates,id',
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.show', $evento)->with('success', ' Evento actualizado correctamente.');
    }


    public function mostrarFormularioDelegar($id)
{
    $evento = Event::findOrFail($id);
    $usuarios = \Modules\Usuarios\Models\Usuario::select('id', 'nombre', 'email')->get();

    return view('eventos::delegar', compact('evento', 'usuarios'));
}


    //Metodo delegar
    
public function delegar(Request $request, $id)
{
    $request->validate([
        'nuevo_responsable_id' => 'required|exists:usuarios,id',
        'motivo' => 'required|string|max:255',
    ]);

    $evento = \Modules\Eventos\Models\Event::findOrFail($id);

    DB::beginTransaction();
    try {
        $responsableAnterior = $evento->responsable;
        $evento->update(['responsable_id' => $request->nuevo_responsable_id]);

        // Registrar historial de delegación
        \Modules\Reprogramaciones\Models\Reprogramacion::create([
            'evento_id' => $evento->id,
            'usuario_id' => auth()->id(),
            'motivo' => 'Delegación: ' . $request->motivo,
            'fecha_anterior' => now(),
            'nueva_fecha' => $evento->due_date,
        ]);

        // Notificación
        $nuevoResponsable = \Modules\Usuarios\Models\Usuario::find($request->nuevo_responsable_id);
        $nuevoResponsable->notify(new \App\Notifications\EventoDelegadoNotification($evento, auth()->user()));

        DB::commit();

        return redirect()->route('eventos.index')
                         ->with('success', "El evento fue delegado correctamente a {$nuevoResponsable->nombre}.");
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Ocurrió un error al delegar el evento.']);
    }
}



    // Eliminar
    public function destroy(Event $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }
}

