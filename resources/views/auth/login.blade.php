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

        /* Animación de entrada */
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
            <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="cedula" class="text-xs font-bold text-gray-500 uppercase tracking-widest ml-1">Identificación</label>
                    <div class="relative">
                        <input type="text" name="cedula" id="cedula"
                            class="input-focus w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 text-gray-900 placeholder:text-gray-400 outline-none font-medium"
                            placeholder="V-00.000.000" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Contraseña</label>
                        <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded text-gray-400 uppercase">Opcional</span>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="input-focus w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 text-gray-900 placeholder:text-gray-400 outline-none font-medium"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#800020] focus:ring-[#800020]">
                        <span class="ml-2 text-sm font-semibold text-gray-600 group-hover:text-gray-800 transition-colors">Recordar sesión</span>
                    </label>
                </div>

                <button type="submit" id="btnSubmit" class="btn-gradient w-full py-4 rounded-2xl text-white font-bold text-sm tracking-widest uppercase flex items-center justify-center gap-3">
                    <span id="btnText">Entrar al Sistema</span>
                    <svg id="btnIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
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
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al inicio
            </a>
            <div class="pt-6 border-t border-gray-200">
                <p class="text-[10px] text-gray-400 font-bold tracking-[3px] uppercase">Ministerio del Poder Popular</p>
            </div>
        </div>
    </div>

    <script>
        // Máscara inteligente para Cédula
        IMask(document.getElementById('cedula'), {
            mask: [
                { mask: 'V-00.000.000' },
                { mask: 'E-00.000.000' }
            ]
        });

        // Simulación de carga (feedback visual)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            const btnSpinner = document.getElementById('btnSpinner');

            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerText = 'Accediendo...';
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>
