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
        $this->middleware(['auth']);
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

        return view('plantillas::index', compact('plantillas'));
    }

    public function create()
    {
        $organizaciones = Organizacion::select('id','nombre')->orderBy('nombre')->get();
        return view('plantillas::create', compact('organizaciones'));
    }

    public function store(StoreTemplateRequest $request)
    {
        $template = DB::transaction(function () use ($request) {

            $template = Template::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'recurrencia' => $request->recurrencia,
                'activa' => $request->activa,
            ]);

            // ITEMS
            foreach ($request->input('items', []) as $item) {
                $template->items()->create([
                    'titulo' => $item['titulo'],
                    'detalle' => $item['detalle'] ?? null,
                    'orden' => $item['orden'] ?? 0,
                    'requerido' => $item['requerido'] ?? 0,
                    'tipo' => $item['tipo'] ?? 'texto',
                ]);
            }

            // RULES
            foreach ($request->input('rules', []) as $rule) {
                $template->notificationRules()->create([
                    'canal' => $rule['canal'],
                    'offset_days' => $rule['offset_days'] ?? 0,
                    'momento' => $rule['momento'],
                    'hora' => $rule['hora'],
                    'mensaje' => $rule['mensaje'],
                ]);
            }

            // ORGANIZACIONES
            $template->organizaciones()->sync($request->organizaciones ?? []);

            return $template;
        });

        return redirect()->route('plantillas.index')
            ->with('success', 'Plantilla creada correctamente.');
    }


    public function edit(Template $plantilla)
    {
        $plantilla->load(['items','notificationRules','organizaciones']);
        $organizaciones = Organizacion::select('id','nombre')->orderBy('nombre')->get();

        return view('plantillas::edit', compact('plantilla','organizaciones'));
    }

    
        public function show(Template $plantilla)
    {
        $plantilla->load(['items', 'notificationRules', 'organizaciones']);

        return view('plantillas::show', compact('plantilla'));
    }


    public function update(UpdateTemplateRequest $request, Template $plantilla)
    {
        DB::transaction(function () use ($request, $plantilla) {

            $plantilla->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'recurrencia' => $request->recurrencia,
                'activa' => $request->activa,
            ]);

            // REEMPLAZAR ITEMS
            $plantilla->items()->delete();
            foreach ($request->input('items', []) as $item) {
                $plantilla->items()->create([
                    'titulo' => $item['titulo'],
                    'detalle' => $item['detalle'] ?? null,
                    'orden' => $item['orden'] ?? 0,
                    'requerido' => $item['requerido'] ?? 0,
                    'tipo' => $item['tipo'] ?? 'texto',
                ]);
            }

            // REEMPLAZAR RULES
            $plantilla->notificationRules()->delete();
            foreach ($request->input('rules', []) as $rule) {
                $plantilla->notificationRules()->create([
                    'canal' => $rule['canal'],
                    'offset_days' => $rule['offset_days'] ?? 0,
                    'momento' => $rule['momento'],
                    'hora' => $rule['hora'],
                    'mensaje' => $rule['mensaje'],
                ]);
            }

            // ORGS
            $plantilla->organizaciones()->sync($request->organizaciones ?? []);
        });

        return redirect()->route('plantillas.index')->with('success', 'Plantilla actualizada correctamente.');
    }

    public function destroy(Template $plantilla)
    {
        $plantilla->delete();
        return redirect()->route('plantillas.index')->with('success', 'Plantilla eliminada correctamente.');
    }
}
