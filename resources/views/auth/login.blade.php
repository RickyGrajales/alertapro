<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | AlertaPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
        <!-- Logo -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">🔔 AlertaPro</h1>
            <p class="text-gray-600">Inicia sesión para continuar</p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-between items-center">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-blue-600 focus:ring-blue-500">
                    Recordarme
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Iniciar Sesión
            </button>
        </form>

        <!-- Registro -->
        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-600">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate</a>
            </p>
        @endif
    </div>
</body>
</html>
