@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre completo</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Activo</th>
            <th>Es admin</th>
        </tr>
    </thead>
    <tbody>
    @forelse($usuarios as $user)
        <tr>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->nombre_completo }}</td>
            <td>{{ $user->correo }}</td>
            <td>{{ $user->rol->nombre ?? 'N/D' }}</td>
            <td>{{ $user->activo ? 'Sí' : 'No' }}</td>
            <td>{{ $user->is_admin ? 'Sí' : 'No' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No hay usuarios para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
