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
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col shadow-xl fixed h-full">
            <!-- Logo -->
            <div class="p-6 text-2xl font-bold border-b border-blue-800 text-center bg-blue-950">
                {{ config('app.name', 'AlertaPro') }}
            </div>

            <!-- Menú lateral -->
            <nav class="flex-1 p-4 space-y-1">
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
                @endrole

                <a href="{{ route('reprogramaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-rotate-right mr-2"></i> Reprogramaciones
                </a>
            </nav>

            <!-- Cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-800 bg-blue-950">
                @csrf
                <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
            </form>
        </aside>

        <!-- Contenedor principal -->
        <div class="flex-1 flex flex-col ml-64 bg-gray-50 min-h-screen">

            <!-- Header superior -->
            <header class="flex justify-between items-center bg-white shadow px-6 py-4">
                <!-- Notificaciones -->
                @php
                    $notificaciones = auth()->user()->unreadNotifications ?? collect();
                @endphp

                <div class="relative">
                    <button id="notifButton" class="relative text-2xl text-blue-700 focus:outline-none">
                        🔔
                        @if($notificaciones->count() > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-2">
                                {{ $notificaciones->count() }}
                            </span>
                        @endif
                    </button>

                    <div id="notifMenu" class="hidden absolute right-0 mt-2 w-80 bg-white border rounded shadow-lg z-50">
                        <div class="p-3 border-b font-bold text-gray-700">Notificaciones</div>
                        @forelse($notificaciones as $n)
                            <div class="p-3 border-b hover:bg-gray-50">
                                <p class="text-sm font-semibold text-gray-800">{{ $n->data['titulo'] ?? 'Nueva notificación' }}</p>
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
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ auth()->user()->nombre }}</p>
                        <p class="text-sm text-gray-500">
                            Rol: {{ auth()->user()->rol ?? auth()->user()->getRoleNames()->first() }}
                        </p>
                    </div>
                    <i class="fas fa-user-circle text-3xl text-blue-700"></i>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script menú notificaciones -->
    <script>
        document.getElementById('notifButton').addEventListener('click', () => {
            document.getElementById('notifMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
