<?php

namespace Modules\Plantillas\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Plantillas\Models\Template;
use Modules\Plantillas\Models\TemplateItem;
use Modules\Plantillas\Models\NotificationRule;
use Modules\Plantillas\Http\Requests\StoreTemplateRequest;
use Modules\Plantillas\Http\Requests\UpdateTemplateRequest;
use Modules\Organizaciones\Models\Organizacion;
use Illuminate\Support\Facades\DB;

class PlantillasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['index','show']);
    }

    public function index(Request $request)
    {
        $query = Template::withCount('items');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('nombre', 'like', "%{$q}%")
                         ->orWhere('descripcion', 'like', "%{$q}%");
            });
        }

        $plantillas = $query->orderBy('created_at','desc')->paginate(10);
        $plantillas->appends($request->all());

        return view('plantillas::index', compact('plantillas'));
    }

    public function create()
    {
        $organizaciones = Organizacion::select('id','nombre')->orderBy('nombre')->get();
        return view('plantillas::create', compact('organizaciones'));
    }

    public function store(StoreTemplateRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, &$template) {

            // Crear plantilla
            $template = Template::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'recurrencia' => $data['recurrencia'] ?? 'Nunca',
                'activa' => $data['activa'] ?? true,
            ]);

            // Crear items
            foreach ($request->input('items', []) as $item) {
                $template->items()->create([
                    'titulo' => $item['titulo'],
                    'detalle' => $item['detalle'] ?? null,
                    'orden' => $item['orden'] ?? 0,
                    'requerido' => !empty($item['requerido']),
                    'tipo' => $item['tipo'] ?? 'texto',
                ]);
            }

            // Crear reglas
            foreach ($request->input('rules', []) as $rule) {
                $template->notificationRules()->create([
                    'canal' => $rule['canal'],
                    'offset_days' => $rule['offset_days'] ?? 0,
                    'momento' => $rule['momento'] ?? 'antes',
                    'hora' => $rule['hora'] ?? null,
                    'mensaje' => $rule['mensaje'] ?? null,
                ]);
            }

            // Organizaciones pivot
            $template->organizaciones()->sync($request->input('organizaciones', []));
        });

        return redirect()->route('plantillas.index')->with('success', 'Plantilla creada correctamente.');
    }

    public function show(Template $plantilla)
    {
        $plantilla->load(['items','notificationRules','organizaciones']);
        return view('plantillas::show', ['p' => $plantilla]);
    }

    public function edit(Template $plantilla)
    {
        $plantilla->load(['items','notificationRules','organizaciones']);
        $organizaciones = Organizacion::select('id','nombre')->orderBy('nombre')->get();

        return view('plantillas::edit', compact('plantilla','organizaciones'));
    }

    public function update(UpdateTemplateRequest $request, Template $plantilla)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $plantilla) {

            // Actualizar plantilla
            $plantilla->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'recurrencia' => $data['recurrencia'] ?? 'Nunca',
                'activa' => $data['activa'] ?? true,
            ]);

            // Items: reemplazar todos
            $plantilla->items()->delete();
            foreach ($request->input('items', []) as $item) {
                $plantilla->items()->create([
                    'titulo' => $item['titulo'],
                    'detalle' => $item['detalle'] ?? null,
                    'orden' => $item['orden'] ?? 0,
                    'requerido' => !empty($item['requerido']),
                    'tipo' => $item['tipo'] ?? 'texto',
                ]);
            }

            // Rules: reemplazar todas
            $plantilla->notificationRules()->delete();
            foreach ($request->input('rules', []) as $rule) {
                $plantilla->notificationRules()->create([
                    'canal' => $rule['canal'],
                    'offset_days' => $rule['offset_days'] ?? 0,
                    'momento' => $rule['momento'] ?? 'antes',
                    'hora' => $rule['hora'] ?? null,
                    'mensaje' => $rule['mensaje'] ?? null,
                ]);
            }

            // Organizaciones pivot
            $plantilla->organizaciones()->sync($request->input('organizaciones', []));
        });

        return redirect()->route('plantillas.index')->with('success', 'Plantilla actualizada correctamente.');
    }

    public function destroy(Template $plantilla)
    {
        $plantilla->delete();
        return redirect()->route('plantillas.index')->with('success', 'Plantilla eliminada correctamente.');
    }
}
