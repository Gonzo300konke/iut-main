<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina de Bienes Nacionales | UPTOS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen font-sans">

    <header class="w-full bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-2 flex justify-center items-center">
            <img 
                src="https://www.uptos.edu.ve/wp-content/uploads/2026/02/cropped-cropped-WhatsApp-Image-2026-02-11-at-10.17.38-PM-1.jpeg" 
                class="w-full h-auto max-h-[60px] md:max-h-[80px] object-contain" 
                alt="UPTOS Clodosbaldo Russián"
                loading="lazy"
            >
        </div>
    </header>

    @include('layouts.head')

    <section class="relative bg-gradient-to-br from-[#640B21] via-[#800f2f] to-[#4a0819] text-white py-24 px-6 overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10">
            <svg width="400" height="400" fill="none" viewBox="0 0 400 400">
                <circle cx="200" cy="200" r="180" stroke="white" stroke-width="40" />
            </svg>
        </div>
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <span class="uppercase tracking-widest text-sm font-semibold text-red-200 mb-4 block">Gestión Patrimonial</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">Oficina de Bienes Nacionales</h1>
            <div class="w-24 h-1 bg-red-400 mx-auto mb-8"></div>
            <p class="max-w-3xl mx-auto text-lg md:text-xl text-red-50/90 leading-relaxed font-light">
                Custodiamos y administramos el patrimonio institucional con eficiencia, asegurando que cada recurso fortalezca el futuro de nuestra universidad.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto py-20 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Misión</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Administrar y gestionar los bienes muebles e inmuebles con un enfoque de eficiencia y transparencia, garantizando el cumplimiento del marco legal desde el registro hasta la disposición final.</p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Visión</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Ser la unidad líder en gestión patrimonial, reconocida por la modernización tecnológica y la trazabilidad digital total de cada activo institucional.</p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Funciones Clave</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Actualización constante del inventario, registro de altas por adquisiciones, transferencias internas y procesos de desincorporación técnica de bienes.</p>
            </div>

            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#640B21] transition-colors">
                    <svg class="w-8 h-8 text-[#640B21] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Gestión y Control</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Inspecciones físicas periódicas, generación de reportes estadísticos para auditorías y coordinación de mantenimiento para asegurar la vida útil de los activos.</p>
            </div>
        </div>
    </main>

    <section class="bg-gray-100 py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Modelado de Negocio</h2>
                <p class="text-gray-600">Flujo operativo de la Oficina de Bienes Nacionales</p>
                <div class="w-16 h-1 bg-[#640B21] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#640B21] text-center">
                    <span class="text-xs font-bold text-[#640B21] uppercase">Paso 1</span>
                    <h3 class="font-bold text-gray-800 mt-2">Recepción y Registro</h3>
                    <p class="text-sm text-gray-500 mt-2">Ingreso de nuevos activos al sistema institucional.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#640B21] text-center">
                    <span class="text-xs font-bold text-[#640B21] uppercase">Paso 2</span>
                    <h3 class="font-bold text-gray-800 mt-2">Asignación y Control</h3>
                    <p class="text-sm text-gray-500 mt-2">Vinculación de bienes a departamentos y responsables.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#640B21] text-center">
                    <span class="text-xs font-bold text-[#640B21] uppercase">Paso 3</span>
                    <h3 class="font-bold text-gray-800 mt-2">Auditoría Física</h3>
                    <p class="text-sm text-gray-500 mt-2">Verificación en sitio y actualización de estados.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#640B21] text-center">
                    <span class="text-xs font-bold text-[#640B21] uppercase">Paso 4</span>
                    <h3 class="font-bold text-gray-800 mt-2">Desincorporación</h3>
                    <p class="text-sm text-gray-500 mt-2">Egreso legal de bienes por obsolescencia o daño.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Modelado de Componentes</h2>
                <p class="text-gray-600">Arquitectura del sistema de gestión patrimonial</p>
                <div class="w-16 h-1 bg-[#640B21] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="border-2 border-dashed border-gray-200 p-8 rounded-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-50 rounded-lg text-[#640B21]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Capa de Usuario</h3>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Portal Administrativo</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Módulo de Reportes</li>

                    </ul>
                </div>

                <div class="bg-[#640B21] p-8 rounded-2xl text-white shadow-xl transform lg:-translate-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-white/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-xl font-bold">Capa de Negocio</h3>
                    </div>
                    <ul class="space-y-3 text-red-100">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-white rounded-full"></div> Validador de Activos</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-white rounded-full"></div> Motor de Depreciación</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-white rounded-full"></div> Gestor de Permisos</li>
                    </ul>
                </div>

                <div class="border-2 border-dashed border-gray-200 p-8 rounded-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-50 rounded-lg text-[#640B21]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V7M4 7c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2M4 7c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2m-2 5c0 1.1-.9 2-2 2h-8c-1.1 0-2-.9-2-2" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Capa de Datos</h3>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Base de Datos Central</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Repositorio Documental</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Backup en la Nube</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12 px-6">
        <div class="max-w-6xl mx-auto flex flex-col items-center text-center">
            <h3 class="text-white font-bold text-lg mb-3">
                Universidad Politécnica Territorial del Oeste de Sucre "Clodosbaldo Russián"
            </h3>
            <p class="text-sm md:text-base">
                Oficina de Bienes Nacionales © {{ date('Y') }}
            </p>
        </div>
    </footer>

</body>
</html>




