<nav class="bg-[#510817] text-white shadow-lg border-b border-[#6D1426]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center h-16">

            {{-- Logo / Título --}}
            <div class="flex items-center gap-2 pr-6 md:pr-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M6 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 8h2m-2 4h2m-2 4h2m3-8h2m-2 4h2m-2 4h2"/>
                </svg>
                <span class="text-sm font-bold tracking-wider text-white">SISTEMA DE BIENES NACIONALES</span>
            </div>

            @auth
            {{-- Enlaces de Navegación --}}
            <div class="hidden md:flex flex-1 justify-center items-center space-x-2 text-sm font-medium">

                <a href="{{ url('/') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->is('/')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-7 9 7v8a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v7a2 2 0 01-2 2H3z"/>
                    </svg>
                    <span>Inicio</span>
                </a>

                <a href="{{ route('organismos.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('organismos.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 21V7l4-3 4 3v14M4 21h16M10 11h4m-4 4h4"/>
                    </svg>
                    <span>Organismos</span>
                </a>

                <a href="{{ route('unidades.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('unidades.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm10 0h8v8h-8v-8z"/>
                    </svg>
                    <span>Unidades</span>
                </a>

                <a href="{{ route('dependencias.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('dependencias.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h5l2 2h11v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                    </svg>
                    <span>Dependencias</span>
                </a>

                <a href="{{ route('bienes.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('bienes.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.5 8.5L12 4 3.5 8.5 12 13l8.5-4.5zM3.5 15.5L12 20l8.5-4.5M3.5 8.5V15.5M20.5 8.5V15.5"/>
                    </svg>
                    <span>Bienes</span>
                </a>

                <a href="{{ route('movimientos.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('movimientos.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 8h-7m0 0l3-3m-3 3l3 3M7 16h7m0 0l-3 3m3-3l-3-3"/>
                    </svg>
                    <span>Movimientos</span>
                </a>

                <a href="{{ route('usuarios.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('usuarios.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2m14-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Usuarios</span>
                </a>

                <a href="{{ route('reportes.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-slate-800 hover:text-indigo-300"
                   @class(['bg-slate-800 text-indigo-400 shadow-inner' => request()->routeIs('reportes.*')])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h6l4 4v6a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm3 5v4m3-2v2m3-4v4"/>
                    </svg>
                    <span>Reportes</span>
                </a>
            </div>
            @endauth

            {{-- Sección de Usuario / Acciones --}}
            <div class="flex items-center gap-4 whitespace-nowrap ml-auto">
                @auth
                    <div class="hidden sm:flex items-center gap-2 text-sm font-medium border-r border-slate-700 pr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 14a4 4 0 10-8 0v2a4 4 0 004 4h0a4 4 0 004-4v-2zM12 7a3 3 0 110-6 3 3 0 010 6z"/>
                        </svg>
                        <span class="text-slate-300 max-w-[200px] truncate">
                            {{ auth()->user()->nombre_completo ?? auth()->user()->nombre }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 9a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2h-6z"/>
                            </svg>
                            <span class="hidden sm:inline">Cerrar sesión</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        Iniciar sesión
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>
