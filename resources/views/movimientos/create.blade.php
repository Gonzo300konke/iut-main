@extends('layouts.base')

@section('title', 'Registrar Movimiento')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Registrar Movimiento</h1>

        <form action="{{ route('movimientos.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Bien</label>
                <select name="bien_id" class="mt-1 block w-full rounded-md border px-3 py-2">
                    @foreach(\App\Models\Bien::orderBy('descripcion')->get() as $bien)
                        <option value="{{ $bien->id }}">{{ $bien->codigo }} - {{ $bien->descripcion }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sujeto (opcional)</label>
                <select name="subject_type" class="mt-1 block w-full rounded-md border px-3 py-2">
                    <option value="">-- Ninguno --</option>
                    <option value="{{ \App\Models\Organismo::class }}">Organismo</option>
                    <option value="{{ \App\Models\UnidadAdministradora::class }}">Unidad Administradora</option>
                    <option value="{{ \App\Models\Dependencia::class }}">Dependencia</option>
                    <option value="{{ \App\Models\Bien::class }}">Bien</option>
                    <option value="{{ \App\Models\Usuario::class }}">Usuario</option>
                </select>

                <label class="block text-sm font-medium text-gray-700 mt-2">Sujeto ID (si aplica)</label>
                <input type="number" name="subject_id" class="mt-1 block w-full rounded-md border px-3 py-2" placeholder="ID del sujeto (ej. id de Organismo, Unidad, Dependencia, Bien o Usuario)" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <input type="text" name="tipo" class="mt-1 block w-full rounded-md border px-3 py-2" required />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" class="mt-1 block w-full rounded-md border px-3 py-2" value="{{ date('Y-m-d') }}" required />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Usuario (registró)</label>
                <select name="usuario_id" class="mt-1 block w-full rounded-md border px-3 py-2">
                    @foreach(\App\Models\Usuario::orderBy('nombre')->get() as $u)
                        <option value="{{ $u->id }}">{{ $u->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" class="mt-1 block w-full rounded-md border px-3 py-2" rows="4"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Registrar</button>
                <a href="{{ route('movimientos.index') }}" class="bg-gray-200 px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
