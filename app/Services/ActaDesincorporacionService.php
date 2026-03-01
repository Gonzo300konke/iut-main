<?php

namespace App\Services;

use App\Models\Bien;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class ActaDesincorporacionService
{
    public function generar(Bien $bien, string $motivo, $usuario)
    {
        $data = [
            'bien'        => $bien,
            'motivo'      => $motivo,
            'fecha'       => Carbon::now()->format('d/m/Y'),
            'hora'        => Carbon::now()->format('H:i'),
            'usuario'     => $usuario->name ?? auth()->user()?->name ?? 'Usuario del sistema',
            'responsable' => $bien->dependencia?->responsable?->nombre_completo ?? '—',
            'dependencia' => $bien->dependencia?->nombre ?? '—',
            'folio'       => 'DES-' . now()->format('Y') . '-' . str_pad($bien->id, 6, '0', STR_PAD_LEFT),
        ];

        $pdf = Pdf::loadView('bienes.pdf.acta-desincorporacion', $data);

        // Opción 1: Descargar directamente
        return $pdf->download('acta-desincorporacion-' . $bien->codigo . '.pdf');

        // Opción 2: Mostrar en navegador (para pruebas)
        // return $pdf->stream('acta-desincorporacion-' . $bien->codigo . '.pdf');
    }
}
