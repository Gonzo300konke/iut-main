@extends('reportes.pdf')

@section('contenido')
@foreach($organismos as $organismo)
    <h2>{{ $organismo->nombre }} ({{ $organismo->codigo }})</h2>

    @foreach($organismo->unidadesAdministradoras as $unidad)
        <h3>Unidad: {{ $unidad->nombre }} ({{ $unidad->codigo }})</h3>

        @foreach($unidad->dependencias as $dependencia)
            <h4>Dependencia: {{ $dependencia->nombre }} ({{ $dependencia->codigo }})</h4>
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
                        <td colspan="4">Sin bienes en esta dependencia.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <br>
        @endforeach
    @endforeach
@endforeach
@endsection
