@extends('layouts.base')

@section('title', 'Dependencias')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        🔗 Dependencias
    </h1>
    <a href="{{ route('dependencias.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Nueva
    </a>
</div>

{{-- Mensajes de éxito --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Filtros --}}
<div class="mb-6 bg-white shadow rounded-lg p-4 space-y-4">
    <form action="{{ route('dependencias.index') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label for="search" class="text-sm font-medium text-gray-700 mb-1">Búsqueda rápida</label>
                <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Código o nombre"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col">
                <label for="codigo" class="text-sm font-medium text-gray-700 mb-1">Código</label>
                <input type="text" name="codigo" id="codigo" value="{{ $filters['codigo'] ?? '' }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col">
                <label for="unidad_id" class="text-sm font-medium text-gray-700 mb-1">Unidad Administradora</label>
                <select name="unidad_id" id="unidad_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->id }}"
                            @selected(($filters['unidad_id'] ?? null) == $unidad->id)>
                            {{ $unidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2 justify-end">
            <a href="{{ route('dependencias.index') }}"
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
    $activeFilters = collect($filters ?? [])->filter(fn($v) => is_array($v) ? !empty($v) : filled($v));
@endphp

@if($activeFilters->isNotEmpty())
    <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
        <span class="font-medium text-gray-700">Filtros activos:</span>
        @foreach($activeFilters as $key => $value)
            @php
                $label = match($key) {
                    'search' => 'Búsqueda',
                    'codigo' => 'Código',
                    'unidad_id' => 'Unidad',
                    default => ucfirst(str_replace('_',' ',$key)),
                };

                $display = $value;
                if ($key === 'unidad_id') {
                    $display = optional($unidades->firstWhere('id',$value))->nombre ?? $value;
                }
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                {{ $label }}: <span class="ml-1 font-medium">{{ $display }}</span>
            </span>
        @endforeach
    </div>
@endif

{{-- Tabla --}}
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unidad Administradora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bienes</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dependencias as $dep)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-mono">{{ $dep->codigo }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $dep->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $dep->unidadAdministradora->nombre ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($dep->bienes->count())
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    {{ $dep->bienes->count() }} bienes
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            @include('components.action-buttons', [
                                'resource' => 'dependencias',
                                'model' => $dep,
                                'confirm' => "¿Seguro que deseas eliminar esta dependencia?",
                                'label' => $dep->nombre
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No hay dependencias registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if($dependencias->hasPages())
    <div class="mt-6">
        {{ $dependencias->links() }}
    </div>
@endif
@endsection



