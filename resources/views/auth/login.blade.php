<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Inventario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 shadow-md"
                 style="background-color: #800020 !important;">
                <span class="text-2xl">🏢</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Sistema de Gestión de Bienes Nacionales</h1>
            <p class="text-gray-600 mt-2">Sistema de Gestión de Bienes</p>
        </div>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-6 text-center" style="background-color: #800020 !important;">
                <h2 class="text-xl font-bold text-white">Iniciar Sesión</h2>
            </div>

            <div class="px-6 py-8">
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 rounded">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="correo" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 transition"
                               placeholder="correo@ejemplo.com" required autofocus>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 transition"
                               placeholder="••••••••" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                        <a href="#" class="text-sm font-medium hover:underline" style="color: #800020;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full text-white font-bold py-3 rounded-lg shadow-md transition duration-200 mt-6"
                            style="background-color: #800020 !important;">
                        Ingresar
                    </button>
                </form>

                <div class="mt-4">
                    <a href="/" class="w-full flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg transition">
                        Volver al Inicio
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500">© 2024 Sistema de Inventario. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
