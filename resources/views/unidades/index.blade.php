@extends('layouts.base')

@section('title', 'Unidades Administradoras')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
    📚 Unidades Administradoras
</h1>

    <a href="{{ route('unidades.create') }}"
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

{{-- Buscador --}}
<div class="mb-4">
    <form action="{{ route('unidades.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Buscar por código o nombre..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>
</div>

{{-- Tabla de unidades --}}
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organismo</th>
                    <th class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dependencias</th>
                    <th class="px-8 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($unidades as $unidad)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-4 text-sm text-gray-900 font-mono">{{ $unidad->codigo }}</td>
                        <td class="px-8 py-4 text-sm text-gray-900 whitespace-normal break-words">{{ $unidad->nombre }}</td>
                        <td class="px-8 py-4 text-sm text-gray-600 whitespace-normal break-words">{{ $unidad->organismo->nombre ?? '-' }}</td>
                        <td class="px-8 py-4 text-sm text-gray-600">
                            @if($unidad->dependencias->count())
                                <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    {{ $unidad->dependencias->count() }} dependencias
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-sm text-right space-x-2">
                            @include('components.action-buttons', [
                                'resource' => 'unidades',
                                'model' => $unidad,
                                'confirm' => "¿Seguro que deseas eliminar esta unidad?",
                                'label' => $unidad->nombre
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-4 text-center text-sm text-gray-500">
                            No hay unidades registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if($unidades->hasPages())
    <div class="mt-6">
        {{ $unidades->links() }}
    </div>
@endif
@endsection



