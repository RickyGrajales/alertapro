<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logoAlertaPro1.png') }}" 
             alt="Logo Fundación Asodisvalle" 
             style="width: 150px; height: 150px; margin: 0 auto; border-radius: 12px; object-fit: cover;">
    </div>

    <!-- Encabezado -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold mb-1" style="color: #2563eb;">ALERTAPRO</h1>
        <p class="text-gray-600 text-sm">Sistema de Gestión de Notificaciones</p>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        
        <!-- Campo Usuario -->
        <div>
            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Usuario</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Ingrese su usuario"
                   required 
                   autofocus
                   style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;"
                   class="focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
        </div>

        <!-- Campo Contraseña -->
        <div>
            <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   placeholder="Ingrese su contraseña"
                   required
                   style="width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;"
                   class="focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
        </div>

        <!-- Botón Ingresar -->
        <div class="pt-2">
            <button type="submit" 
                    style="width: 100%; background-color: #2563eb; color: white; padding: 12px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; transition: background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Ingresar
            </button>
        </div>
    </form>

    <!-- Link recuperar contraseña -->
    @if (Route::has('password.request'))
        <div class="mt-6 text-center">
            <a href="{{ route('password.request') }}" style="color: #2563eb; text-decoration: none; font-size: 14px;">
                ¿Olvidó su contraseña?
            </a>
        </div>
    @endif
</x-guest-layout>