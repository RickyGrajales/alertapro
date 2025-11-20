<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">

            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                {{ $organizacion->nombre }}
            </h1>

            @if($organizacion->logo)
                <img src="{{ asset('storage/' . $organizacion->logo) }}" class="w-32 h-32 mb-4 rounded shadow">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><strong>NIT:</strong> {{ $organizacion->nit }}</p>
                <p><strong>Tipo:</strong> {{ $organizacion->tipo }}</p>
                <p><strong>Email:</strong> {{ $organizacion->email }}</p>
                <p><strong>Teléfono:</strong> {{ $organizacion->telefono }}</p>
                <p><strong>Ciudad:</strong> {{ $organizacion->ciudad }}</p>
                <p><strong>Departamento:</strong> {{ $organizacion->departamento }}</p>
                <p><strong>Estado:</strong> {{ $organizacion->activo ? 'Activa' : 'Inactiva' }}</p>

            </div>

            <h2 class="text-lg font-semibold mt-6 mb-2">Descripción</h2>
            <p class="text-gray-700">{{ $organizacion->descripcion }}</p>

            <h2 class="text-lg font-semibold mt-6 mb-2">Plantillas Asociadas</h2>
            @forelse($organizacion->templates as $tpl)
                <span class="px-2 py-1 bg-blue-100 rounded text-blue-600 mr-2">{{ $tpl->nombre }}</span>
            @empty
                <p class="text-gray-500">Sin plantillas</p>
            @endforelse

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('organizaciones.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Volver</a>

                @role('Admin')
                <a href="{{ route('organizaciones.edit', $organizacion->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">
                    Editar
                </a>
                @endrole
            </div>

        </div>
    </div>
</x-app-layout>
