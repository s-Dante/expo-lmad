<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class SummarySheet implements FromCollection, WithTitle, WithHeadings
{
    protected array $summary;

    public function __construct(array $summary)
    {
        $this->summary = $summary;
    }

    public function collection()
    {
        return new Collection([
            ['Total de Asistentes', $this->summary['total_asistentes']],
            ['Estudiantes UANL', $this->summary['total_estudiantes']],
            ['Visitantes Externos', $this->summary['total_externos']],
            ['Total de Eventos', $this->summary['total_eventos']],
            ['Total de Conferencistas', $this->summary['total_conferencistas']],
            ['Total de Patrocinadores', $this->summary['total_patrocinadores']],
        ]);
    }

    public function headings(): array
    {
        return ['Métrica', 'Valor'];
    }

    public function title(): string
    {
        return 'Resumen General';
    }
}
