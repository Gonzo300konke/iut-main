@extends('layouts.base')

@section('title', 'Desincorporar Bien')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-5">
            <h1 class="text-xl font-bold text-white flex items-center gap-2">
                <x-heroicon-o-document-minus class="w-5 h-5 text-red-100" />
                Desincorporar Bien
            </h1>
            <p class="text-red-100 text-xs mt-1 opacity-90">
                Por favor, complete los campos requeridos para desincorporar este bien.
            </p>
        </div>

        {{-- Formulario - Se agregó 'novalidate' para evitar el mensaje en inglés del navegador --}}
        <form action="{{ route('bienes.desincorporar', $bien->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8" novalidate>
            @csrf
            @method('POST')

            {{-- Motivo de Desincorporación --}}
            <div class="space-y-4">
                <label for="motivo" class="block text-sm font-bold text-gray-700 mb-2">Motivo de Desincorporación</label>
                <textarea name="motivo" id="motivo" rows="3" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition @error('motivo') border-red-500 @enderror"
                    placeholder="Describa el motivo de la desincorporación...">{{ old('motivo') }}</textarea>

                @error('motivo')
                    <p class="text-red-500 text-xs mt-1">El motivo de desincorporación es obligatorio.</p>
                @enderror
            </div>

            {{-- Subir Acta de Desincorporación --}}
            <div class="space-y-4">
                <label for="acta_desincorporacion" class="block text-sm font-bold text-gray-700 mb-2">Acta de Desincorporación</label>
                <input type="file" name="acta_desincorporacion" id="acta_desincorporacion" accept="application/pdf" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none @error('acta_desincorporacion') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Suba el acta en formato PDF (máximo 2MB).</p>

                @error('acta_desincorporacion')
                    <p class="text-red-500 text-xs mt-1">Debe adjuntar el acta en formato PDF (máximo 2MB).</p>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="flex justify-end gap-4 pt-8 border-t border-gray-100">
                <a href="{{ route('bienes.show', $bien->id) }}"
                    class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-200 hover:bg-red-700 transition">
                    Confirmar Desincorporación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
