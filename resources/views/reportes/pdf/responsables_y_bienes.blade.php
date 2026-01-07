@extends('reportes.pdf')

@section('contenido')
@foreach($responsables as $resp)
    <h2>{{ $resp->nombre }} ({{ $resp->cedula }})</h2>
    <p class="small">Tipo: {{ $resp->tipo->nombre ?? 'N/D' }}</p>

    <table>
        <thead>
            <tr>
                <th>Dependencia</th>
                <th>Código Bien</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        @forelse($resp->dependencias as $dep)
            @foreach($dep->bienes as $bien)
                <tr>
                    <td>{{ $dep->nombre }}</td>
                    <td>{{ $bien->codigo }}</td>
                    <td>{{ $bien->descripcion }}</td>
                    <td>{{ $bien->estado ?? '' }}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="4">Sin bienes asignados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <br>
@endforeach
@endsection
