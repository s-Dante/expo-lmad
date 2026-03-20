<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpositoresSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $conferencistas;

    public function __construct($conferencistas)
    {
        $this->conferencistas = $conferencistas;
    }

    public function collection()
    {
        return $this->conferencistas->map(function ($c) {
            return [
                $c->nombre,
                $c->apellido_paterno,
                $c->apellido_materno,
                $c->email,
                $c->empresa,
                $c->nick_name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Email',
            'Empresa/Procedencia',
            'Nickname',
        ];
    }

    public function title(): string
    {
        return 'Expositores';
    }
}
