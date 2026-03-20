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

class ExpositoresSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $conferencistas;

    public function __construct($conferencistas)
    {
        $this->conferencistas = $conferencistas;
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = ['Nombre', 'Apellido Paterno', 'Apellido Materno', 'Email', 'Empresa/Procedencia', 'Nickname', 'Estatus'];

        foreach ($this->conferencistas as $c) {
            $rows[] = [
                $c->nombre,
                $c->apellido_paterno,
                $c->apellido_materno ?? '',
                $c->email,
                $c->empresa ?? 'N/A',
                $c->nick_name ?? 'N/A',
                $c->estatus ? 'Activo' : 'Inactivo',
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Arial'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4527A0']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 20, 'B' => 20, 'C' => 20, 'D' => 30, 'E' => 25, 'F' => 18, 'G' => 12];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                if ($lastRow < 2)
                    return;

                $sheet->getStyle("A1:G{$lastRow}")->getFont()->setName('Arial')->setSize(10);

                $sheet->getStyle("A1:G{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFB0BEC5']]],
                ]);

                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:G{$row}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF3EEF9');
                    }

                    $val = $sheet->getCell("G{$row}")->getValue();
                    $sheet->getStyle("G{$row}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['argb' => $val === 'Activo' ? 'FF1B5E20' : 'FF757575']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $val === 'Activo' ? 'FFE8F5E9' : 'FFF5F5F5']],
                    ]);
                }

                $sheet->setAutoFilter("A1:G1");
                $sheet->freezePane('A2');
                $sheet->getRowDimension(1)->setRowHeight(22);
            },
        ];
    }

    public function title(): string
    {
        return 'Expositores';
    }
}