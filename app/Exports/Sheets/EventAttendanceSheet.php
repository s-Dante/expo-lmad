<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EventAttendanceSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function collection()
    {
        $rows = [];
        foreach ($this->events as $event) {
            foreach ($event->visitantes as $visitante) {
                $rows[] = [
                    $event->titulo,
                    $event->tipo,
                    $visitante->nombre,
                    $visitante->apellido_paterno,
                    $visitante->apellido_materno,
                    $visitante->email ?? $visitante->matricula ?? 'N/A',
                    $visitante->tipo,
                    $visitante->pivot->asistencia ? 'Sí' : 'No',
                    $visitante->pivot->fecha_registro,
                ];
            }
        }
        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'Evento',
            'Tipo Evento',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Email/Matrícula',
            'Tipo Visitante',
            'Asistió',
            'Fecha Registro',
        ];
    }

    public function title(): string
    {
        return 'Asistencias por Evento';
    }
}
