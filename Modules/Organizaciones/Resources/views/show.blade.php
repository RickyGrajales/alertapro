<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">
                Detalles de la Organización
            </h1>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <strong class="text-gray-700">Nombre:</strong>
                    <p>{{ $organizacion->nombre }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">NIT:</strong>
                    <p>{{ $organizacion->nit }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Tipo:</strong>
                    <p>{{ $organizacion->tipo ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Representante:</strong>
                    <p>{{ $organizacion->representante ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Email:</strong>
                    <p>{{ $organizacion->email ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Teléfono:</strong>
                    <p>{{ $organizacion->telefono ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Dirección:</strong>
                    <p>{{ $organizacion->direccion ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Ciudad:</strong>
                    <p>{{ $organizacion->ciudad ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Departamento:</strong>
                    <p>{{ $organizacion->departamento ?? 'N/A' }}</p>
                </div>

                <div>
                    <strong class="text-gray-700">Página Web:</strong>
                    <p>
                        @if($organizacion->pagina_web)
                            <a href="{{ $organizacion->pagina_web }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $organizacion->pagina_web }}
                            </a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <div>
                    <strong class="text-gray-700">Estado:</strong>
                    <p>{{ $organizacion->activo ? 'Activo' : 'Inactivo' }}</p>
                </div>

                <div class="col-span-2">
                    <strong class="text-gray-700">Descripción:</strong>
                    <p>{{ $organizacion->descripcion ?? 'N/A' }}</p>
                </div>

                <div class="col-span-2">
                    <strong class="text-gray-700">Logo:</strong><br>
                    @if($organizacion->logo)
                        <img src="{{ asset('storage/' . $organizacion->logo) }}" alt="Logo" class="h-24 mt-2">
                    @else
                        <p>No hay logo</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
                    ⬅ Volver
                </a>
                <a href="{{ route('organizaciones.edit', $organizacion) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    ✏ Editar
                </a>
                <form action="{{ route('organizaciones.destroy', $organizacion) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta organización?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                        🗑 Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
