<?php

namespace Modules\Organizaciones\Http\Controllers;

use Modules\Organizaciones\Models\Organizacion;
use Illuminate\Routing\Controller;
use Modules\Organizaciones\Http\Requests\OrganizacionRequest;
use Illuminate\Http\Request;

class OrganizacionesController extends Controller
{
    public function index()
    {
        $organizaciones = Organizacion::orderBy('nombre')->get();
        return view('organizaciones::index', compact('organizaciones'));
    }

    public function create()
    {
        return view('organizaciones::create');
    }

    public function store(OrganizacionRequest $request)
    {
        Organizacion::create($request->validated());
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
