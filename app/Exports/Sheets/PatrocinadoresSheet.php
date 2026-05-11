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

class PatrocinadoresSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $patrocinadores;

    public function __construct($patrocinadores)
    {
        $this->patrocinadores = $patrocinadores;
    }

    public function array(): array
    {
        $rows = [];
        $rows[] = ['Empresa', 'Grado/Tier', 'Patrocinador Activo', 'Sitio Web'];

        foreach ($this->patrocinadores as $p) {
            $rows[] = [
                $p->nombre,
                $p->tier ?? 'N/A',
                $p->es_patrocinador ? 'Sí' : 'No',
                $p->website_url ?? 'N/A',
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Arial'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE65100']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 16, 'C' => 20, 'D' => 40];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                if ($lastRow < 2)
                    return;

                $sheet->getStyle("A1:D{$lastRow}")->getFont()->setName('Arial')->setSize(10);

                $sheet->getStyle("A1:D{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFB0BEC5']]],
                ]);

                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:D{$row}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF3E0');
                    }

                    $val = $sheet->getCell("C{$row}")->getValue();
                    $sheet->getStyle("C{$row}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['argb' => $val === 'Sí' ? 'FF1B5E20' : 'FF757575']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $val === 'Sí' ? 'FFE8F5E9' : 'FFF5F5F5']],
                    ]);
                }

                $sheet->setAutoFilter("A1:D1");
                $sheet->freezePane('A2');
                $sheet->getRowDimension(1)->setRowHeight(22);
            },
        ];
    }

    public function title(): string
    {
        return 'Patrocinadores';
    }
}