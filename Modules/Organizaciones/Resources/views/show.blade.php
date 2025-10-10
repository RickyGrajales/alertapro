@extends('layouts.app')

@section('title', 'Detalle de Organización')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        🏢 Detalle de la organización
    </h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Información general --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-500">Nombre</p>
            <p class="text-lg font-semibold text-gray-900">{{ $organizacion->nombre }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">NIT</p>
            <p class="text-lg font-semibold text-gray-900">{{ $organizacion->nit }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Correo electrónico</p>
            <p class="text-lg font-semibold text-gray-900">{{ $organizacion->email ?? '—' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Fecha de creación</p>
            <p class="text-lg font-semibold text-gray-900">
                {{ $organizacion->created_at ? $organizacion->created_at->format('d/m/Y') : '—' }}
            </p>
        </div>

        @if($organizacion->logo)
            <div class="col-span-2">
                <p class="text-sm text-gray-500 mb-2">Logo</p>
                <img src="{{ asset('storage/' . $organizacion->logo) }}" 
                     alt="Logo de {{ $organizacion->nombre }}"
                     class="h-32 object-contain border rounded-md shadow-sm">
            </div>
        @endif
    </div>

    {{-- Plantillas asociadas --}}
    <div class="border-t pt-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            📋 Plantillas asociadas
        </h2>

        @if($organizacion->templates->count() > 0)
            <div class="space-y-3">
                @foreach($organizacion->templates as $template)
                    <div class="p-4 border rounded-md hover:bg-gray-50 transition">
                        <p class="font-semibold text-blue-700">
                            {{ $template->nombre }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $template->descripcion ?? 'Sin descripción' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 italic">Esta organización aún no tiene plantillas asignadas.</p>
        @endif
    </div>

    {{-- Botones de acción --}}
    <div class="flex justify-end space-x-3 pt-6 mt-6 border-t">
        <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700 transition">
            ⬅️ Volver al listado
        </a>
        @role('Admin')
            <a href="{{ route('organizaciones.edit', $organizacion->id) }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                ✏️ Editar
            </a>
        @endrole
    </div>
</div>
@endsection
