<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DashboardExport implements WithMultipleSheets
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new Sheets\SummarySheet($this->data['summary']),
            new Sheets\ResumenEventosSheet($this->data['events']),   // ← nueva
            new Sheets\EventAttendanceSheet($this->data['events']),
            new Sheets\ExpositoresSheet($this->data['conferencistas']),
            new Sheets\PatrocinadoresSheet($this->data['patrocinadores']),
        ];
    }
}