@extends('layouts.base')

@section('title', 'Usuarios')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Usuarios</h1>
    <a href="{{ route('usuarios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Nuevo Usuario
    </a>
</div>

{{-- Buscador --}}
<div class="mb-4">
    <form action="{{ route('usuarios.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Buscar por cédula, nombre o correo..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Cédula</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nombre y Apellido</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Correo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rol</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $usuario->cedula }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $usuario->nombre_completo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $usuario->correo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $usuario->rol->nombre ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($usuario->is_admin)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full">Administrador</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Usuario</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($usuario->activo)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Activo</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-right space-x-2">
                        @include('components.action-buttons', [
                            'resource' => 'usuarios',
                            'model' => $usuario,
                            'canDelete' => auth()->user()->canDeleteUser($usuario),
                            'confirm' => '¿Estás seguro? No podrás deshacer esta acción.',
                            'label' => $usuario->nombre_completo
                        ])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($usuarios->hasPages())
    <div class="mt-6">
        {{ $usuarios->links() }}
    </div>
@endif
@endsection

