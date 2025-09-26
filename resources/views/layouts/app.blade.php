<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-600">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">
                    Cerrar sesión
                </button>
            </form>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-6 bg-gray-50 text-gray-800">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
