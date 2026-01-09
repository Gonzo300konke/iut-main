<?php

namespace App\Services;

class FpdfReportService
{
    /**
     * Crear una instancia base de FPDF lista para escribir.
     */
    protected function make(string $orientation = 'L'): \FPDF
    {
        $pdf = new \FPDF($orientation, 'mm', 'Letter');
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();

        return $pdf;
    }

    protected function header(\FPDF $pdf, string $title, ?string $subtitle, string $generatedAt): void
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, $this->t($title), 0, 1, 'C');

        if ($subtitle) {
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(0, 6, $this->t($subtitle), 0, 1, 'C');
        }

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, $this->t('Generado el '.$generatedAt), 0, 1, 'R');
        $pdf->Ln(3);
    }

    /**
     * Reporte tabular genérico de bienes (inventario, filtros por estado, etc.).
     *
     * @param iterable $bienes Colección de App\Models\Bien ya cargada con sus relaciones.
     */
    public function downloadBienesListado(
        string $fileName,
        string $title,
        ?string $subtitle,
        string $generatedAt,
        iterable $bienes
    ) {
        $pdf = $this->make('L');
        $this->header($pdf, $title, $subtitle, $generatedAt);

        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 9);
        $widths = [25, 80, 20, 40, 40, 40, 25];
        $headers = ['Código', 'Descripción', 'Estado', 'Dependencia', 'Unidad', 'Organismo', 'Precio'];

        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 7, $this->t($header), 1, 0, 'C');
        }
        $pdf->Ln();

        // Filas
        $pdf->SetFont('Arial', '', 8);

        foreach ($bienes as $bien) {
            $row = [
                (string) ($bien->codigo ?? ''),
                $this->truncate((string) ($bien->descripcion ?? ''), 70),
                (string) ($bien->estado instanceof \App\Enums\EstadoBien ? $bien->estado->label() : ($bien->estado ?? '')),
                (string) optional($bien->dependencia)->nombre,
                (string) optional(optional($bien->dependencia)->unidadAdministradora)->nombre,
                (string) optional(optional(optional($bien->dependencia)->unidadAdministradora)->organismo)->nombre,
                number_format((float) ($bien->precio ?? 0), 2, ',', '.'),
            ];

            foreach ($row as $i => $text) {
                $align = $i === 6 ? 'R' : 'L';
                $pdf->Cell($widths[$i], 6, $this->t((string) $text), 1, 0, $align);
            }
            $pdf->Ln();
        }

        if (! isset($bien)) {
            // Colección vacía
            $pdf->Cell(array_sum($widths), 6, $this->t('No hay datos para mostrar.'), 1, 1, 'C');
        }

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }

    protected function t(string $text): string
    {
        // FPDF usa ISO-8859-1 por defecto; convertimos desde UTF-8.
        return utf8_decode($text);
    }

    protected function truncate(string $text, int $limit): string
    {
        if (mb_strlen($text, 'UTF-8') <= $limit) {
            return $text;
        }

        return mb_substr($text, 0, $limit, 'UTF-8').'…';
    }
}
