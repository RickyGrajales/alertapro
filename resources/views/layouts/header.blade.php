<header class="flex justify-between items-center bg-white shadow px-4 py-3 md:px-6">

    <button class="text-2xl text-blue-700 md:hidden" onclick="toggleSidebar()" aria-label="Abrir menú">
        <i class="fas fa-bars"></i>
    </button>

    @php
        $notificaciones = auth()->user()->unreadNotifications ?? collect();
    @endphp

    <div class="relative">
        <button id="notifButton" class="relative text-2xl text-blue-700">
            <i class="fas fa-bell"></i>

            @if($notificaciones->count() > 0)
                <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-2">
                    {{ $notificaciones->count() }}
                </span>
            @endif
        </button>

        <div id="notifMenu"
             class="hidden absolute right-0 mt-2 w-80 bg-white border rounded shadow-lg z-50 max-h-96 overflow-y-auto">

            <div class="p-3 border-b font-bold text-gray-700">Notificaciones</div>

            @forelse($notificaciones as $n)
                <div class="p-3 border-b hover:bg-gray-50">
                    <p class="text-sm font-semibold">{{ $n->data['titulo'] ?? 'Nueva notificación' }}</p>
                    <p class="text-sm text-gray-600">{{ $n->data['mensaje'] ?? 'Sin detalles' }}</p>
                    <span class="text-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="p-3 text-sm text-gray-500">Sin notificaciones</div>
            @endforelse

            <div class="p-3 text-center">
                <a href="{{ route('notificaciones.leer-todas') }}"
                   class="text-blue-600 text-sm hover:underline">Marcar todas como leídas</a>
            </div>

        </div>
    </div>

    <div class="flex items-center space-x-3">
        <div class="text-right">
            <p class="font-semibold">{{ auth()->user()->nombre }}</p>
            <p class="text-sm text-gray-500">{{ auth()->user()->getRoleNames()->first() }}</p>
        </div>
        <i class="fas fa-user-circle text-3xl text-blue-700"></i>
    </div>

</header>
