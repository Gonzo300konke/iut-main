@extends('layouts.base')

@section('title', 'Organismos')

@section('content')
{{-- resources/views/organismos/index.blade.php --}}

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        🏢 Organismos
    </h1>
    <div class="flex gap-4">
        <a href="{{ route('organismos.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Nuevo Organismo
        </a>
    </div>
</div>

{{-- Mensajes de éxito --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Filtros --}}
<div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4">
    <form action="{{ route('organismos.index') }}" method="GET" class="space-y-4" id="filtrosForm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Filtro General (Búsqueda) --}}
            <div class="flex flex-col">
                <label for="buscar" class="text-sm font-medium text-gray-700 mb-1">Búsqueda general</label>
                <input type="text"
                       name="buscar"
                       id="buscar"
                       value="{{ $validated['buscar'] ?? '' }}"
                       maxlength="40"
                       placeholder="Nombre o código (máx. 40 caracteres)..."
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto filtro-input">

                <p id="error-msg-buscar" class="text-red-500 text-xs mt-1 hidden font-semibold">
                    ⚠️ Solo se permiten letras, números y espacios.
                </p>
            </div>

            {{-- Filtro por Código (Específico) --}}
            <div class="flex flex-col">
                <label for="codigo" class="text-sm font-medium text-gray-700 mb-1">Código exacto (Sólo números)</label>
                <input type="text"
                       name="codigo"
                       id="codigo"
                       inputmode="numeric"
                       maxlength="8"
                       value="{{ $validated['codigo'] ?? '' }}"
                       placeholder="Máx. 8 dígitos"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 filtro-auto filtro-input">
                {{-- Aviso de error para el código --}}
                <p id="error-codigo-msg" class="text-red-500 text-xs mt-1 hidden font-semibold">
                    ⚠️ Solo se permiten números (máx. 8).
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 justify-end">
            <a href="{{ route('organismos.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                Limpiar
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Aplicar filtros
            </button>
        </div>
    </form>
</div>

{{-- Chips de Filtros Activos --}}
<div id="activeFiltersContainer">
    @php
        $activeFilters = collect(request()->only(['buscar', 'codigo', 'nombre']))->filter();
    @endphp
    @if($activeFilters->isNotEmpty())
        <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
            <span class="font-medium text-gray-700">Filtros activos:</span>
            @foreach($activeFilters as $key => $value)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                    {{ ucfirst($key) }}: <span class="ml-1 font-medium">{{ $value }}</span>
                    <a href="{{ route('organismos.index', request()->except($key)) }}"
                       class="ml-2 text-indigo-500 hover:text-red-600 font-bold"> × </a>
                </span>
            @endforeach
        </div>
    @endif
</div>

{{-- Tabla --}}
<div class="bg-white shadow-md rounded-lg overflow-hidden" id="tablaOrganismos">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($organismos as $organismo)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-blue-600 font-mono">{{ $organismo->codigo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $organismo->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                @include('components.action-buttons', [
                                    'resource' => 'organismos',
                                    'model' => $organismo,
                                    'canDelete' => false
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500 italic">
                                No se encontraron organismos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-6" id="organismosPagination">
    @if($organismos->hasPages())
        {{ $organismos->links() }}
    @endif
</div>

@push('scripts')
<script>
    let fetchTimeout;

    // --- FUNCIÓN PARA MANTENER EL CURSOR EN SU SITIO ---
    function validarYLimpiar(input, regex, msgError) {
        const cursorPosition = input.selectionStart;
        const originalValue = input.value;
        const cleanValue = originalValue.replace(regex, '');

        if (originalValue !== cleanValue) {
            if (msgError) {
                msgError.classList.remove('hidden');
                setTimeout(() => msgError.classList.add('hidden'), 2000);
            }
            input.value = cleanValue;
            // Reubicar el cursor para que no salte al final
            input.setSelectionRange(cursorPosition - 1, cursorPosition - 1);
        }
    }

    function aplicarFiltros(url = null) {
        if (fetchTimeout) clearTimeout(fetchTimeout);

        fetchTimeout = setTimeout(() => {
            const form = document.getElementById('filtrosForm');
            const baseUrl = form.action.split('?')[0];
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            // --- CORRECCIÓN DE PAGINACIÓN ---
            // Si recibimos una URL (de la paginación), extraemos el 'page' y lo inyectamos
            if (url) {
                const urlObj = new URL(url);
                const page = urlObj.searchParams.get('page');
                if (page) params.set('page', page);
            } else {
                // Si cambiamos un filtro manual, volvemos a la página 1
                params.delete('page');
            }

            const fetchUrl = `${baseUrl}?${params.toString()}`;
            window.history.pushState(null, '', fetchUrl);

            fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Actualización dinámica de fragmentos
                const targets = ['tablaOrganismos', 'organismosPagination', 'activeFiltersContainer'];
                targets.forEach(id => {
                    const el = document.getElementById(id);
                    const newEl = doc.getElementById(id);
                    if (el && newEl) el.innerHTML = newEl.innerHTML;
                });

                attachPaginationListeners();
            })
            .catch(error => console.error('Error:', error));
        }, 300);
    }

    function attachPaginationListeners() {
        document.querySelectorAll('#organismosPagination a').forEach(link => {
            link.onclick = function(e) {
                e.preventDefault();
                aplicarFiltros(this.href);
            };
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const inputBuscar = document.getElementById('buscar');
        const inputCodigo = document.getElementById('codigo');

        // Validaciones con corrección de cursor
        if (inputBuscar) {
            inputBuscar.addEventListener('input', function() {
                validarYLimpiar(this, /[^a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]/g, document.getElementById('error-buscar-msg'));
            });
        }

        if (inputCodigo) {
            inputCodigo.addEventListener('input', function() {
                validarYLimpiar(this, /[^0-9]/g, document.getElementById('error-codigo-msg'));
            });
        }

        // Listeners automáticos
        document.querySelectorAll('.filtro-auto').forEach(el => {
            el.addEventListener('change', () => aplicarFiltros());
        });

        document.querySelectorAll('.filtro-input').forEach(el => {
            el.addEventListener('keyup', (e) => {
                // No disparar si son teclas de control (flechas, shift, etc)
                if (e.key.length > 1 && e.key !== 'Backspace' && e.key !== 'Delete') return;
                aplicarFiltros();
            });
        });

        document.getElementById('filtrosForm').onsubmit = (e) => {
            e.preventDefault();
            aplicarFiltros();
        };

        attachPaginationListeners();
    });
</script>
@endpush
@endsection
