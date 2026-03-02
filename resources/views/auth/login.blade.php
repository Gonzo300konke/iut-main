<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Inventario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/imask"></script>
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
                {{-- Error General de Sesión --}}
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 rounded-r shadow-sm flex items-start">
                        <span class="mr-3">⚠️</span>
                        <p class="text-sm font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                    @csrf

                    {{-- CÉDULA --}}
                    <div>
                        <label for="cedula" class="block text-sm font-bold text-gray-700 mb-2">Cédula de Identidad</label>
                        <div class="relative">
                            <input type="text" name="cedula" id="cedula"
                                   value="{{ old('cedula') }}"
                                   class="w-full pl-4 pr-4 py-3.5 border-2 @error('cedula') border-red-500 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent transition-all duration-200"
                                   placeholder="V-00.000.000" required autofocus>
                        </div>
                        @error('cedula')
                            <div class="mt-2 flex items-center text-red-600 text-xs font-black uppercase tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- CONTRASEÑA --}}
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   value="{{ old('password') }}" 
                                   class="w-full pl-4 pr-12 py-3.5 border-2 @error('password') border-red-500 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent transition-all duration-200"
                                   placeholder="Ingresa tu contraseña" required>

                            <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-900 transition-colors">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        
                        {{-- MENSAJE DINÁMICO DE VALIDACIÓN JS --}}
                        <div id="password-error" class="mt-2 hidden items-center text-red-600 text-xs font-black uppercase tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>La contraseña debe tener al menos 8 caracteres</span>
                        </div>

                        @error('password')
                            <div class="mt-2 flex items-center text-red-600 text-xs font-black uppercase tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                               class="w-5 h-5 text-red-800 border-gray-300 rounded focus:ring-red-700 cursor-pointer">
                        <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Mantener sesión iniciada</label>
                    </div>

                    <button type="submit" id="btnSubmit"
                            class="w-full text-white font-black py-4 rounded-xl shadow-lg hover:brightness-110 active:scale-[0.98] transition-all duration-200 transform flex items-center justify-center gap-3"
                            style="background-color: #800020 !important;">
                        <span id="btnText">INGRESAR AL PORTAL</span>
                        <div id="btnSpinner" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="/" class="w-full flex items-center justify-center gap-2 text-gray-500 hover:text-gray-800 font-bold py-2 transition-colors">
                        <span>←</span> Regresar al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. MÁSCARA DE CÉDULA
        const cedulaInput = document.getElementById('cedula');
        const maskOptions = {
            mask: [{ mask: 'V-00.000.000' }, { mask: 'E-00.000.000' }],
            lazy: false 
        };
        const mask = IMask(cedulaInput, maskOptions);

        if (cedulaInput.value) {
            mask.updateValue();
        }

        // 2. VER CONTRASEÑA
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.style.color = isPassword ? '#800020' : '#9CA3AF';
        });

        // 3. VALIDACIÓN EN TIEMPO REAL (MIN 8 CARACTERES)
        const passwordError = document.getElementById('password-error');

        passwordInput.addEventListener('input', () => {
            if (passwordInput.value.length > 0 && passwordInput.value.length < 8) {
                passwordError.classList.remove('hidden');
                passwordError.classList.add('flex');
            } else {
                passwordError.classList.add('hidden');
                passwordError.classList.remove('flex');
            }
        });

        // 4. ESTADO DE CARGA Y VALIDACIÓN FINAL AL ENVIAR
        const loginForm = document.getElementById('loginForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        loginForm.addEventListener('submit', (e) => {
            // Validar longitud antes de enviar
            if (passwordInput.value.length < 8) {
                e.preventDefault(); // Detener envío
                passwordError.classList.remove('hidden');
                passwordError.classList.add('flex');
                passwordInput.focus();
                return false;
            }

            // Si es válido, mostrar spinner y desactivar botón
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.innerText = 'VERIFICANDO...';
            btnSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>