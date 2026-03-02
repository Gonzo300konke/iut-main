<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina de Bienes Nacionales | Universidad</title>
    <script src="https://cdn.tailwindcss.com"></script> @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    {{-- Navbar --}}
    @include('layouts.head')

    <section class="relative bg-gradient-to-br from-[#640B21] via-[#800f2f] to-[#4a0819] text-white py-24 px-6 overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10">
            <svg width="400" height="400" fill="none" viewBox="0 0 400 400">
                <circle cx="200" cy="200" r="180" stroke="white" stroke-width="40" />
            </svg>
        </div>

        <div class="max-w-5xl mx-auto text-center relative z-10">
            <span class="uppercase tracking-widest text-sm font-semibold text-red-200 mb-4 block">Gestión Patrimonial</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                Oficina de Bienes Nacionales
            </h1>
            <div class="w-24 h-1 bg-red-400 mx-auto mb-8"></div>
            <p class="max-w-3xl mx-auto text-lg md:text-xl text-red-50/90 leading-relaxed font-light">
                Custodiamos y administramos el patrimonio institucional con eficiencia, asegurando que cada recurso fortalezca el futuro de nuestra universidad.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto py-20 px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10">

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Misión</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Administrar y gestionar los bienes muebles e inmuebles con un enfoque de eficiencia y transparencia, garantizando el cumplimiento del marco legal desde el registro hasta la disposición final.
                </p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Visión</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Ser la unidad líder en gestión patrimonial, reconocida por la modernización tecnológica y la trazabilidad digital total de cada activo institucional.
                </p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Funciones Clave</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Actualización constante del inventario, registro de altas por adquisiciones, transferencias internas y procesos de desincorporación técnica de bienes.
                </p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Gestión y Control</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Inspecciones físicas periódicas, generación de reportes estadísticos para auditorías y coordinación de mantenimiento para asegurar la vida útil de los activos.
                </p>
            </div>

        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12 px-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <h3 class="text-white font-bold text-lg">Universidad X</h3>
                <p class="text-sm">Oficina de Bienes Nacionales © {{ date('Y') }}</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition-colors">Intranet</a>
                <a href="#" class="hover:text-white transition-colors">Transparencia</a>
                <a href="#" class="hover:text-white transition-colors">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>




