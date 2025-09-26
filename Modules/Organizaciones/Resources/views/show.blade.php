<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Detalle de Organización</h1>

            <div class="space-y-2">
                <p><strong>ID:</strong> {{ $organizacion->id }}</p>
                <p><strong>Nombre:</strong> {{ $organizacion->nombre }}</p>
                <p><strong>NIT:</strong> {{ $organizacion->nit }}</p>
                <p><strong>Tipo:</strong> {{ $organizacion->tipo }}</p>
                <p><strong>Email:</strong> {{ $organizacion->email }}</p>
                <p><strong>Teléfono:</strong> {{ $organizacion->telefono }}</p>
                <p><strong>Ciudad:</strong> {{ $organizacion->ciudad }}</p>
                <p><strong>Departamento:</strong> {{ $organizacion->departamento }}</p>
                <p><strong>Activo:</strong> {{ $organizacion->activo ? 'Sí' : 'No' }}</p>
                <p><strong>Creado:</strong> {{ $organizacion->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex space-x-4 mt-6">
                <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">Volver</a>
                <a href="{{ route('organizaciones.edit', $organizacion->id) }}" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Editar</a>
                <form action="{{ route('organizaciones.destroy', $organizacion->id) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar esta organización?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
