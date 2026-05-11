<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SummarySheet implements FromArray, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected array $summary;

    public function __construct(array $summary)
    {
        $this->summary = $summary;
    }

    public function array(): array
    {
        $total = $this->summary['total_asistentes'] ?: 1;

        return [
            // Fila de título principal (se fusionará via evento)
            ['REPORTE GENERAL — ExpoLMAD', '', ''],
            ['Generado el: ' . now()->format('d/m/Y H:i'), '', ''],
            ['', '', ''],

            // Encabezados de sección
            ['MÉTRICA', 'VALOR', '% DEL TOTAL'],

            // Datos
            ['Total de Asistentes', $this->summary['total_asistentes'], '=B5/B5'],
            ['Estudiantes UANL', $this->summary['total_estudiantes'], '=B6/B5'],
            ['Visitantes Externos', $this->summary['total_externos'], '=B7/B5'],
            ['', '', ''],
            ['Total de Eventos', $this->summary['total_eventos'], ''],
            ['Total de Expositores', $this->summary['total_conferencistas'], ''],
            ['Total de Patrocinadores', $this->summary['total_patrocinadores'], ''],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Título
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1A237E']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Subtítulo fecha
            2 => [
                'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF757575']],
            ],
            // Encabezados de columna
            4 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF283593']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 18,
            'C' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Fusionar título
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');

                // Formato porcentaje en columna C
                $sheet->getStyle('C5:C7')
                    ->getNumberFormat()
                    ->setFormatCode('0.0%');

                // Formato número entero en columna B
                $sheet->getStyle('B5:B11')
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Bordes en tabla de datos
                $sheet->getStyle('A4:C11')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFB0BEC5'],
                        ],
                    ],
                ]);

                // Filas alternas con color suave
                foreach ([5, 7, 9, 11] as $row) {
                    $sheet->getStyle("A{$row}:C{$row}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FFF5F5F5');
                }

                // Alineación centrada en B y C
                $sheet->getStyle('B4:C11')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Altura de filas
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(4)->setRowHeight(20);

                // Fuente general
                $sheet->getStyle('A1:C11')
                    ->getFont()
                    ->setName('Arial');
            },
        ];
    }

    public function title(): string
    {
        return 'Resumen General';
    }
}