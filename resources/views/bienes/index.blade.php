@extends('layouts.base')

@section('title', 'Bienes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        <x-heroicon-o-cube class="w-8 h-8 text-blue-600" /> Bienes
    </h1>

    <div class="flex gap-3">
        {{-- Botón Galería - Cambiado a Green para asegurar compatibilidad --}}
        <a href="{{ route('bienes.galeria') }}"
           class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Galería</span>
        </a>

        {{-- Botón Nuevo Bien --}}
        <a href="{{ route('bienes.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Nuevo Bien</span>
        </a>

        {{-- Botón PDF --}}
        <a href="{{ route('bienes.reporte', request()->query()) }}"
           class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <span>PDF</span>
        </a>

          {{-- Botón Gráficas --}}
          <a href="{{ route('graficas', request()->query()) }}"
              title="Ver gráficas basadas en los filtros actuales"
              class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18M6 10h10M6 6h.01M6 14h.01M6 18h.01" />
            </svg>
            <span>Gráficas</span>
        </a>
    </div>
</div>

{{-- Mensajes de éxito --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
        {{ session('success') }}
    </div>
@endif
{{-- Panel de Filtros Estilo Dependencias --}}
<div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4">
    <form action="{{ route('bienes.index') }}" method="GET" class="space-y-4" id="filtrosForm">

        {{-- Primera fila de filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Búsqueda Rápida --}}
            <div class="flex flex-col">
                <label for="search" class="text-sm font-medium text-gray-700 mb-1">Búsqueda rápida</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       maxlength="40"
                       placeholder="Código o descripción..."
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
                <p id="error-msg" class="text-red-500 text-xs mt-1 hidden font-semibold">
                    ⚠️ Solo se permiten letras, números y espacios.
                </p>
            </div>

            {{-- Tipo de Bien (Ajustado: Electrónicos incluidos, Inmuebles eliminados) --}}
            <div class="flex flex-col">
                <label for="tipo_bien" class="text-sm font-medium text-gray-700 mb-1">Tipo de Bien</label>
                <select name="tipo_bien" id="tipo_bien"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto bg-white">
                    <option value="">Todos los tipos</option>
                    @foreach($tiposBien as $valor => $label)
                        <option value="{{ $valor }}" @selected(request('tipo_bien') == $valor)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por Organismo --}}
            <div class="flex flex-col">
                <label for="organismo_id" class="text-sm font-medium text-gray-700 mb-1">Organismo</label>
                <select name="organismo_id" id="organismo_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto bg-white">
                    <option value="">Todos los Organismos</option>
                    @foreach($organismos as $organismo)
                        <option value="{{ $organismo->id }}" @selected(request('organismo_id') == $organismo->id)>
                            {{ $organismo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por Unidad Administradora --}}
            <div class="flex flex-col">
                <label for="unidad_id" class="text-sm font-medium text-gray-700 mb-1">Unidad Administradora</label>
                <select name="unidad_id" id="unidad_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto bg-white">
                    <option value="">Todas las unidades</option>
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->id }}" @selected(request('unidad_id') == $unidad->id)>
                            {{ $unidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Segunda fila de filtros (Fechas y Dependencias) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label for="fecha_desde" class="text-sm font-medium text-gray-700 mb-1">Fecha registro desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
            </div>

            <div class="flex flex-col">
                <label for="fecha_hasta" class="text-sm font-medium text-gray-700 mb-1">Fecha registro hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
            </div>

            <div class="flex flex-col">
                <label for="dependencias" class="text-sm font-medium text-gray-700 mb-1">Dependencia (Múltiple)</label>
                <select name="dependencias[]" id="dependencias" multiple
                        class="border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto bg-white text-sm">
                    @foreach($dependencias as $dependencia)
                        <option value="{{ $dependencia->id }}" @selected(collect(request('dependencias'))->contains($dependencia->id))>
                            {{ $dependencia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Filtro para Bienes sin Dependencias --}}
        <div class="flex flex-col">
            <label for="sin_dependencia" class="text-sm font-medium text-gray-700 mb-1">Sin Dependencia</label>
            <select name="sin_dependencia" id="sin_dependencia"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto bg-white">
                <option value="">Todos</option>
                <option value="1" @selected(request('sin_dependencia') == '1')>Sí</option>
                <option value="0" @selected(request('sin_dependencia') == '0')>No</option>
            </select>
        </div>

        {{-- Estados y Acciones --}}
        <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-gray-50">
            <div class="flex flex-wrap gap-4">
                <span class="text-sm font-medium text-gray-700">Estado:</span>
                @foreach($estados as $valor => $label)
                    <label class="inline-flex items-center text-sm text-gray-700 cursor-pointer group">
                        <input type="checkbox" name="estado[]" value="{{ $valor }}"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 filtro-auto"
                               @checked(collect(request('estado'))->contains($valor))>
                        <span class="ml-2 group-hover:text-blue-600 transition">{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('bienes.index') }}"
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                    Limpiar Filtros
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-bold">
                    Aplicar
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Chips de Filtros Activos --}}
<div id="activeFiltersContainer">
    @php
        $params = request()->only(['search', 'tipo_bien', 'organismo_id', 'unidad_id', 'fecha_desde', 'fecha_hasta', 'estado', 'dependencias']);
        $activeFilters = collect($params)->filter(fn($v) => filled($v));
    @endphp

    @if($activeFilters->isNotEmpty())
        <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
            <span class="font-medium text-gray-600">Filtrado por:</span>
            @foreach($activeFilters as $key => $value)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                    <span class="font-bold mr-1">
                        @switch($key)
                            @case('search') Búsqueda @break
                            @case('tipo_bien') Tipo @break
                            @case('organismo_id') Organismo @break
                            @case('unidad_id') Unidad @break
                            @case('fecha_desde') Desde @break
                            @case('fecha_hasta') Hasta @break
                            @case('estado') Estados @break
                            @case('dependencias') Dependencias @break
                            @default {{ ucfirst($key) }}
                        @endswitch:
                    </span>

                    @php
                        $display = $value;
                        if($key == 'tipo_bien') $display = $tiposBien[$value] ?? $value;
                        if($key == 'organismo_id') $display = $organismos->firstWhere('id', $value)->nombre ?? $value;
                        if($key == 'unidad_id') $display = $unidades->firstWhere('id', $value)->nombre ?? $value;
                        if(is_array($value)) $display = count($value) . ' selec.';
                    @endphp

                    {{ $display }}
                    <a href="{{ route('bienes.index', request()->except($key)) }}" class="ml-2 hover:text-red-500 font-bold">×</a>
                </span>
            @endforeach
        </div>
    @endif
</div>
{{-- Tabla de Resultados --}}
{{-- En index.blade.php --}}
<div id="tablaBienesContainer" class="transition-opacity duration-300">
    @include('bienes.partials.table', ['bienes' => $bienes])
</div>

{{-- Elimina el div de paginación de aquí si ya está dentro del partial --}}



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtrosForm = document.getElementById('filtrosForm');
    const container = document.getElementById('tablaBienesContainer');

    // 1. Función unificada para pedir datos
    const cargarDatos = (url) => {
        container.style.opacity = '0.5';

        fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
            container.style.opacity = '1';
            // Actualizar la URL del navegador para que el usuario pueda copiar/pegar el link
            window.history.pushState({}, '', url);
        })
        .catch(error => {
            console.error('Error:', error);
            container.style.opacity = '1';
        });
    };

    // 2. Función para construir la URL basada en los filtros
    const aplicarFiltros = () => {
        const formData = new FormData(filtrosForm);
        const params = new URLSearchParams(formData);
        // Al cambiar un filtro, normalmente queremos volver a la página 1
        params.delete('page');

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        cargarDatos(newUrl);
    };

    // 3. EVENT DELEGATION para la paginación
    // Esto es vital: escuchamos el click en el contenedor, no en el link directamente
    container.addEventListener('click', function(e) {
        // Buscamos si lo que se clickeó es un enlace de paginación
        const link = e.target.closest('.pagination a, a[rel="next"], a[rel="prev"]');

        if (link) {
            e.preventDefault();
            const url = new URL(link.href);
            const page = url.searchParams.get('page');

            // Mezclamos los filtros actuales con la nueva página
            const formData = new FormData(filtrosForm);
            const params = new URLSearchParams(formData);
            params.set('page', page);

            const finalUrl = `${window.location.pathname}?${params.toString()}`;
            cargarDatos(finalUrl);
        }
    });

    // 4. Listeners de filtros
    document.querySelectorAll('.filtro-auto').forEach(el => {
        el.addEventListener('change', aplicarFiltros);
    });

    filtrosForm.addEventListener('submit', function(e) {
        e.preventDefault();
        aplicarFiltros();
    });
});
</script>
@endpush
@endsection

