<?php

namespace Modules\Reprogramaciones\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Reprogramaciones\Models\Reprogramacion;
use Modules\Eventos\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $evento = Event::findOrFail($evento_id);
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

    DB::beginTransaction();
    try {
        $evento = \Modules\Eventos\Models\Event::findOrFail($request->evento_id);

        // Guardar evidencia si existe
        $evidenciaPath = null;
        if ($request->hasFile('evidencia')) {
            $evidenciaPath = $request->file('evidencia')->store('evidencias', 'public');
        }

        // Crear registro de reprogramación
        Reprogramacion::create([
            'evento_id' => $evento->id,
            'usuario_id' => auth()->id(),
            'motivo' => $request->motivo,
            'fecha_anterior' => $evento->due_date,
            'nueva_fecha' => $request->nueva_fecha,
            'evidencia' => $evidenciaPath,
        ]);

        // Actualizar la fecha del evento
        $evento->due_date = $request->nueva_fecha;
        $evento->save();

        DB::commit();

        return redirect()
            ->route('reprogramaciones.index')
            ->with('success', '✅ Reprogramación registrada y evento actualizado correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->with('error', '⚠️ Error al guardar la reprogramación: ' . $e->getMessage());
    }
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
        return redirect()->route('reprogramaciones.index')
            ->with('success', '📝 Reprogramación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $reprogramacion = Reprogramacion::findOrFail($id);

        // Eliminar evidencia si existe
        if ($reprogramacion->evidencia && Storage::disk('public')->exists($reprogramacion->evidencia)) {
            Storage::disk('public')->delete($reprogramacion->evidencia);
        }

        $reprogramacion->delete();
        return redirect()->route('reprogramaciones.index')
            ->with('success', '🗑️ Reprogramación eliminada correctamente.');
    }
}
