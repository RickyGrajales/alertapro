<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Gestión de Organizaciones</h1>
                <a href="{{ route('organizaciones.create') }}" 
                   class="bg-blue-600 text-black px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                    ➕ Crear Organización
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">NIT</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Ciudad</th>
                            <th class="px-4 py-2">Activo</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizaciones as $org)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $org->id }}</td>
                                <td class="px-4 py-2">{{ $org->nombre }}</td>
                                <td class="px-4 py-2">{{ $org->nit }}</td>
                                <td class="px-4 py-2">{{ $org->tipo }}</td>
                                <td class="px-4 py-2">{{ $org->ciudad }}</td>
                                <td class="px-4 py-2">{{ $org->activo ? 'Sí' : 'No' }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('organizaciones.show', $org->id) }}" class="text-blue-600 hover:underline">Ver</a>
                                    <a href="{{ route('organizaciones.edit', $org->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('organizaciones.destroy', $org->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('¿Eliminar esta organización?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    No hay organizaciones registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
