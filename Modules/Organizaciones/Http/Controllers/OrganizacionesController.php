<?php

namespace Modules\Organizaciones\Http\Controllers;

use Modules\Organizaciones\Models\Organizacion;
use Illuminate\Routing\Controller;
use Modules\Organizaciones\Http\Requests\OrganizacionRequest;
use Illuminate\Http\Request;

class OrganizacionesController extends Controller
{
   public function __construct()
    {
    // Solo Admin puede acceder a todo lo que no sea index y show
        $this->middleware('role:Admin')->except(['index', 'show']);
    }


    public function index()
    {
        $organizaciones = Organizacion::orderBy('nombre')->get();
        return view('organizaciones::index', compact('organizaciones'));
    }

    public function create()
    {
        return view('organizaciones::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:20|unique:organizaciones,nit',
            'email' => 'nullable|email|unique:organizaciones,email',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Organizacion::create($data);

        return redirect()->route('organizaciones.index')->with('success', 'Organización creada correctamente');
    }

    public function show(Organizacion $organizacion)
    {
        return view('organizaciones::show', compact('organizacion'));
    }

    public function edit(Organizacion $organizacion)
    {
        return view('organizaciones::edit', compact('organizacion'));
    }

    public function update(OrganizacionRequest $request, Organizacion $organizacion)
    {
        $organizacion->update($request->validated());
        return redirect()->route('organizaciones.index')->with('success', 'Organización actualizada correctamente');
    }

    public function destroy(Organizacion $organizacion)
    {
        $organizacion->delete();
        return redirect()->route('organizaciones.index')->with('success', 'Organización eliminada correctamente');
    }
}
