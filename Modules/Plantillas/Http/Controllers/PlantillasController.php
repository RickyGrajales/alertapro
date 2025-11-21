<?php

namespace Modules\Plantillas\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Plantillas\Models\Template;
use Modules\Plantillas\Models\TemplateItem;
use Modules\Plantillas\Models\NotificationRule;
use Modules\Organizaciones\Models\Organizacion;
use Modules\Plantillas\Http\Requests\StoreTemplateRequest;
use Modules\Plantillas\Http\Requests\UpdateTemplateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantillasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('role:Admin')->except(['index','show']);
    }

    public function index(Request $request)
    {
        $query = Template::withCount('items');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('nombre', 'like', "%{$q}%")
                  ->orWhere('descripcion', 'like', "%{$q}%");
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
        DB::beginTransaction();
        try {
            $data = $request->only(['nombre','descripcion','recurrencia']);
            $data['activa'] = $request->has('activa') ? (bool)$request->activa : true;

            $template = Template::create($data);

            // Items
            if ($request->filled('items')) {
                foreach ($request->items as $index => $item) {
                    $template->items()->create([
                        'titulo' => $item['titulo'],
                        'detalle' => $item['detalle'] ?? null,
                        'orden' => $item['orden'] ?? $index,
                        'requerido' => $item['requerido'] ?? false,
                        'tipo' => $item['tipo'] ?? 'texto',
                    ]);
                }
            }

            // Regla notificación
            if ($request->filled('rules')) {
                foreach ($request->rules as $r) {
                    $template->rules()->create([
                        'canal' => $r['canal'],
                        'offset_days' => $r['offset_days'] ?? 0,
                        'momento' => $r['momento'] ?? 'antes',
                        'hora' => $r['hora'] ?? null,
                    ]);
                }
            }

            // Organizaciones pivot
            if ($request->filled('organizaciones')) {
                $template->organizaciones()->sync($request->organizaciones);
            }

            DB::commit();
            return redirect()->route('plantillas.index')->with('success','Plantilla creada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error crear plantilla: '.$e->getMessage());
            return back()->withInput()->withErrors(['error'=>'Error al crear plantilla: '.$e->getMessage()]);
        }
    }

    public function show(Template $template)
    {
        $template->load(['items','rules','organizaciones']);
        return view('plantillas::show', compact('template'));
    }

    public function edit(Template $template)
    {
        $template->load(['items','rules','organizaciones']);
        $organizaciones = Organizacion::select('id','nombre')->orderBy('nombre')->get();
        return view('plantillas::edit', compact('template','organizaciones'));
    }

    public function update(UpdateTemplateRequest $request, Template $template)
    {
        DB::beginTransaction();
        try {
            $template->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'recurrencia' => $request->recurrencia,
                'activa' => $request->has('activa') ? (bool)$request->activa : false,
            ]);

            // Items: actualizar/crear/eliminar
            $keep = [];
            if ($request->filled('items')) {
                foreach ($request->items as $i => $item) {
                    if (!empty($item['id'])) {
                        $it = TemplateItem::find($item['id']);
                        if ($it) {
                            $it->update([
                                'titulo' => $item['titulo'],
                                'detalle' => $item['detalle'] ?? null,
                                'orden' => $item['orden'] ?? $i,
                                'requerido' => $item['requerido'] ?? false,
                                'tipo' => $item['tipo'] ?? 'texto',
                            ]);
                            $keep[] = $it->id;
                        }
                    } else {
                        $new = $template->items()->create([
                            'titulo' => $item['titulo'],
                            'detalle' => $item['detalle'] ?? null,
                            'orden' => $item['orden'] ?? $i,
                            'requerido' => $item['requerido'] ?? false,
                            'tipo' => $item['tipo'] ?? 'texto',
                        ]);
                        $keep[] = $new->id;
                    }
                }
            }

            // Borrar items no enviados
            $template->items()->whereNotIn('id', $keep)->delete();

            // Rules: sync simple strategy: borrar los que no vienen
            $keepRules = [];
            if ($request->filled('rules')) {
                foreach ($request->rules as $r) {
                    if (!empty($r['id'])) {
                        $rule = NotificationRule::find($r['id']);
                        if ($rule) {
                            $rule->update([
                                'canal' => $r['canal'],
                                'offset_days' => $r['offset_days'] ?? 0,
                                'momento' => $r['momento'] ?? 'antes',
                                'hora' => $r['hora'] ?? null,
                            ]);
                            $keepRules[] = $rule->id;
                        }
                    } else {
                        $newR = $template->rules()->create([
                            'canal' => $r['canal'],
                            'offset_days' => $r['offset_days'] ?? 0,
                            'momento' => $r['momento'] ?? 'antes',
                            'hora' => $r['hora'] ?? null,
                        ]);
                        $keepRules[] = $newR->id;
                    }
                }
            }
            $template->rules()->whereNotIn('id', $keepRules)->delete();

            // Pivot organizaciones
            $template->organizaciones()->sync($request->input('organizaciones', []));

            DB::commit();
            return redirect()->route('plantillas.index')->with('success','Plantilla actualizada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error actualizar plantilla: '.$e->getMessage());
            return back()->withInput()->withErrors(['error'=>'Error al actualizar plantilla: '.$e->getMessage()]);
        }
    }

    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->route('plantillas.index')->with('success','Plantilla eliminada.');
    }
}
