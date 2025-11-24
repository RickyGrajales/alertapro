{{-- Modules/Plantillas/Resources/views/index.blade.php --}}
<x-app-layout>
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Plantillas</h1>

        @role('Admin')
            <a href="{{ route('plantillas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                ➕ Crear
            </a>
        @endrole
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Buscar..."
               class="border p-2 rounded w-1/2">

        <button class="px-3 py-1 bg-gray-200 rounded">Buscar</button>
    </form>

    <div class="bg-white shadow rounded">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Ítems</th>
                    <th class="p-3">Recurrencia</th>
                    <th class="p-3">Activa</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantillas as $p)
                <tr>
                    <td class="p-3">{{ $p->id }}</td>
                    <td class="p-3 font-semibold">{{ $p->nombre }}</td>
                    <td class="p-3">{{ $p->items_count }}</td>
                    <td class="p-3">{{ $p->recurrencia }}</td>
                    <td class="p-3">{{ $p->activa ? 'Sí' : 'No' }}</td>

                    <td class="p-3">
                        <a href="{{ route('plantillas.show', $p->id) }}" class="text-blue-600">Ver</a>

                        @role('Admin')
                            <a href="{{ route('plantillas.edit', $p->id) }}" class="ml-2 text-yellow-600">
                                Editar
                            </a>

                            <form action="{{ route('plantillas.destroy', $p->id) }}"
                                  method="POST"
                                  class="inline ml-2"
                                  onsubmit="return confirm('Eliminar plantilla?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $plantillas->links() }}
        </div>
    </div>
</div>
</x-app-layout>
