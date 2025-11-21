@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Bienvenido, {{ auth()->user()->nombre }}</h1>

        @if(auth()->user()->isAdmin())
            <p class="text-gray-600">Panel de administrador: acceso completo al sistema.</p>
        @else
            <p class="text-gray-600">Panel de usuario: acceso limitado a bienes.</p>
        @endif
    </div>
@endsection
