<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatrocinadoresSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $patrocinadores;

    public function __construct($patrocinadores)
    {
        $this->patrocinadores = $patrocinadores;
    }

    public function collection()
    {
        return $this->patrocinadores->map(function ($p) {
            return [
                $p->nombre,
                $p->tier,
                $p->es_patrocinador ? 'Sí' : 'No',
                $p->website_url ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Empresa',
            'Grado/Tier',
            'Patrocinador Activo',
            'Sitio Web',
        ];
    }

    public function title(): string
    {
        return 'Patrocinadores';
    }
}
