<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">
                {{ config('app.name', 'AlertaPro') }}
            </h1>

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           required autofocus
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Contraseña</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Ingresar
                    </button>
                </div>
            </form>

            <p class="text-sm text-center mt-6 text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
