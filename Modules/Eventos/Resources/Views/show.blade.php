@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📋 Detalle del Evento</h2>
        <a href="{{ route('eventos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ⬅ Volver
        </a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-semibold text-gray-700">Título:</p>
                <p>{{ $evento->titulo }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Responsable:</p>
                <p>{{ $evento->responsable->nombre ?? '-' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Fecha límite:</p>
                <p>{{ $evento->due_date?->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Estado:</p>
                <span class="px-2 py-1 text-sm rounded
                    @if($evento->estado == 'Completado') bg-green-100 text-green-700
                    @elseif($evento->estado == 'En Proceso') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $evento->estado }}
                </span>
            </div>
        </div>

        @if($evento->descripcion)
            <div class="mt-6">
                <p class="font-semibold text-gray-700">Descripción:</p>
                <p class="text-gray-800">{{ $evento->descripcion }}</p>
            </div>
        @endif

        @if($evento->plantilla)
            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-3">Checklist generado ({{ $evento->plantilla->nombre }})</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-2 border border-gray-300">#</th>
                            <th class="p-2 border border-gray-300">Ítem</th>
                            <th class="p-2 border border-gray-300">Descripción</th>
                            <th class="p-2 border border-gray-300">Obligatorio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evento->plantilla->items as $i => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2">{{ $i + 1 }}</td>
                                <td class="border p-2">{{ $item->nombre }}</td>
                                <td class="border p-2">{{ $item->descripcion ?? '-' }}</td>
                                <td class="border p-2">{{ $item->obligatorio ? '✔ Sí' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

