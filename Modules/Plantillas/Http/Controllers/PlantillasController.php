<?php

namespace Modules\Plantillas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('plantillas::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plantillas::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('plantillas::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('plantillas::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
