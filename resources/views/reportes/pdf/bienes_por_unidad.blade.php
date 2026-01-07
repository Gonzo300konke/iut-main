@extends('reportes.pdf')

@section('contenido')
@foreach($unidades as $unidad)
    <h2>{{ $unidad->nombre }} ({{ $unidad->codigo }})</h2>
    <p class="small">Organismo: {{ $unidad->organismo->nombre ?? 'N/A' }}</p>

    @foreach($unidad->dependencias as $dependencia)
        <h3>Dependencia: {{ $dependencia->nombre }} ({{ $dependencia->codigo }})</h3>
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
@endsection
