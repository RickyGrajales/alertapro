@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Panel de Control - AlertaPro</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-blue-600 text-white p-5 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Usuarios</h3>
            <p class="text-3xl font-bold">{{ \Modules\Usuarios\Models\Usuario::count() }}</p>
        </div>

        <div class="bg-indigo-600 text-white p-5 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Organizaciones</h3>
            <p class="text-3xl font-bold">{{ \Modules\Organizaciones\Models\Organizacion::count() }}</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Eventos</h3>
            <p class="text-3xl font-bold">{{ \Modules\Eventos\Models\Event::count() }}</p>
        </div>

        <div class="bg-yellow-600 text-white p-5 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Reprogramaciones</h3>
            <p class="text-3xl font-bold">{{ \Modules\Reprogramaciones\Models\Reprogramacion::count() }}</p>
        </div>
    </div>

    <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🕒 Últimas actividades</h2>
        <p class="text-gray-600">Aquí se mostrarán las últimas reprogramaciones y actualizaciones registradas.</p>
    </div>
</div>
@endsection
