@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📅 Eventos</h2>
        <a href="{{ route('eventos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ➕ Nuevo Evento
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($eventos->count())
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Título</th>
                    <th class="p-3">Fecha límite</th>
                    <th class="p-3">Responsable</th>
                    <th class="p-3">Plantilla</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $i => $evento)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $i + $eventos->firstItem() }}</td>
                    <td class="p-3 font-semibold">{{ $evento->titulo }}</td>
                    <td class="p-3">{{ $evento->due_date?->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $evento->responsable->nombre ?? '-' }}</td>
                    <td class="p-3">{{ $evento->plantilla->nombre ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-sm rounded
                            @if($evento->estado == 'Completado') bg-green-100 text-green-700
                            @elseif($evento->estado == 'En Proceso') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $evento->estado }}
                        </span>
                    </td>
                    <td class="p-3 text-center flex gap-3 justify-center">
                        <a href="{{ route('eventos.show', $evento) }}" class="text-gray-600 hover:text-black">👁 Ver</a>
                        <a href="{{ route('eventos.edit', $evento) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                        <form method="POST" action="{{ route('eventos.destroy', $evento) }}" onsubmit="return confirm('¿Eliminar este evento?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">🗑 Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $eventos->links() }}</div>
    @else
        <p class="text-gray-600">No hay eventos registrados.</p>
    @endif
</div>
@endsection

