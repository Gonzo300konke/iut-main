<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Inventario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4 shadow-lg bg-white border-4"
                 style="border-color: #800020 !important;">
                <span class="text-3xl">🏢</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Sistema de Gestión de Bienes</h1>
            <p class="text-gray-500 mt-2 font-medium">Control e Inventario Nacional</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="px-6 py-6 text-center" style="background-color: #800020 !important;">
                <h2 class="text-xl font-bold text-white tracking-wide uppercase">Acceso al Sistema</h2>
            </div>

            <div class="px-8 py-10">
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 rounded-r shadow-sm flex items-start">
                        <span class="mr-3 mt-0.5">⚠️</span>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="cedula" class="block text-sm font-bold text-gray-700 mb-2">Cédula de Identidad</label>
                        <div class="relative">
                            <input type="text" name="cedula" id="cedula" 
                                   value="{{ old('cedula') }}"
                                   class="w-full pl-4 pr-4 py-3.5 border-2 @error('cedula') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent transition-all duration-200 bg-gray-50"
                                   placeholder="V-12.345.678" required autofocus>
                        </div>
                        @error('cedula')
                            <p class="mt-2 text-xs text-red-600 font-bold flex items-center">
                                <span class="mr-1">●</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-bold text-gray-700">Contraseña</label>
                            <a href="#" class="text-xs font-bold hover:underline" style="color: #800020;">
                                ¿Olvidó su clave?
                            </a>
                        </div>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3.5 border-2 @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent transition-all duration-200 bg-gray-50"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-xs text-red-600 font-bold flex items-center">
                                <span class="mr-1">●</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                               class="w-5 h-5 text-red-800 border-gray-300 rounded focus:ring-red-700 cursor-pointer">
                        <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Mantener sesión iniciada</label>
                    </div>

                    <button type="submit"
                            class="w-full text-white font-black py-4 rounded-xl shadow-lg hover:brightness-110 active:scale-[0.98] transition-all duration-200 transform"
                            style="background-color: #800020 !important;">
                        INGRESAR AL PORTAL
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="/" class="w-full flex items-center justify-center gap-2 text-gray-500 hover:text-gray-800 font-bold py-2 transition-colors">
                        <span>←</span> Regresar al Inicio
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-[2px] font-bold">
                    © 2026 Sistema de Gestión de Bienes Públicos
                </p>
            </div>
        </div>
    </div>
</body>
</html>