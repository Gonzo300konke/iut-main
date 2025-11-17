@extends('layouts.base')

@section('title', 'Registros Eliminados')

@section('content')
<div class="w-full">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Registros Eliminados</h1>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Modelo</th>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Eliminado Por</th>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                        <th class="px-6 py-2"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($eliminados as $e)
                        <tr>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ class_basename($e->model_type) }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $e->model_id }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $e->deleted_by ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $e->deleted_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('eliminados.show', $e->id) }}" class="text-blue-600 hover:underline mr-4">Ver</a>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <form action="{{ route('eliminados.restore', $e->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:underline">Restaurar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-sm text-gray-500">
                                No hay registros eliminados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $eliminados->links() }}
        </div>
    </div>
</div>
@endsection


