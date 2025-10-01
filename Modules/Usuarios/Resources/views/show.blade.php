<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Detalle de Usuario</h1>

            <div class="space-y-2">
                <p><strong>ID:</strong> {{ $usuario->id }}</p>
                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
                <p><strong>Activo:</strong> {{ $usuario->activo ? 'Sí' : 'No' }}</p>
                <p><strong>Organización:</strong> {{ $usuario->organizacion->nombre ?? 'Sin organización' }}</p>
                <p><strong>Creado en:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado en:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex space-x-4 mt-6">
                <a href="{{ route('usuarios.index') }}" 
                   class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">Volver</a>
                <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                   class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Editar</a>
                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" 
                      onsubmit="return confirm('¿Seguro de eliminar este usuario?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-black px-4 py-2 rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
