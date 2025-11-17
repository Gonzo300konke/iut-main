@extends('layouts.base')

@section('title', 'Movimientos')

@section('content')
<div class="w-full">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">📄 Movimientos</h1>
        </div>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4">
            <form action="{{ route('movimientos.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <label for="search" class="text-sm font-medium text-gray-700 mb-1">🔍 Búsqueda rápida</label>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                               placeholder="Observaciones, sujeto o usuario"
                               class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col">
                        <label for="model_type" class="text-sm font-medium text-gray-700 mb-1">📑 Tipo de modelo</label>
                        <select name="model_type" id="model_type"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            @foreach($modelos as $modelo)
                                <option value="{{ $modelo }}"
                                    @selected(($filters['model_type'] ?? '') === $modelo)>
                                    {{ class_basename($modelo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="usuario_id" class="text-sm font-medium text-gray-700 mb-1">👤 Usuario</label>
                        <select name="usuario_id" id="usuario_id"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    @selected(($filters['usuario_id'] ?? '') == $usuario->id)>
                                    {{ $usuario->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <label for="fecha_desde" class="text-sm font-medium text-gray-700 mb-1">📅 Fecha desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" value="{{ $filters['fecha_desde'] ?? '' }}"
                               class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col">
                        <label for="fecha_hasta" class="text-sm font-medium text-gray-700 mb-1">📅 Fecha hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ $filters['fecha_hasta'] ?? '' }}"
                               class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col">
                        <label for="tipo" class="text-sm font-medium text-gray-700 mb-1">⚙️ Tipo de movimiento</label>
                        <input type="text" name="tipo" id="tipo" value="{{ $filters['tipo'] ?? '' }}"
                               placeholder="Registro, Actualización, Eliminación..."
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

        {{-- Filtros activos --}}
        @php
            $activeFilters = collect($filters ?? [])->filter(function ($value, $key) {
                if (is_array($value)) {
                    return ! empty($value);
                }
                return filled($value);
            });
        @endphp

        @if($activeFilters->isNotEmpty())
            <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                <span class="font-medium text-gray-700">Filtros activos:</span>
                @foreach($activeFilters as $key => $value)
                    @php
                        $label = match($key) {
                            'search' => 'Búsqueda',
                            'model_type' => 'Modelo',
                            'usuario_id' => 'Usuario',
                            'fecha_desde' => 'Desde',
                            'fecha_hasta' => 'Hasta',
                            'tipo' => 'Tipo',
                            default => ucfirst(str_replace('_', ' ', $key)),
                        };

                        $display = $value;
                        if ($key === 'model_type') {
                            $display = class_basename($value);
                        } elseif ($key === 'usuario_id') {
                            $display = optional($usuarios->firstWhere('id', $value))->nombre_completo ?? $value;
                        }
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                        {{ $label }}: <span class="ml-1 font-medium">{{ $display }}</span>
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Aquí siguen las tablas de movimientos y eliminados tal como ya las tienes --}}
        <div class="grid grid-cols-1 md:grid-cols-{{ isset($eliminados) ? '2' : '1' }} gap-6">
            <!-- Tabla de movimientos -->
            {{-- ... tu tabla de movimientos ... --}}
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

                <div class="mt-4">{{ $movimientos->appends($filters)->links() }}</div>
            </div>
            <!-- Tabla de eliminados -->
            {{-- ... tu tabla de eliminados ... --}}
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
                                        <form action="{{ route('movimientos.eliminados.restore', $e->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 rounded hover:bg-green-100">
                                                Restaurar
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $eliminados->appends($filters)->links('pagination::tailwind', ['pageName' => 'eliminados_page']) }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

        </div>
    </div>
</div>
@endsection



