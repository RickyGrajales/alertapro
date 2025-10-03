@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">📄 Detalle de Plantilla</h2>
        <a href="{{ route('plantillas.index') }}" class="text-blue-600 hover:underline">⬅ Volver</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold mb-2">{{ $plantilla->nombre }}</h3>
        <p class="text-gray-600 mb-4">{{ $plantilla->descripcion }}</p>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <strong>Recurrencia:</strong> {{ ucfirst($plantilla->recurrencia) }}
            </div>
            <div>
                <strong>Estado:</strong> {{ $plantilla->activo ? '✔️ Activa' : '❌ Inactiva' }}
            </div>
        </div>

        <!-- Ítems -->
        <h4 class="font-semibold mb-2">📋 Ítems</h4>
        @if($plantilla->items->count())
            <ul class="list-disc ml-6 mb-6">
                @foreach($plantilla->items as $item)
                <li>
                    <span class="font-semibold">{{ $item->nombre }}</span> - {{ $item->descripcion }}
                    @if($item->obligatorio)
                        <span class="text-red-600 font-semibold ml-2">(Obligatorio)</span>
                    @endif
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mb-6">No hay ítems configurados.</p>
        @endif

        <!-- Reglas -->
        <h4 class="font-semibold mb-2">🔔 Reglas de Notificación</h4>
        @if($plantilla->rules->count())
            <ul class="list-disc ml-6">
                @foreach($plantilla->rules as $rule)
                <li>
                    Canal: <strong>{{ ucfirst($rule->canal) }}</strong> | 
                    Días de aviso: <strong>{{ $rule->offset }}</strong> | 
                    Mensaje: <em>{{ $rule->mensaje }}</em>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No hay reglas de notificación configuradas.</p>
        @endif
    </div>
</div>
@endsection
