@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📚 Plantillas</h2>
        @role('Admin')
            <a href="{{ route('plantillas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">➕ Crear Plantilla</a>
        @endrole
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..."
               class="border px-3 py-2 rounded w-1/3 inline-block">
        <button class="bg-gray-700 text-white px-3 py-2 rounded">Buscar</button>
    </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Ítems</th>
                    <th class="p-3 text-left">Recurrencia</th>
                    <th class="p-3 text-left">Activa</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantillas as $p)
                <tr class="border-t">
                    <td class="p-3">{{ $p->id }}</td>
                    <td class="p-3 font-semibold">{{ $p->nombre }}</td>
                    <td class="p-3">{{ $p->items_count }}</td>
                    <td class="p-3">{{ $p->recurrencia }}</td>
                    <td class="p-3">{{ $p->activa ? 'Sí' : 'No' }}</td>
                    <td class="p-3">
                        <a href="{{ route('plantillas.show', $p->id) }}" class="text-blue-600">Ver</a>
                        @role('Admin')
                            <a href="{{ route('plantillas.edit', $p->id) }}" class="ml-2 text-yellow-600">Editar</a>
                            <form action="{{ route('plantillas.destroy', $p->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Eliminar plantilla?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $plantillas->links() }}</div>
</div>
@endsection
