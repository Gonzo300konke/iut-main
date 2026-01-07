@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            <th>Fecha eliminación</th>
            <th>Tipo de modelo</th>
            <th>ID</th>
            <th>Eliminado por</th>
        </tr>
    </thead>
    <tbody>
    @forelse($eliminados as $item)
        <tr>
            <td>{{ optional($item->deleted_at)->format('d/m/Y H:i') }}</td>
            <td>{{ class_basename($item->model_type) }}</td>
            <td>{{ $item->model_id }}</td>
            <td>{{ $item->deleted_by ?? ($item->data['_archived_by'] ?? 'N/D') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No hay registros eliminados para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
