<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ResumenEventosSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = [
            'Evento',
            'Tipo',
            'Registrados',
            'Asistieron',
            '% Asistencia',
            'Estudiantes',
            'Externos',
            'Masculino',
            'Femenino',
            'No Binario',
        ];

        foreach ($this->events as $event) {
            $visitantes = $event->visitantes;
            $registrados = $visitantes->count();
            $asistieron = $visitantes->filter(fn($v) => $v->pivot->asistencia)->count();

            $rows[] = [
                $event->titulo,
                $event->tipo instanceof \BackedEnum ? $event->tipo->value : (string) ($event->tipo ?? 'N/A'),
                $registrados,
                $asistieron,
                $registrados > 0 ? round($asistieron / $registrados, 4) : 0,
                $visitantes->where('tipo', 'estudiante')->count(),
                $visitantes->where('tipo', 'externo')->count(),
                $visitantes->where('genero', 'M')->count(),
                $visitantes->where('genero', 'F')->count(),
                $visitantes->where('genero', 'O')->count(),
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Arial'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF00695C']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 32,
            'B' => 16,
            'C' => 14,
            'D' => 14,
            'E' => 16,
            'F' => 14,
            'G' => 14,
            'H' => 14,
            'I' => 14,
            'J' => 14,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                if ($lastRow < 2)
                    return;

                $sheet->getStyle("A1:J{$lastRow}")
                    ->getFont()->setName('Arial')->setSize(10);

                // Formato porcentaje columna E
                $sheet->getStyle("E2:E{$lastRow}")
                    ->getNumberFormat()->setFormatCode('0.0%');

                // Formato número columnas C,D,F-J
                $sheet->getStyle("C2:J{$lastRow}")
                    ->getNumberFormat()->setFormatCode('#,##0');

                // Bordes
                $sheet->getStyle("A1:J{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFB0BEC5'],
                        ],
                    ],
                ]);

                // Filas alternas
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:J{$row}")
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFF1F8F7');
                    }
                }

                $sheet->setAutoFilter("A1:J1");
                $sheet->freezePane('A2');
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Alineación centrada en números
                $sheet->getStyle("B1:J{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function title(): string
    {
        return 'Resumen por Evento';
    }
}