<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use App\Models\TipoResponsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResponsableController extends Controller
{
    /**
     * Buscar responsable por cédula en el API externo o en respuesta.json
     * y guardarlo en la tabla responsables.
     */
   public function buscar(Request $request)
{
    $cedula = $request->input('cedula');

    // Cargar datos (usando tu lógica actual del JSON)
    $json = file_get_contents(storage_path('app/respuesta.json'));
    $data = json_decode($json, true);
    $persona = collect($data[0]['data'])->firstWhere('pin', $cedula);

    if (!$persona) {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'error', 'message' => 'Cédula no encontrada'], 404);
        }
        return redirect()->back()->with('error', 'No se encontró persona con esa cédula');
    }

    // Lógica de Guardado
    $tipo = TipoResponsable::firstOrCreate([
        'nombre' => implode(', ', $persona['type_str'])
    ]);

    $responsable = Responsable::updateOrCreate(
        ['cedula' => $persona['pin']],
        [
            'tipo_id'  => $tipo->id,
            'nombre'   => $persona['fullname'],
            'correo'   => null,
            'telefono' => null,
        ]
    );

    // RESPUESTA
    if ($request->expectsJson()) {
        return response()->json([
            'status' => 'ok',
            'message' => '¡Responsable registrado/actualizado con éxito!',
            'data' => [
                'nombre' => $responsable->nombre,
                'cedula' => $responsable->cedula,
                'tipo'   => $tipo->nombre
            ]
        ]);
    }

    // SI SE USA EL BOTÓN "SUBMIT" NORMAL:
    // Redirige de vuelta a la misma página (create) con un mensaje de éxito
    return redirect()->back()->with('success', 'Responsable guardado correctamente.');
}
}


