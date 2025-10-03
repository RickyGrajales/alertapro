@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">📑 Plantillas</h2>
        <a href="{{ route('plantillas.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-blue-700">
            ➕ Nueva Plantilla
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($plantillas->count())
    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Nombre</th>
                <th class="p-3">Recurrencia</th>
                <th class="p-3">Activo</th>
                <th class="p-3">Ítems</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plantillas as $p)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $p->nombre }}</td>
                <td class="p-3 capitalize">{{ $p->recurrencia }}</td>
                <td class="p-3">{{ $p->activo ? '✔️ Sí' : '❌ No' }}</td>
                <td class="p-3">{{ $p->items->count() }}</td>
                <td class="p-3 flex gap-3">
                    <a href="{{ route('plantillas.show',$p) }}" class="text-gray-600 hover:text-black">👁️ Ver</a>
                    <a href="{{ route('plantillas.edit',$p) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                    <form method="POST" action="{{ route('plantillas.destroy',$p) }}" 
                          onsubmit="return confirm('¿Eliminar esta plantilla?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $plantillas->links() }}</div>
    @else
        <p class="text-gray-600">No hay plantillas creadas todavía.</p>
    @endif
</div>
@endsection
