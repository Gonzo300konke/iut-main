@extends('layouts.base')

@section('title', 'Detalle del Movimiento')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Movimiento #{{ $movimiento->id }}</h1>

        <dl class="grid grid-cols-1 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-600">Fecha</dt>
                <dd class="text-lg text-gray-800">{{ $movimiento->fecha->format('Y-m-d') ?? $movimiento->fecha }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-600">Tipo</dt>
                <dd class="text-lg text-gray-800">{{ $movimiento->tipo }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-600">Bien</dt>
                <dd class="text-lg text-gray-800">{{ $movimiento->bien->codigo ?? '-' }} - {{ $movimiento->bien->descripcion ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-600">Usuario</dt>
                <dd class="text-lg text-gray-800">{{ $movimiento->usuario->nombre_completo ?? ($movimiento->usuario->nombre ?? '-') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-600">Observaciones</dt>
                <dd class="text-lg text-gray-800">{{ $movimiento->observaciones }}</dd>
            </div>
        </dl>

        <div class="mt-4">
            <a href="{{ route('movimientos.index') }}" class="bg-gray-200 px-4 py-2 rounded">Volver</a>
        </div>
    </div>
</div>
@endsection
