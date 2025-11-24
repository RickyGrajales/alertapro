{{-- Modules/Plantillas/Resources/views/show.blade.php --}}
<x-app-layout>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-2xl font-bold mb-2">{{ $p->nombre }}</h1>
    <p class="text-sm text-gray-600 mb-4">{{ $p->descripcion }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- ITEMS --}}
        <div class="border p-4 rounded">
            <h2 class="font-semibold">Ítems ({{ $p->items->count() }})</h2>
            <ul class="mt-2">
                @foreach($p->items as $it)
                    <li class="py-1 border-b">
                        {{ $it->titulo }}
                        @if($it->requerido)
                            <strong class="text-red-500">(*)</strong>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- REGLAS --}}
        <div class="border p-4 rounded">
            <h2 class="font-semibold">Reglas de Notificación</h2>
            <ul class="mt-2">
                @foreach($p->notificationRules as $r)
                    <li class="py-1 border-b">
                        <strong>{{ $r->canal }}</strong>
                        – {{ $r->momento }} {{ $r->offset_days }} días
                        @if($r->hora)
                            a las {{ $r->hora }}
                        @endif
                        <br>
                        @if($r->mensaje)
                            <small class="text-gray-600">“{{ $r->mensaje }}”</small>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('plantillas.index') }}" class="px-3 py-1 bg-gray-200 rounded">Volver</a>
    </div>
</div>
</x-app-layout>
