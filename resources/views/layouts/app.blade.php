<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>{{ config('app.name', 'AlertaPro') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-blue-800 text-gray-100 flex flex-col shadow-lg">
            <div class="p-6 text-2xl font-bold border-b border-blue-600">
                {{ config('app.name', 'AlertaPro') }}
            </div>
          <nav class="flex-1 p-4 space-y-2">
    <a href="{{ route('dashboard') }}" 
       class="block px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
        📊 Dashboard
    </a>
    <a href="{{ route('usuarios.index') }}" 
       class="block px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
        👥 Usuarios
    </a>
    <a href="{{ route('organizaciones.index') }}" 
       class="block px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
        🏢 Organizaciones
    </a>

    @role('Admin')
    <a href="{{ route('plantillas.index') }}" 
       class="block px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
        📑 Plantillas
    </a>
    @endrole
</nav>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-600">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">
                    Cerrar sesión
                </button>
            </form>
        </aside>

        <!-- Contenedor principal -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="flex justify-end items-center bg-white shadow px-6 py-4">
                <div class="flex items-center space-x-4">
                    <span class="font-semibold text-gray-800">
                        👤 {{ auth()->user()->nombre }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Rol: {{ auth()->user()->rol ?? auth()->user()->getRoleNames()->first() }}
                    </span>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 p-6 bg-gray-50 text-gray-800">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
