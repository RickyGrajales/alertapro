<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AlertaPro') }}</title>

    <!-- Iconos y estilos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar -->
        <aside id="sidebar"
               class="bg-blue-900 text-white w-64 fixed md:static md:translate-x-0 transform -translate-x-full md:transform-none transition-transform duration-300 ease-in-out h-full z-50">
            
            <!-- Logo -->
            <div class="p-4 text-2xl font-bold text-center border-b border-blue-800 bg-blue-950">
                {{ config('app.name', 'AlertaPro') }}
            </div>

            <!-- Menú -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-chart-line mr-2"></i> Dashboard
                </a>
                <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-users mr-2"></i> Usuarios
                </a>
                <a href="{{ route('organizaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-building mr-2"></i> Organizaciones
                </a>

                @role('Admin')
                <a href="{{ route('plantillas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-file-alt mr-2"></i> Plantillas
                </a>
                <a href="{{ route('eventos.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-calendar-alt mr-2"></i> Eventos
                </a>
                <a href="{{ route('notificaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-bell mr-2"></i> Notificaciones
                </a>
                @endrole

                <a href="{{ route('reprogramaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-rotate-right mr-2"></i> Reprogramaciones
                </a>
            </nav>

            <!-- Cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-800 bg-blue-950">
                @csrf
                <button type="submit" class="w-full bg-red-600 py-2 rounded hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
            </form>
        </aside>

        <!-- Overlay (solo móvil) -->
        <div id="overlay"
             class="fixed inset-0 bg-black opacity-50 hidden md:hidden z-40"
             onclick="toggleSidebar()"></div>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col min-h-screen md:ml-64">

            <!-- Header -->
            <header class="flex justify-between items-center bg-white shadow px-4 py-3 md:px-6">
                <!-- Botón menú móvil -->
                <button class="text-2xl text-blue-700 md:hidden" onclick="toggleSidebar()" aria-label="Abrir menú">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Notificaciones -->
                @php
                    $notificaciones = auth()->user()->unreadNotifications ?? collect();
                @endphp
                <div class="relative">
                    <button id="notifButton" class="relative text-2xl text-blue-700" aria-label="Abrir notificaciones">
                        <i class="fas fa-bell"></i>
                        @if($notificaciones->count() > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-2">
                                {{ $notificaciones->count() }}
                            </span>
                        @endif
                    </button>

                    <div id="notifMenu" class="hidden absolute right-0 mt-2 w-80 bg-white border rounded shadow-lg z-50 max-h-96 overflow-y-auto">
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
                            <a href="{{ route('notificaciones.leer-todas') }}" class="text-blue-600 text-sm hover:underline">
                                Marcar todas como leídas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Usuario -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="font-semibold">{{ auth()->user()->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->getRoleNames()->first() }}</p>
                    </div>
                    <i class="fas fa-user-circle text-3xl text-blue-700"></i>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Abrir/Cerrar menú móvil
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Mostrar/Ocultar menú de notificaciones
        document.getElementById('notifButton')?.addEventListener('click', () => {
            document.getElementById('notifMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
