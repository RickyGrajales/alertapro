<x-app-layout>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">

            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                📄 Ver Plantilla: {{ $plantilla->nombre }}
            </h1>

            {{-- Datos Básicos --}}
            <div class="mb-6">
                <p><strong>Descripción:</strong> {{ $plantilla->descripcion }}</p>
                <p><strong>Recurrencia:</strong> {{ $plantilla->recurrencia }}</p>
                <p><strong>Activa:</strong> {{ $plantilla->activa ? 'Sí' : 'No' }}</p>
            </div>

            {{-- Organizaciones --}}
            <div class="mb-6">
                <h2 class="font-semibold text-lg">Organizaciones asociadas</h2>
                <ul class="list-disc ml-4">
                    @forelse($plantilla->organizaciones as $org)
                        <li>{{ $org->nombre }}</li>
                    @empty
                        <li class="text-gray-500">Sin organizaciones asociadas</li>
                    @endforelse
                </ul>
            </div>

            {{-- Ítems --}}
            <div class="mb-6">
                <h2 class="font-semibold text-lg">Ítems</h2>
                @forelse($plantilla->items as $item)
                    <div class="border rounded p-3 mb-2">
                        <strong>{{ $item->titulo }}</strong>
                        <p>{{ $item->detalle }}</p>
                        <small>Tipo: {{ $item->tipo }} | Requerido: {{ $item->requerido ? 'Sí' : 'No' }}</small>
                    </div>
                @empty
                    <p class="text-gray-500">No hay ítems</p>
                @endforelse
            </div>

            {{-- Reglas --}}
            <div class="mb-6">
                <h2 class="font-semibold text-lg">Reglas de notificación</h2>

                @forelse($plantilla->notificationRules as $rule)
                    <div class="border rounded p-3 mb-2 bg-green-50">
                        <p><strong>Canal:</strong> {{ $rule->canal }}</p>
                        <p><strong>Días:</strong> {{ $rule->offset_days }} ({{ $rule->momento }})</p>
                        <p><strong>Hora:</strong> {{ $rule->hora }}</p>
                        <p><strong>Mensaje:</strong> {{ $rule->mensaje }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No hay reglas registradas</p>
                @endforelse
            </div>

            {{-- BOTONES --}}
            <div class="mt-4 flex justify-between">
                <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Volver</a>
                <a href="{{ route('plantillas.edit', $plantilla->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Editar</a>
            </div>

        </div>
    </div>

</x-app-layout>
