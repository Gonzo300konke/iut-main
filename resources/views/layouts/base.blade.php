<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sistema de Bienes')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- Navbar --}}
    @include('layouts.head')

    {{-- Contenido Principal --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Script de filtros automáticos (Debounce optimizado) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filtrosForm');
            if (!form) return;

            const filtros = form.querySelectorAll('input, select');
            filtros.forEach(filtro => {
                // Para selects y checkboxes
                filtro.addEventListener('change', () => form.submit());

                // Para búsqueda de texto (evita recargar en cada letra)
                if (filtro.type === 'text') {
                    let timeout;
                    filtro.addEventListener('input', () => {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => form.submit(), 500);
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
