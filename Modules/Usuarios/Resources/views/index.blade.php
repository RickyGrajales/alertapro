<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Encabezado -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Gestión de Usuarios</h1>
                @role('Admin')
                <a href="{{ route('usuarios.create') }}" 
                   class="bg-blue-600 text-black px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                    ➕ Crear Usuario
                </a>
                @endrole
            </div>

            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Barra de búsqueda (solo para Admin) -->
            @role('Admin')
            <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4 flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar por nombre, email, rol u organización..."
                       class="w-full border-gray-300 rounded p-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    🔍 Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('usuarios.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        ❌ Limpiar
                    </a>
                @endif
            </form>
            @endrole

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th>
                             <th class="px-4 py-2">Telefono</th>
                            <th class="px-4 py-2">Rol</th>
                            <th class="px-4 py-2">Activo</th>
                            <th class="px-4 py-2">Organización</th>
                            @role('Admin')
                            <th class="px-4 py-2">Acciones</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $usuario->id }}</td>
                                <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                                <td class="px-4 py-2">{{ $usuario->email }}</td>
                                <td class="px-4 py-2">{{ $usuario->Telefono }}</td>
                                <td class="px-4 py-2">{{ $usuario->rol }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-white {{ $usuario->activo ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $usuario->activo ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $usuario->organizacion?->nombre ?? 'N/A' }}</td>

                                @role('Admin')
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('usuarios.show', $usuario->id) }}" 
                                       class="text-blue-600 hover:underline">Ver</a>
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                                       class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" 
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('¿Eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                                @endrole
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
