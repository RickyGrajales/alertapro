<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Organizaciones</h1>
                @role('Admin|Supervisor')
                <a href="{{ route('organizaciones.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Crear</a>
                @endrole
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Tipo</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Ciudad</th>
                            <th class="px-4 py-2 text-left">Activo</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizaciones as $org)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $org->id }}</td>
                            <td class="px-4 py-2">{{ $org->nombre }}</td>
                            <td class="px-4 py-2">{{ $org->tipo }}</td>
                            <td class="px-4 py-2">{{ $org->email }}</td>
                            <td class="px-4 py-2">{{ $org->ciudad }}</td>
                            <td class="px-4 py-2">{{ $org->activo ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('organizaciones.show', $org->id) }}" class="text-blue-600 hover:underline">Ver</a>
                                @role('Admin|Supervisor')
                                <a href="{{ route('organizaciones.edit', $org->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('organizaciones.destroy', $org->id) }}" method="POST" onsubmit="return confirm('Eliminar?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                                @endrole
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="7" class="py-4 text-center text-gray-500">No hay organizaciones</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
