<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\CapaianBulanSheet;

class LaporanMasterExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        // $data here is the collection from getAggregatedData()
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $tahuns = collect($this->data)->pluck('target.periode')->unique()->filter()->values();
        $tahun = count($tahuns) > 0 ? $tahuns[0] : date('Y');
        
        $bulansArr = [1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',5=>'MEI',6=>'JUNI',
                      7=>'JULI',8=>'AGUSTUS',9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'];

        // Group the aggregated data by bulan
        $groupedByBulan = collect($this->data)->groupBy('bulan');

        foreach ($groupedByBulan as $bulanVal => $itemsBulan) {
            $namaBulan = $bulansArr[$bulanVal] ?? 'BULAN ' . $bulanVal;
            
            // Further group by program to calculate program percentage
            foreach ($itemsBulan->groupBy(function($item) { return $item->target->program->nama_program ?? 'Program Lainnya'; }) as $namaProgram => $items) {
                
                $totalTarget = $items->sum(function($item) { return $item->target->target_tahunan ?? 0; });
                $totalCapaian = $items->sum('capaian_bulan');
                $persenProgram = $totalTarget > 0 ? ($totalCapaian / $totalTarget) : 0;
                
                // Format the items to pass to CapaianBulanSheet
                $formattedItems = [];
                $index = 1;
                foreach ($items as $item) {
                    $formattedItems[] = [
                        $index++,
                        $item->target->indikator->nama_indikator ?? '-',
                        $item->target->target_tahunan ?? 0,
                        $item->capaian_bulan,
                        $item->capaian_kumulatif,
                        $item->persen_kumulatif / 100, // Sheet format expects decimal for percentage
                        null, // Program percentage is merged in column G
                        $item->analisa_masalah,
                        $item->rtl
                    ];
                }

                $sheets[] = new CapaianBulanSheet(
                    $namaBulan, 
                    $tahun, 
                    $namaProgram,
                    $formattedItems, 
                    $persenProgram
                );
            }
        }

        return $sheets;
    }
}
