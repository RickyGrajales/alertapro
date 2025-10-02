<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Fundación Asodisvalle') }}</title>
    @vite('resources/css/app.css')
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb 0%, #14b8a6 100%);
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 40px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <!-- Card centrada -->
    <div class="login-card">
        {{ $slot }}
    </div>
</body>
</html>