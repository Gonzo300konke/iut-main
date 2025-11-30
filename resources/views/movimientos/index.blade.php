@extends('layouts.base')

@section('title', 'Movimientos')

@section('content')
<div class="w-full">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">📄 Movimientos</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTROS NORMALES (SIEMPRE VISIBLES) --}}
<div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4 border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Opciones de Filtrado</h2>

    {{-- 1. CAMBIO: Quitar el action y method del form si se usa AJAX, PERO en este caso lo mantendremos para el fallback y usaremos JS para prevenir el envío --}}
    <form action="{{ route('movimientos.index') }}" method="GET" class="space-y-4" id="filtrosForm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label for="tipo" class="text-sm font-medium text-gray-700 mb-1">Tipo de movimiento</label>
                {{-- 2. CAMBIO: Agregar la clase 'filtro-auto' para que se dispare el evento JS --}}
                <select name="tipo" id="tipo"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
                    <option value="">Todos</option>
                    <option value="Registro" @selected(($filters['tipo'] ?? '') === 'Registro')>Registro</option>
                    <option value="Actualización" @selected(($filters['tipo'] ?? '') === 'Actualización')>Actualización</option>
                    <option value="Eliminación" @selected(($filters['tipo'] ?? '') === 'Eliminación')>Eliminación</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label for="usuario" class="text-sm font-medium text-gray-700 mb-1">Usuario</label>
                {{-- 3. CAMBIO: Agregar la clase 'filtro-input' para keyup y 'filtro-auto' --}}
                <input type="text" name="usuario" id="usuario" value="{{ $filters['usuario'] ?? '' }}"
                    placeholder="Nombre del usuario"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto filtro-input">
            </div>

            <div class="flex flex-col">
                <label for="entidad" class="text-sm font-medium text-gray-700 mb-1">Entidad</label>
                {{-- 4. CAMBIO: Agregar la clase 'filtro-input' para keyup y 'filtro-auto' --}}
                <input type="text" name="entidad" id="entidad" value="{{ $filters['entidad'] ?? '' }}"
                    placeholder="Ej: Bien, Compra, Usuario..."
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto filtro-input">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="fecha_desde" class="text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                {{-- 5. CAMBIO: Agregar la clase 'filtro-auto' --}}
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ $filters['fecha_desde'] ?? '' }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
            </div>
            <div class="flex flex-col">
                <label for="fecha_hasta" class="text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                {{-- 6. CAMBIO: Agregar la clase 'filtro-auto' --}}
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ $filters['fecha_hasta'] ?? '' }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto">
            </div>
        </div>

        <div class="flex items-center gap-2 justify-end pt-2 border-t border-gray-100">
            <a href="{{ route('movimientos.index') }}"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                Limpiar
            </a>
            {{-- 7. CAMBIO: El botón de submit ahora llamará al filtro AJAX --}}
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Aplicar filtros
            </button>
        </div>
    </form>
</div>
{{-- FIN FILTROS NORMALES --}}

@php
    $activeFilters = collect($filters ?? [])->filter(fn($value) => filled($value));
@endphp

{{-- Los filtros activos no necesitan cambio si solo quieres actualizar la tabla --}}
@if($activeFilters->isNotEmpty())
    <div class="mb-4 flex flex-wrap items-center gap-2 text-sm" id="activeFiltersContainer">
        <span class="font-medium text-gray-700">Filtros activos:</span>
        @foreach($activeFilters as $key => $value)
            @php
                $label = match($key) {
                    'tipo' => 'Tipo',
                    'usuario' => 'Usuario',
                    'entidad' => 'Entidad',
                    'fecha_desde' => 'Desde',
                    'fecha_hasta' => 'Hasta',
                    default => ucfirst(str_replace('_', ' ', $key)),
                };

                $displayValue = $value;
                if ($key === 'tipo') {
                    $displayValue = match($value) {
                        'Registro' => 'Registro',
                        'Actualización' => 'Actualización',
                        'Eliminación' => 'Eliminación',
                        default => $value,
                    };
                }

                $querySinFiltro = collect(request()->query())->forget($key)->toArray();
            @endphp

            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                {{ $label }}: <span class="ml-1 font-medium">{{ $displayValue }}</span>
                <a href="{{ route('movimientos.index', $querySinFiltro) }}"
                    class="ml-2 text-indigo-500 hover:text-red-600 font-bold" title="Quitar filtro">
                    ×
                </a>
            </span>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-{{ isset($eliminados) ? '2' : '1' }} gap-6">


    {{-- 8. CAMBIO: Agregamos un ID al contenedor de la tabla para poder actualizar solo su contenido --}}
    <div id="movimientosResultadosContainer">
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-3">Movimientos registrados</h2>
            <div class="overflow-x-auto" id="tablaMovimientos"> {{-- 9. CAMBIO: ID para la tabla principal --}}
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Tipo</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Entidad</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Usuario</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Observaciones</th>
                            <th class="px-6 py-2 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($movimientos as $mov)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ optional($mov->fecha)->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm font-semibold">
                                    <span class="px-2 py-1 rounded-full text-xs {{ match($mov->tipo) {
                                        'Registro' => 'bg-green-100 text-green-800',
                                        'Actualización' => 'bg-yellow-100 text-yellow-800',
                                        'Eliminación' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-700',
                                    } }}">
                                        {{ $mov->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-700">
                                    @php
                                        $s = $mov->subject;
                                        $label = $s?->nombre_completo ?? $s?->nombre ?? $s?->descripcion ?? $s?->codigo ?? 'ID '.$mov->subject_id;
                                    @endphp
                                    <strong>{{ class_basename($mov->subject_type ?? 'Bien') }}</strong> - {{ $label }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-700">
                                    {{ $mov->usuario->nombre_completo ?? $mov->usuario->nombre ?? '-' }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($mov->observaciones, 80) }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('movimientos.show', $mov->id) }}"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay movimientos registrados que coincidan con los filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4" id="movimientosPagination">{{ $movimientos->links() }}</div> {{-- 10. CAMBIO: ID para la paginación --}}
        </div>
    </div>


    {{-- 11. CAMBIO: Contenedor para la tabla de eliminados --}}
    @if(isset($eliminados) && $eliminados)
    <div id="eliminadosResultadosContainer">
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-3">Registros eliminados (archivados)</h2>
            <div class="overflow-x-auto" id="tablaEliminados"> {{-- ID para la tabla de eliminados --}}
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Modelo</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Eliminado por</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                            <th class="px-6 py-2 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($eliminados as $e)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ class_basename($e->model_type) }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $e->model_id }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $e->deleted_by_user ?? $e->deleted_by ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ optional($e->deleted_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-3 text-right">
                                    <button type="button"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 rounded hover:bg-green-100 restore-button"
                                            data-id="{{ $e->id }}"
                                            data-model="{{ class_basename($e->model_type) }}"
                                            data-model-id="{{ $e->model_id }}">
                                        Restaurar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4" id="eliminadosPagination">{{ $eliminados->links('pagination::tailwind', ['pageName' => 'eliminados_page']) }}</div>
        </div>
    </div>
    @endif
</div>
    </div>
</div>

<script>
    let fetchTimeout;

    /**
     * Realiza la petición AJAX para filtrar y actualiza solo los resultados.
     */
    function aplicarFiltros(url = null) {
        // Limpiar el timeout anterior para evitar peticiones múltiples/rápidas
        if (fetchTimeout) {
            clearTimeout(fetchTimeout);
        }

        // Definir un pequeño retraso (e.g., 300ms) para que el usuario termine de escribir
        fetchTimeout = setTimeout(() => {
            const form = document.getElementById('filtrosForm');
            const baseUrl = url || form.action;
            const currentParams = new URLSearchParams(window.location.search);

            // 1. Obtener los parámetros actuales del formulario
            const formParams = new URLSearchParams(new FormData(form));

            // 2. Mantener el parámetro de paginación de eliminados si existe en la URL actual
            const eliminadosPage = currentParams.get('eliminados_page');
            if (eliminadosPage) {
                formParams.set('eliminados_page', eliminadosPage);
            }

            const fetchUrl = baseUrl.split('?')[0] + '?' + formParams.toString();

            // Reemplazar la URL en el historial sin recargar
            window.history.pushState(null, '', fetchUrl);

            // 3. Realizar la petición AJAX
            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Importante para que Laravel sepa que es una petición AJAX
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Respuesta de red no fue ok');
                }
                return res.text();
            })
            .then(html => {
                // 4. Parsear el HTML completo de la respuesta
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // 5. Encontrar los nuevos elementos y reemplazar

                // Actualizar la tabla de movimientos (principal)
                const nuevaTablaMovimientos = doc.querySelector('#tablaMovimientos');
                const contenedorMovimientos = document.getElementById('tablaMovimientos');
                if (nuevaTablaMovimientos && contenedorMovimientos) {
                    contenedorMovimientos.innerHTML = nuevaTablaMovimientos.innerHTML;
                }

                // Actualizar la paginación de movimientos
                const nuevaPaginacionMov = doc.querySelector('#movimientosPagination');
                const contenedorPaginacionMov = document.getElementById('movimientosPagination');
                if (nuevaPaginacionMov && contenedorPaginacionMov) {
                    contenedorPaginacionMov.innerHTML = nuevaPaginacionMov.innerHTML;
                    // Reasignar eventos de paginación
                    attachPaginationListeners();
                }

                // Actualizar la sección de filtros activos
                const nuevosFiltrosActivos = doc.querySelector('#activeFiltersContainer');
                const contenedorFiltrosActivos = document.getElementById('activeFiltersContainer');
                if (contenedorFiltrosActivos) {
                    if (nuevosFiltrosActivos) {
                        contenedorFiltrosActivos.innerHTML = nuevosFiltrosActivos.innerHTML;
                    } else {
                        contenedorFiltrosActivos.innerHTML = ''; // Limpiar si no hay filtros activos
                    }
                }

                // Opcional: Actualizar tabla de eliminados si existe
                const nuevaTablaEliminados = doc.querySelector('#tablaEliminados');
                const contenedorEliminados = document.getElementById('tablaEliminados');
                if (nuevaTablaEliminados && contenedorEliminados) {
                    contenedorEliminados.innerHTML = nuevaTablaEliminados.innerHTML;
                }

                // Opcional: Actualizar paginación de eliminados si existe
                const nuevaPaginacionElim = doc.querySelector('#eliminadosPagination');
                const contenedorPaginacionElim = document.getElementById('eliminadosPagination');
                if (nuevaPaginacionElim && contenedorPaginacionElim) {
                    contenedorPaginacionElim.innerHTML = nuevaPaginacionElim.innerHTML;
                    // Reasignar eventos de paginación
                    attachPaginationListeners();
                }

            })
            .catch(error => console.error('Error al filtrar:', error));

        }, 300); // 300ms de retraso
    }

    /**
     * Adjunta los listeners de click a los enlaces de paginación.
     */
    function attachPaginationListeners() {
        // Capturar enlaces de paginación de movimientos
        document.querySelectorAll('#movimientosPagination a').forEach(link => {
            // Evitar que se dupliquen listeners
            link.removeEventListener('click', handlePaginationClick);
            link.addEventListener('click', handlePaginationClick);
        });

        // Capturar enlaces de paginación de eliminados
        document.querySelectorAll('#eliminadosPagination a').forEach(link => {
            link.removeEventListener('click', handlePaginationClick);
            link.addEventListener('click', handlePaginationClick);
        });
    }

    /**
     * Handler para los clicks en enlaces de paginación.
     */
    function handlePaginationClick(e) {
        e.preventDefault();
        const url = this.href;
        // La paginación siempre es un filtro 'limpio', así que pasamos la URL directamente
        aplicarFiltros(url);
    }

    // Inicializar listeners
    document.addEventListener('DOMContentLoaded', () => {
        // Disparar el filtro (Submit) al cambiar cualquier select/date/checkbox
        document.querySelectorAll('.filtro-auto').forEach(el => {
            el.addEventListener('change', () => aplicarFiltros());
        });

        // Disparar el filtro (Keyup con delay) para inputs de texto
        document.querySelectorAll('.filtro-input').forEach(el => {
            el.addEventListener('keyup', () => aplicarFiltros());
        });

        // Interceptar el submit normal del formulario
        document.getElementById('filtrosForm').addEventListener('submit', function(e) {
            e.preventDefault();
            aplicarFiltros();
        });

        // Adjuntar listeners de paginación inicialmente
        attachPaginationListeners();
    });
</script>

@endsection

