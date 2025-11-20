<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-blue-700">{{ $organizacion->nombre }}</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ $organizacion->tipo }}</p>
                </div>

                <div class="text-right">
                    @role('Admin')
                        <a href="{{ route('organizaciones.edit', $organizacion->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Editar</a>
                    @endrole
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="md:col-span-1">
                    @if($organizacion->logo)
                        <img src="{{ asset('storage/' . $organizacion->logo) }}" alt="logo" class="w-full h-auto rounded">
                    @else
                        <div class="w-full h-40 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                            Sin logo
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <p><strong>NIT:</strong> {{ $organizacion->nit }}</p>
                    <p><strong>Representante:</strong> {{ $organizacion->representante }}</p>
                    <p><strong>Email:</strong> {{ $organizacion->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $organizacion->telefono }}</p>
                    <p><strong>Dirección:</strong> {{ $organizacion->direccion }}</p>
                    <p><strong>Ciudad / Departamento:</strong> {{ $organizacion->ciudad }} / {{ $organizacion->departamento }}</p>
                    <p><strong>Página web:</strong>
                        @if($organizacion->pagina_web)
                            <a href="{{ $organizacion->pagina_web }}" target="_blank" class="text-blue-600 hover:underline">{{ $organizacion->pagina_web }}</a>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </p>

                    <p class="mt-3"><strong>Descripción:</strong></p>
                    <p class="text-gray-700">{{ $organizacion->descripcion ?? '—' }}</p>

                    <div class="mt-4">
                        <strong>Plantillas asignadas:</strong>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @forelse($organizacion->templates as $t)
                                <span class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $t->nombre }}</span>
                            @empty
                                <span class="text-gray-400">No hay plantillas asignadas</span>
                            @endforelse
                        </div>
                    </div>

                    @if(method_exists($organizacion, 'usuarios'))
                        <div class="mt-4">
                            <strong>Usuarios vinculados:</strong>
                            <ul class="mt-2">
                                @foreach($organizacion->usuarios as $u)
                                    <li>{{ $u->nombre }} — {{ $u->email }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('organizaciones.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>
