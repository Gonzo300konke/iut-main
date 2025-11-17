@extends('layouts.base')

@section('title', 'Organismos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🏢 Organismos</h1>
    <a href="{{ route('organismos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Nuevo
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif
            {{-- Buscador --}}
        <div class="mb-4">
            <form action="{{ route('organismos.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Buscar por código o nombre..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Buscar
                </button>
            </form>
        </div>


        {{-- Tabla de organismos --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($organismos as $organismo)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-mono">{{ $organismo->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $organismo->codigo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $organismo->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-right space-x-2">
                                    @include('components.action-buttons', [
                                        'resource' => 'organismos',
                                        'model' => $organismo,
                                        'confirm' => '¿Estás seguro?',
                                        'label' => $organismo->nombre
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay organismos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

@if($organismos->hasPages())
    <div class="mt-6">
        {{ $organismos->links() }}
    </div>
@endif
@endsection


