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
         {{-- Filtros --}}
<div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4">
    <form action="{{ route('movimientos.index') }}" method="GET" class="space-y-4" id="filtrosForm">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label for="tipo" class="text-sm font-medium text-gray-700 mb-1">Tipo de movimiento</label>
                <select name="tipo" id="tipo"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="Registro" @selected(($filters['tipo'] ?? '') === 'Registro')>Registro</option>
                    <option value="Actualización" @selected(($filters['tipo'] ?? '') === 'Actualización')>Actualización</option>
                    <option value="Eliminación" @selected(($filters['tipo'] ?? '') === 'Eliminación')>Eliminación</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label for="usuario" class="text-sm font-medium text-gray-700 mb-1">Usuario</label>
                <input type="text" name="usuario" id="usuario" value="{{ $filters['usuario'] ?? '' }}"
                       placeholder="Nombre del usuario"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex flex-col">
                <label for="entidad" class="text-sm font-medium text-gray-700 mb-1">Entidad</label>
                <input type="text" name="entidad" id="entidad" value="{{ $filters['entidad'] ?? '' }}"
                       placeholder="Ej: Bien, Compra, Usuario..."
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="fecha_desde" class="text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ $filters['fecha_desde'] ?? '' }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col">
                <label for="fecha_hasta" class="text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ $filters['fecha_hasta'] ?? '' }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex items-center gap-2 justify-end">
            <a href="{{ route('movimientos.index') }}"
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
                @php
    $activeFilters = collect($filters ?? [])->filter(fn($value) => filled($value));
@endphp

@if($activeFilters->isNotEmpty())
    <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
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
                $querySinFiltro = collect($filters)->forget($key)->toArray();
            @endphp

            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                {{ $label }}: <span class="ml-1 font-medium">{{ $value }}</span>
                <a href="{{ route('movimientos.index', $querySinFiltro) }}"
                   class="ml-2 text-indigo-500 hover:text-red-600 font-bold" title="Quitar filtro">
                    ×
                </a>
            </span>
        @endforeach
    </div>
@endif
        <div class="grid grid-cols-1 md:grid-cols-{{ isset($eliminados) ? '2' : '1' }} gap-6">


            <!-- Tabla de movimientos -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-3">Movimientos registrados</h2>
                <div class="overflow-x-auto">
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
                                        No hay movimientos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $movimientos->links() }}</div>
            </div>

            <!-- Tabla de eliminados -->
            @if(isset($eliminados) && $eliminados)
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-3">Registros eliminados (archivados)</h2>
                <div class="overflow-x-auto">
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

                <div class="mt-4">{{ $eliminados->links('pagination::tailwind', ['pageName' => 'eliminados_page']) }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


