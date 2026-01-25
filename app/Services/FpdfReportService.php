<?php

namespace App\Services;

use FPDF;

class FpdfReportService
{
    /**
     * Crear una instancia base de FPDF en formato Vertical (P).
     */
    protected function make(string $orientation = 'P'): FPDF
    {
        $pdf = new FPDF($orientation, 'mm', 'Letter');
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        return $pdf;
    }

    protected function renderHeader(FPDF $pdf, string $title, ?string $subtitle, string $generatedAt): void
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
     * Genera el listado de bienes en formato vertical.
     */
    public function downloadBienesListado(
        string $fileName,
        string $title,
        ?string $subtitle,
        string $generatedAt,
        iterable $bienes
    ) {
        $pdf = $this->make('P');
        $this->renderHeader($pdf, $title, $subtitle, $generatedAt);

        $widths = [20, 45, 22, 30, 30, 28, 20];
        $headers = ['Cod.', 'Descripción', 'Estado', 'Dep.', 'Unid.', 'Org.', 'Precio'];

        // Encabezado
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Arial', 'B', 8);
        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 7, $this->t($header), 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Datos
        $pdf->SetFont('Arial', '', 7);
        $hasData = false;
        foreach ($bienes as $bien) {
            $hasData = true;
            $estadoStr = $bien->estado instanceof \App\Enums\EstadoBien
                ? $bien->estado->label()
                : (string)$bien->estado;

            $pdf->Cell($widths[0], 6, $this->t((string)($bien->codigo ?? '')), 1);
            $pdf->Cell($widths[1], 6, $this->t($this->truncate((string)($bien->descripcion ?? ''), 30)), 1);
            $pdf->Cell($widths[2], 6, $this->t($estadoStr), 1, 0, 'C');
            $pdf->Cell($widths[3], 6, $this->t($this->truncate(optional($bien->dependencia)->nombre ?? '', 18)), 1);
            $pdf->Cell($widths[4], 6, $this->t($this->truncate(optional($bien->dependencia->unidadAdministradora)->nombre ?? '', 18)), 1);
            $pdf->Cell($widths[5], 6, $this->t($this->truncate(optional($bien->dependencia->unidadAdministradora->organismo)->nombre ?? '', 18)), 1);
            $pdf->Cell($widths[6], 6, number_format((float)($bien->precio ?? 0), 2, ',', '.'), 1, 1, 'R');
        }

        if (!$hasData) {
            $pdf->Cell(array_sum($widths), 10, $this->t('No se encontraron bienes con los filtros seleccionados.'), 1, 1, 'C');
        }

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }

    protected function t(string $text): string
    {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
    }

    protected function truncate(string $text, int $limit): string
    {
        return mb_strlen($text, 'UTF-8') <= $limit
            ? $text
            : mb_substr($text, 0, $limit, 'UTF-8').'...';
    }
}
