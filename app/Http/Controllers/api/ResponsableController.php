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

        $json = file_get_contents(storage_path('app/respuesta.json'));
        $data = json_decode($json, true);

        if (empty($data[0]['data'])) {
            return response()->json(['error' => 'No se encontró persona'], 404);
        }

        // 🔹 Buscar la persona que tenga el pin igual a la cédula ingresada
        $persona = collect($data[0]['data'])->firstWhere('pin', $cedula);

        if (!$persona) {
            return redirect()->back()->with('error', 'No se encontró persona con esa cédula');
        }


        // Crear o buscar tipo_responsable
        $tipo = TipoResponsable::firstOrCreate([
            'nombre' => implode(', ', $persona['type_str'])
        ]);

        // Crear o actualizar responsable
        $responsable = Responsable::updateOrCreate(
            ['cedula' => $persona['pin']],
            [
                'tipo_id'  => $tipo->id,
                'nombre'   => $persona['fullname'],
                'correo'   => null,
                'telefono' => null,
            ]
        );

        return redirect()->route('responsables.create')
        ->with('success', 'Responsable registrado correctamente');


        }
}


