<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | Sistema de Control de Bienes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/imask"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(128, 0, 32, 0.05) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(128, 0, 32, 0.03) 0px, transparent 50%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-focus:focus {
            border-color: #800020;
            box-shadow: 0 0 0 4px rgba(128, 0, 32, 0.1);
            transform: translateY(-1px);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #800020 0%, #4a0012 100%);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            filter: brightness(1.1);
            box-shadow: 0 10px 15px -3px rgba(128, 0, 32, 0.3);
            transform: translateY(-2px);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md fade-in">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white shadow-xl mb-6 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                <span class="text-4xl font-black text-[#800020] tracking-tighter">B</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gestión de Bienes</h1>
            <p class="text-gray-500 mt-2 font-medium">Panel Administrativo</p>
        </div>

        <div class="glass-effect rounded-[2.5rem] shadow-2xl p-10 border border-white/50">
            {{-- Error General de Sesión --}}
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 rounded-r shadow-sm flex items-start">
                    <span class="mr-3">⚠️</span>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                @csrf

                {{-- CÉDULA --}}
                <div class="space-y-2">
                    <label for="cedula" class="text-xs font-bold text-gray-500 uppercase tracking-widest ml-1">Cédula de Identidad</label>
                    <div class="relative">
                        <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}"
                            class="input-focus w-full px-5 py-4 rounded-2xl bg-gray-50 border @error('cedula') border-red-500 @else border-gray-200 @enderror text-gray-900 placeholder:text-gray-400 outline-none font-medium"
                            placeholder="V-00.000.000" required autofocus>
                    </div>
                    @error('cedula')
                        <div class="mt-2 flex items-center text-red-600 text-[10px] font-black uppercase tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message == 'No se encontró persona con esa cédula en el sistema externo' ? 'Cédula no registrada.' : $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- CONTRASEÑA --}}
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Contraseña</label>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="input-focus w-full px-5 py-4 rounded-2xl bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror text-gray-900 placeholder:text-gray-400 outline-none font-medium"
                            placeholder="••••••••" required>

                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#800020] transition-colors">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <div id="password-error" class="mt-2 hidden items-center text-red-600 text-[10px] font-black uppercase tracking-wider">
                        <span>La contraseña debe tener al menos 8 caracteres</span>
                    </div>
                </div>

                {{-- RECORDAR SESIÓN --}}
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-[#800020] focus:ring-[#800020]">
                        <span class="ml-2 text-sm font-semibold text-gray-600 group-hover:text-gray-800 transition-colors">Recordar sesión</span>
                    </label>
                </div>

                {{-- BOTÓN SUBMIT --}}
                <button type="submit" id="btnSubmit" class="btn-gradient w-full py-4 rounded-2xl text-white font-bold text-sm tracking-widest uppercase flex items-center justify-center gap-3">
                    <span id="btnText">Entrar al Sistema</span>
                    <div id="btnSpinner" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </button>
            </form>
        </div>

        <div class="mt-10 text-center space-y-6">
            <a href="/" class="text-sm font-bold text-gray-400 hover:text-[#800020] transition-colors inline-flex items-center gap-2">
                <span>←</span> Volver al inicio
            </a>
            <div class="pt-6 border-t border-gray-200">
                <p class="text-[10px] text-gray-400 font-bold tracking-[3px] uppercase">Ministerio del Poder Popular</p>
            </div>
        </div>
    </div>

    <script>
        // 1. MÁSCARA DE CÉDULA
        const cedulaInput = document.getElementById('cedula');
        const mask = IMask(cedulaInput, {
            mask: [{ mask: 'V-00.000.000' }, { mask: 'E-00.000.000' }],
            lazy: false
        });

        // 2. VER/OCULTAR CONTRASEÑA
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.style.color = isPassword ? '#800020' : '#9CA3AF';
        });

        // 3. VALIDACIÓN Y CARGA
        const loginForm = document.getElementById('loginForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const passwordError = document.getElementById('password-error');

        loginForm.addEventListener('submit', (e) => {
            if (passwordInput.value.length < 8) {
                e.preventDefault();
                passwordError.classList.remove('hidden');
                passwordError.classList.add('flex');
                passwordInput.focus();
                return false;
            }

            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.innerText = 'VERIFICANDO...';
            btnSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>
