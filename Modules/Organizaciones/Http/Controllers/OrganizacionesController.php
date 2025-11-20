<?php

namespace Modules\Organizaciones\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Organizaciones\Models\Organizacion;
use Modules\Plantillas\Models\Template;
use Modules\Organizaciones\Http\Requests\OrganizacionRequest;

class OrganizacionesController extends Controller
{
    public function __construct()
    {
        // login requerido excepto index y show
        $this->middleware(['auth'])->except(['index', 'show']);

        // Solo Admin puede gestionar
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login');
            }

            if (!$user->hasRole('Admin')) {
                abort(403, 'Acceso denegado: solo los administradores pueden realizar esta acción.');
            }

            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Listado con búsqueda, filtros y paginación
     */
    public function index()
    {
        $query = Organizacion::query();

        // BUSCADOR
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhere('nit', 'like', "%$search%")
                  ->orWhere('representante', 'like', "%$search%");
            });
        }

        // FILTRO CIUDAD
        if (request()->filled('ciudad')) {
            $query->where('ciudad', 'like', '%' . request('ciudad') . '%');
        }

        // FILTRO ESTADO
        if (request()->has('activo') && request('activo') !== '') {
            $query->where('activo', request('activo'));
        }

        // PAGINACIÓN
        $organizaciones = $query->orderBy('nombre')->paginate(10)->appends(request()->query());

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
    public function store(OrganizacionRequest $request)
    {
        $data = $request->validated();

        // Prefijar https:// si no lo trae
        if (!empty($data['pagina_web']) &&
            !str_starts_with($data['pagina_web'], 'http://') &&
            !str_starts_with($data['pagina_web'], 'https://')) {
            $data['pagina_web'] = 'https://' . $data['pagina_web'];
        }

        // Guardar logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DB::transaction(function () use ($data, $request) {
            $organizacion = Organizacion::create($data);
            $organizacion->templates()->sync($request->input('templates', []));
        });

        return redirect()->route('organizaciones.index')
            ->with('success', 'Organización creada correctamente.');
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
     * Formulario edición
     */
    public function edit(Organizacion $organizacion)
    {
        $templates = Template::orderBy('nombre')->get();
        return view('organizaciones::edit', compact('organizacion', 'templates'));
    }

    /**
     * Actualizar organización existente
     */
    public function update(OrganizacionRequest $request, Organizacion $organizacion)
    {
        $data = $request->validated();

        // Prefijar https:// si no lo trae
        if (!empty($data['pagina_web']) &&
            !str_starts_with($data['pagina_web'], 'http://') &&
            !str_starts_with($data['pagina_web'], 'https://')) {
            $data['pagina_web'] = 'https://' . $data['pagina_web'];
        }

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

        return redirect()->route('organizaciones.index')
            ->with('success', 'Organización actualizada correctamente.');
    }

    /**
     * Eliminar
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

        return redirect()->route('organizaciones.index')
            ->with('success', 'Organización eliminada correctamente.');
    }
}
