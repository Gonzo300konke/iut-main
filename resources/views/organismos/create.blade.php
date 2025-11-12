@extends('layouts.base')

@section('title', 'Crear Organismo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Organismo</h1>
            
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-100 border border-red-300 p-4">
                    <ul class="text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('organismos.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" 
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                    @error('codigo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                    @error('nombre')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Guardar
                    </button>
                    <a href="{{ route('organismos.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
