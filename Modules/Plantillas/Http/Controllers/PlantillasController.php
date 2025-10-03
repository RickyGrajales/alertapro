<?php

namespace Modules\Plantillas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Plantillas\Models\Template;

class PlantillasController extends Controller
{
    // 📑 Listado
    public function index()
    {
        $plantillas = Template::withCount('items')->orderBy('created_at','desc')->paginate(10);
        return view('plantillas::index', compact('plantillas'));
    }

    // ➕ Crear
    public function create()
    {
        return view('plantillas::create');
    }

    // 💾 Guardar nueva
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:templates,nombre',
            'descripcion' => 'nullable|string',
            'recurrencia' => 'required|in:diaria,semanal,mensual,trimestral,anual',
            'items.*.nombre' => 'required|string|max:255',
            'items.*.descripcion' => 'nullable|string',
            'items.*.obligatorio' => 'nullable|boolean',
            'rules.*.canal' => 'required|in:email,whatsapp,sistema',
            'rules.*.offset' => 'required|integer|min:-30|max:30',
            'rules.*.mensaje' => 'required|string|max:500',
        ], [
            'rules.*.offset.min' => 'El número de días de aviso no puede ser menor a -30.',
            'rules.*.offset.max' => 'El número de días de aviso no puede ser mayor a 30.',
            'rules.*.mensaje.required' => 'Cada regla debe tener un mensaje.',
        ]);

        $plantilla = Template::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'recurrencia' => $validated['recurrencia'],
            'activo' => $request->has('activo'),
        ]);

        // Guardar ítems
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $plantilla->items()->create([
                    'nombre' => $itemData['nombre'],
                    'descripcion' => $itemData['descripcion'] ?? null,
                    'orden' => $itemData['orden'] ?? 1,
                    'obligatorio' => isset($itemData['obligatorio']),
                ]);
            }
        }

        // Guardar reglas
        if ($request->has('rules')) {
            foreach ($request->rules as $ruleData) {
                $plantilla->rules()->create([
                    'canal' => $ruleData['canal'],
                    'offset' => $ruleData['offset'],
                    'mensaje' => $ruleData['mensaje'],
                ]);
            }
        }

        return redirect()->route('plantillas.index')->with('success', 'Plantilla creada con éxito ✅');
    }

    // 👁 Ver detalle
    public function show(Template $plantilla)
    {
        $plantilla->load(['items', 'rules']);
        return view('plantillas::show', compact('plantilla'));
    }

    // ✏ Editar
    public function edit(Template $plantilla)
    {
        $plantilla->load(['items', 'rules']);
        return view('plantillas::edit', compact('plantilla'));
    }

    // 🔄 Actualizar
    public function update(Request $request, Template $plantilla)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:templates,nombre,' . $plantilla->id,
            'descripcion' => 'nullable|string',
            'recurrencia' => 'required|in:diaria,semanal,mensual,trimestral,anual',
            'items.*.nombre' => 'required|string|max:255',
            'items.*.descripcion' => 'nullable|string',
            'items.*.obligatorio' => 'nullable|boolean',
            'rules.*.canal' => 'required|in:email,whatsapp,sistema',
            'rules.*.offset' => 'required|integer|min:-30|max:30',
            'rules.*.mensaje' => 'required|string|max:500',
        ], [
            'rules.*.offset.min' => 'El número de días de aviso no puede ser menor a -30.',
            'rules.*.offset.max' => 'El número de días de aviso no puede ser mayor a 30.',
            'rules.*.mensaje.required' => 'Cada regla debe tener un mensaje.',
        ]);

        $plantilla->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'recurrencia' => $validated['recurrencia'],
            'activo' => $request->has('activo'),
        ]);

        // 📋 Actualizar ítems → borrar y recrear
        $plantilla->items()->delete();
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $plantilla->items()->create([
                    'nombre' => $itemData['nombre'],
                    'descripcion' => $itemData['descripcion'] ?? null,
                    'orden' => $itemData['orden'] ?? 1,
                    'obligatorio' => isset($itemData['obligatorio']),
                ]);
            }
        }

        // 🔔 Actualizar reglas → borrar y recrear
        $plantilla->rules()->delete();
        if ($request->has('rules')) {
            foreach ($request->rules as $ruleData) {
                $plantilla->rules()->create([
                    'canal' => $ruleData['canal'],
                    'offset' => $ruleData['offset'],
                    'mensaje' => $ruleData['mensaje'],
                ]);
            }
        }

        return redirect()->route('plantillas.index')->with('success', 'Plantilla actualizada correctamente ✏️');
    }

    // 🗑 Eliminar
    public function destroy(Template $plantilla)
    {
        $plantilla->delete();
        return redirect()->route('plantillas.index')->with('success', 'Plantilla eliminada 🚮');
    }
}
