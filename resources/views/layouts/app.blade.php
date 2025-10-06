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
        <aside class="w-64 bg-blue-800 text-gray-100 flex flex-col shadow-lg">
            <!-- Logo / Nombre -->
            <div class="p-6 text-2xl font-bold border-b border-blue-700 text-center">
                {{ config('app.name', 'AlertaPro') }}
            </div>

            <!-- Navegación -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-chart-line mr-2"></i> Dashboard
                </a>

                <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-users mr-2"></i> Usuarios
                </a>

                <a href="{{ route('organizaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-building mr-2"></i> Organizaciones
                </a>

                @role('Admin')
                <a href="{{ route('plantillas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-file-alt mr-2"></i> Plantillas
                </a>

                <a href="{{ route('eventos.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-calendar-alt mr-2"></i> Eventos
                </a>
                @endrole

                <a href="{{ route('reprogramaciones.index') }}" 
   class="block px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
   🔁 Reprogramaciones
</a>

            </nav>

            <!-- Cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-700">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
            </form>
        </aside>

        <!-- Contenedor principal -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="flex justify-end items-center bg-white shadow px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ auth()->user()->nombre }}</p>
                        <p class="text-sm text-gray-500">
                            Rol: {{ auth()->user()->rol ?? auth()->user()->getRoleNames()->first() }}
                        </p>
                    </div>
                    <i class="fas fa-user-circle text-3xl text-blue-600"></i>
                </div>
            </header>

            <!-- Contenido dinámico -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
