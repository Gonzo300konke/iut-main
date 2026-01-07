@extends('reportes.pdf')

@section('contenido')
@foreach($dependencias as $dependencia)
    <h3>{{ $dependencia->nombre }} ({{ $dependencia->codigo }})</h3>
    <p class="small">
        Unidad: {{ $dependencia->unidadAdministradora->nombre ?? 'N/A' }} —
        Organismo: {{ $dependencia->unidadAdministradora->organismo->nombre ?? 'N/A' }}
    </p>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
        @forelse($dependencia->bienes as $bien)
            <tr>
                <td>{{ $bien->codigo }}</td>
                <td>{{ $bien->descripcion }}</td>
                <td>{{ $bien->estado ?? '' }}</td>
                <td style="text-align:right;">{{ number_format((float)($bien->precio ?? 0), 2, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Sin bienes registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <br>
@endforeach
@endsection
