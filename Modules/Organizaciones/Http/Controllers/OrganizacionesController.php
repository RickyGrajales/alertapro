<?php

namespace Modules\Organizaciones\Http\Controllers;

use Modules\Organizaciones\Models\Organizacion;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Plantillas\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrganizacionesController extends Controller
{
    public function __construct()
{
    // Middleware personalizado basado en el campo 'rol' del usuario autenticado
    $this->middleware(function ($request, $next) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->rol !== 'Admin') {
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    })->except(['index', 'show']);
}
  


    public function index()
    {
        $organizaciones = Organizacion::orderBy('nombre')->get();
        return view('organizaciones::index', compact('organizaciones'));
    }

    public function create()
    {
        $templates = Template::orderBy('nombre')->get();
        return view('organizaciones::create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:50|unique:organizaciones,nit',
            'tipo' => 'nullable|string|max:100',
            'representante' => 'nullable|string|max:150',
            'email' => 'nullable|email|unique:organizaciones,email',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'pagina_web' => 'nullable|url|max:200',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'templates' => 'nullable|array',
            'templates.*' => 'integer|exists:templates,id',
        ]);

        $data = $request->except('templates');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DB::transaction(function () use ($data, $request, &$organizacion) {
            $organizacion = Organizacion::create($data);
            $organizacion->templates()->sync($request->input('templates', []));
        });

        return redirect()->route('organizaciones.index')->with('success', 'Organización creada correctamente');
    }

    public function show(Organizacion $organizacion)
    {
        // El partial de show mostrará las plantillas
        $organizacion->load('templates');
        return view('organizaciones::show', compact('organizacion'));
    }

    public function edit(Organizacion $organizacion)
    {
        $templates = Template::orderBy('nombre')->get();
        return view('organizaciones::edit', compact('organizacion', 'templates'));
    }

    public function update(Request $request, Organizacion $organizacion)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:50|unique:organizaciones,nit,' . $organizacion->id,
            'tipo' => 'nullable|string|max:100',
            'representante' => 'nullable|string|max:150',
            'email' => 'nullable|email|unique:organizaciones,email,' . $organizacion->id,
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'pagina_web' => 'nullable|url|max:200',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'templates' => 'nullable|array',
            'templates.*' => 'integer|exists:templates,id',
        ]);

        $data = $request->except('templates');

        if ($request->hasFile('logo')) {
            // eliminar logo viejo si existe
            if ($organizacion->logo) {
                Storage::disk('public')->delete($organizacion->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DB::transaction(function () use ($organizacion, $data, $request) {
            $organizacion->update($data);
            $organizacion->templates()->sync($request->input('templates', []));
        });

        return redirect()->route('organizaciones.index')->with('success', 'Organización actualizada correctamente');
    }

    public function destroy(Organizacion $organizacion)
    {
        DB::transaction(function () use ($organizacion) {
            // desvincular plantillas y borrar logo
            $organizacion->templates()->detach();
            if ($organizacion->logo) {
                Storage::disk('public')->delete($organizacion->logo);
            }
            $organizacion->delete();
        });

        return redirect()->route('organizaciones.index')->with('success', 'Organización eliminada correctamente');
    }
}
