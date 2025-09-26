<?php

namespace Modules\Organizaciones\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Organizaciones\Models\Organizacion;

class OrganizacionesController extends Controller
{
    public function index()
    {
        $organizaciones = Organizacion::all();
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
            'email' => 'required|email|unique:organizaciones,email',
        ]);

        Organizacion::create($request->all());

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

    public function update(Request $request, Organizacion $organizacion)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:20|unique:organizaciones,nit,' . $organizacion->id,
            'email' => 'required|email|unique:organizaciones,email,' . $organizacion->id,
        ]);

        $organizacion->update($request->all());

        return redirect()->route('organizaciones.index')->with('success', 'Organización actualizada correctamente');
    }

    public function destroy(Organizacion $organizacion)
    {
        $organizacion->delete();
        return redirect()->route('organizaciones.index')->with('success', 'Organización eliminada correctamente');
    }
}
