<aside id="sidebar"
       class="bg-blue-900 text-white w-64 fixed md:static md:translate-x-0 transform -translate-x-full md:transform-none transition-transform duration-300 ease-in-out h-full z-50">

    <div class="p-4 text-2xl font-bold text-center border-b border-blue-800 bg-blue-950">
        {{ config('app.name', 'AlertaPro') }}
    </div>

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
            <i class="fas a-calendar-alt mr-2"></i> Eventos
        </a>
        <a href="{{ route('notificaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
            <i class="fas fa-bell mr-2"></i> Notificaciones
        </a>
        @endrole

        <a href="{{ route('reprogramaciones.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-700 transition">
            <i class="fas fa-rotate-right mr-2"></i> Reprogramaciones
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-800 bg-blue-950">
        @csrf
        <button type="submit" class="w-full bg-red-600 py-2 rounded hover:bg-red-700 transition">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
        </button>
    </form>
</aside>

<div id="overlay"
     class="fixed inset-0 bg-black opacity-50 hidden md:hidden z-40"
     onclick="toggleSidebar()"></div>
