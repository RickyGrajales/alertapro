<?php

namespace Modules\Reprogramaciones\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Reprogramaciones\Models\Reprogramacion;
use Modules\Eventos\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReprogramacionesController extends Controller
{
    public function index()
    {
        $reprogramaciones = Reprogramacion::with(['evento', 'usuario'])->latest()->get();
        return view('reprogramaciones::index', compact('reprogramaciones'));
    }

    public function create($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        return view('reprogramaciones::create', compact('evento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'motivo' => 'required|string|max:255',
            'nueva_fecha' => 'required|date|after:today',
            'evidencia' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('evidencia')) {
            $data['evidencia'] = $request->file('evidencia')->store('evidencias', 'public');
        }

        $data['usuario_id'] = auth()->id();
        $evento = Evento::find($data['evento_id']);
        $data['fecha_anterior'] = $evento->due_date;

        Reprogramacion::create($data);

        $evento->update(['due_date' => $data['nueva_fecha']]);

        return redirect()->route('reprogramaciones.index')
                         ->with('success', '✅ Reprogramación registrada correctamente.');
    }

    public function show($id)
    {
        $reprogramacion = Reprogramacion::with(['evento', 'usuario'])->findOrFail($id);
        return view('reprogramaciones::show', compact('reprogramacion'));
    }

    public function edit($id)
    {
        $reprogramacion = Reprogramacion::findOrFail($id);
        return view('reprogramaciones::edit', compact('reprogramacion'));
    }

    public function update(Request $request, $id)
    {
        $reprogramacion = Reprogramacion::findOrFail($id);

        $request->validate([
            'motivo' => 'required|string|max:255',
            'nueva_fecha' => 'required|date|after:today',
        ]);

        $reprogramacion->update($request->only(['motivo', 'nueva_fecha']));
        return redirect()->route('reprogramaciones.index')->with('success', '📝 Reprogramación actualizada.');
    }

    public function destroy($id)
    {
        $reprogramacion = Reprogramacion::findOrFail($id);
        $reprogramacion->delete();
        return redirect()->route('reprogramaciones.index')->with('success', '🗑️ Reprogramación eliminada.');
    }
}
