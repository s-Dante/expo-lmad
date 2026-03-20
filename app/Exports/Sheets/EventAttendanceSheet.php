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
use Illuminate\Support\Collection;

class EventAttendanceSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function array(): array
    {
        $rows = [];

        // Encabezados
        $rows[] = [
            'Evento',
            'Tipo Evento',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Email / Matrícula',
            'Tipo Visitante',
            'Género',
            'Carrera / Facultad',
            'Institución',
            'Rango de Edad',
            'Asistió',
            'Fecha Registro',
        ];

        foreach ($this->events as $event) {
            foreach ($event->visitantes as $visitante) {
                $rows[] = [
                    $event->titulo,
                    $event->tipo ?? 'N/A',
                    $visitante->nombre,
                    $visitante->apellido_paterno,
                    $visitante->apellido_materno ?? '',
                    $visitante->email ?? $visitante->matricula ?? 'N/A',
                    ucfirst($visitante->tipo ?? 'N/A'),
                    match ($visitante->genero ?? '') {
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                        'O' => 'No binario',
                        default => 'N/A',
                    },
                    $visitante->carrera ?? $visitante->facultad ?? 'N/A',
                    $visitante->institucion ?? 'N/A',
                    $visitante->rango_edad ?? 'N/A',
                    $visitante->pivot->asistencia ? 'Sí' : 'No',
                    $visitante->pivot->fecha_registro
                    ? \Carbon\Carbon::parse($visitante->pivot->fecha_registro)->format('d/m/Y H:i')
                    : 'N/A',
                ];
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Arial'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1565C0']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // Evento
            'B' => 16, // Tipo evento
            'C' => 20, // Nombre
            'D' => 20, // Apellido paterno
            'E' => 20, // Apellido materno
            'F' => 30, // Email/matrícula
            'G' => 16, // Tipo visitante
            'H' => 14, // Género
            'I' => 25, // Carrera
            'J' => 25, // Institución
            'K' => 14, // Rango edad
            'L' => 10, // Asistió
            'M' => 18, // Fecha
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

                // Fuente general
                $sheet->getStyle("A1:M{$lastRow}")
                    ->getFont()->setName('Arial')->setSize(10);

                // Bordes
                $sheet->getStyle("A1:M{$lastRow}")->applyFromArray([
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
                        $sheet->getStyle("A{$row}:M{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFF3F6FB');
                    }
                }

                // Colorear "Sí"/"No" en columna L
                for ($row = 2; $row <= $lastRow; $row++) {
                    $val = $sheet->getCell("L{$row}")->getValue();
                    $color = $val === 'Sí' ? 'FF1B5E20' : 'FFB71C1C';
                    $bg = $val === 'Sí' ? 'FFE8F5E9' : 'FFFFEBEE';
                    $sheet->getStyle("L{$row}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['argb' => $color]],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
                    ]);
                }

                // Autofilter
                $sheet->setAutoFilter("A1:M1");

                // Freeze pane
                $sheet->freezePane('A2');

                // Altura header
                $sheet->getRowDimension(1)->setRowHeight(22);
            },
        ];
    }

    public function title(): string
    {
        return 'Asistencias por Evento';
    }
}