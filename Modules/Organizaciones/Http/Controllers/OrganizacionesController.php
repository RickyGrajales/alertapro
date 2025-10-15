<?php

namespace Modules\Organizaciones\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Organizaciones\Models\Organizacion;
use Modules\Plantillas\Models\Template;

class OrganizacionesController extends Controller
{
    public function __construct()
    {
        // Requiere login para todo excepto listar y mostrar
        $this->middleware(['auth'])->except(['index', 'show']);

        // Restricción de rol solo para acciones de gestión
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            // Solo Admin puede crear, editar o eliminar
            if ($user->rol !== 'Admin') {
                abort(403, 'Acceso denegado: solo los administradores pueden realizar esta acción.');
            }

            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /** 
     * Listado de organizaciones
     */
    public function index()
    {
        $organizaciones = Organizacion::orderBy('nombre')->get();
        return view('organizaciones::index', compact('organizaciones'));
    }

    /** 
     * Formulario de creación
     */
    public function create()
    {
        $templates = Template::orderBy('nombre')->get();
        return view('organizaciones::create', compact('templates'));
    }

    /** 
     * Guardar nueva organización
     */
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
            'pagina_web' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'templates' => 'nullable|array',
            'templates.*' => 'integer|exists:templates,id',
        ]);

        $data = $request->except('templates');

        // Prefijar https:// si la URL no tiene esquema
        if (!empty($data['pagina_web'])) {
            $pagina = $data['pagina_web'];
            if (!str_starts_with($pagina, 'http://') && !str_starts_with($pagina, 'https://')) {
                $data['pagina_web'] = 'https://' . $pagina;
            }
        }

        // Guardar logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DB::transaction(function () use ($data, $request) {
            $organizacion = Organizacion::create($data);
            $organizacion->templates()->sync($request->input('templates', []));
        });

        return redirect()
            ->route('organizaciones.index')
            ->with('success', '✅ Organización creada correctamente.');
    }

    /** 
     * Mostrar una organización
     */
    public function show(Organizacion $organizacion)
    {
        $organizacion->load('templates');
        return view('organizaciones::show', compact('organizacion'));
    }

    /** 
     * Formulario de edición
     */
    public function edit(Organizacion $organizacion)
    {
        $templates = Template::orderBy('nombre')->get();
        return view('organizaciones::edit', compact('organizacion', 'templates'));
    }

    /** 
     * Actualizar organización existente
     */
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
            'pagina_web' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'templates' => 'nullable|array',
            'templates.*' => 'integer|exists:templates,id',
        ]);

        $data = $request->except('templates');

        // Prefijar https:// si la URL no tiene esquema
        if (!empty($data['pagina_web'])) {
            $pagina = $data['pagina_web'];
            if (!str_starts_with($pagina, 'http://') && !str_starts_with($pagina, 'https://')) {
                $data['pagina_web'] = 'https://' . $pagina;
            }
        }

        // Actualizar logo
        if ($request->hasFile('logo')) {
            if ($organizacion->logo) {
                Storage::disk('public')->delete($organizacion->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DB::transaction(function () use ($organizacion, $data, $request) {
            $organizacion->update($data);
            $organizacion->templates()->sync($request->input('templates', []));
        });

        return redirect()
            ->route('organizaciones.index')
            ->with('success', '✅ Organización actualizada correctamente.');
    }

    /** 
     * Eliminar organización
     */
    public function destroy(Organizacion $organizacion)
    {
        DB::transaction(function () use ($organizacion) {
            $organizacion->templates()->detach();

            if ($organizacion->logo) {
                Storage::disk('public')->delete($organizacion->logo);
            }

            $organizacion->delete();
        });

        return redirect()
            ->route('organizaciones.index')
            ->with('success', '🗑️ Organización eliminada correctamente.');
    }
}
