@extends('layouts.base')

@section('title', 'Movimientos')

@section('content')
<div class="w-full">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Movimientos</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if(isset($eliminados) && $eliminados)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Movimientos -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Movimientos</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Tipo</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Bien</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Usuario</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Observaciones</th>
                                    <th class="px-6 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($movimientos as $mov)
                                    <tr>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->fecha?->format('Y-m-d') ?? $mov->fecha }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->tipo }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->bien->descripcion ?? '-' }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->usuario->nombre_completo ?? ($mov->usuario->nombre ?? '-') }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($mov->observaciones, 80) }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <a href="{{ route('movimientos.show', $mov->id) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $movimientos->links() }}</div>
                </div>

                <!-- Eliminados -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Registros Eliminados (archivados)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Modelo</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Model ID</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Eliminado Por</th>
                                    <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                                    <th class="px-6 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($eliminados as $e)
                                    <tr>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ class_basename($e->model_type) }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $e->model_id }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $e->deleted_by_user ?? ($e->deleted_by ?? '-') }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $e->deleted_at?->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <button type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 rounded hover:bg-green-100 restore-button" data-id="{{ $e->id }}" data-model="{{ class_basename($e->model_type) }}" data-model-id="{{ $e->model_id }}">Restaurar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $eliminados->links('pagination::tailwind', ['pageName' => 'eliminados_page']) }}</div>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Fecha</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Tipo</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Bien</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Usuario</th>
                            <th class="px-6 py-2 text-left text-sm font-medium text-gray-700">Observaciones</th>
                            <th class="px-6 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($movimientos as $mov)
                            <tr>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->fecha?->format('Y-m-d') ?? $mov->fecha }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->tipo }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->bien->descripcion ?? '-' }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $mov->usuario->nombre_completo ?? ($mov->usuario->nombre ?? ($mov->usuario_id ?? '-')) }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($mov->observaciones, 80) }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('movimientos.show', $mov->id) }}" class="text-blue-600 hover:underline">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $movimientos->links() }}</div>
        @endif
        
    </div>
</div>
@endsection
