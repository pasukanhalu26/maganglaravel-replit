<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\CapaianBulanSheet;

class CapaianExport implements WithMultipleSheets
{
    use Exportable;

    protected $dataPerBulan;
    protected $tahun;
    protected $namaProgram;

    public function __construct(array $dataPerBulan, $tahun, $namaProgram)
    {
        $this->dataPerBulan = $dataPerBulan;
        $this->tahun = $tahun;
        $this->namaProgram = $namaProgram;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->dataPerBulan as $bulan => $data) {
            $sheets[] = new CapaianBulanSheet(
                $bulan, 
                $this->tahun, 
                $this->namaProgram,
                $data['items'], 
                $data['persentase_program'] ?? null
            );
        }

        return $sheets;
    }
}
