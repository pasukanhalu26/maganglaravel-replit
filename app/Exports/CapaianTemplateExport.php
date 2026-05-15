<?php

namespace App\Exports;

use App\Models\Target;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CapaianTemplateExport implements FromCollection, WithTitle, WithCustomStartCell, WithEvents, WithHeadings, WithStyles
{
    public function collection()
    {
        $targets = Target::with(['indikator', 'program', 'klaster'])->where('status', 1)->get();
        
        $data = [];
        $no = 1;
        foreach ($targets as $target) {
            $data[] = [
                'NO' => $no++,
                'INDIKATOR' => $target->indikator->nama_indikator ?? '-',
                'TARGET_TAHUNAN' => $target->target_tahunan,
                'PENCAPAIAN_BULANAN' => '',
                'PENCAPAIAN_KUMULATIF' => '',
                'PERSENTASE_KUMULATIF' => '',
                'PERSENTASE_PROGRAM' => '',
                'ANALISA_MASALAH' => '',
                'RTL' => '',
                'ID_TARGET' => $target->id_target, // Hidden in column J
            ];
        }

        return collect($data);
    }

    public function title(): string
    {
        return 'TEMPLATE INPUT';
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            ['NO.', 'INDIKATOR', 'TARGET TAHUNAN', 'PENCAPAIAN BULANAN', 'PENCAPAIAN KUMULATIF', 'PERSENTASE PENCAPAIAN KUMULATIF', 'PERSENTASE PENCAPAIAN BULANAN PROGRAM', 'ANALISA MASALAH', 'RTL', 'ID_TARGET'],
            ['1', '2', '3', '5', '6', '8', '9', '10', '11', 'HIDDEN']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A6:I7' => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFFF00']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $tahun = date('Y');

                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'PENCAPAIAN BULANAN KLASTER 2 UKM PUSKESMAS DRIYOREJO TAHUN ' . $tahun);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $sheet->setCellValue('B3', 'BULAN');
                $sheet->setCellValue('C3', ': ....................');
                
                $sheet->setCellValue('B4', 'PROGRAM');
                $sheet->setCellValue('C4', ': SEMUA PROGRAM AKTIF');
                
                $sheet->getStyle('B3:B4')->getFont()->setBold(true);

                $sheet->getRowDimension(6)->setRowHeight(45);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(45);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(14);
                $sheet->getColumnDimension('E')->setWidth(14);
                $sheet->getColumnDimension('F')->setWidth(16);
                $sheet->getColumnDimension('G')->setWidth(18);
                $sheet->getColumnDimension('H')->setWidth(35);
                $sheet->getColumnDimension('I')->setWidth(35);
                
                // Hide ID_TARGET column
                $sheet->getColumnDimension('J')->setVisible(false);

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 8) {
                    $sheet->getStyle('A8:I' . $highestRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ],
                    ]);

                    $sheet->getStyle('A8:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C8:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    
                    // Highlight editable columns: D (Pencapaian Bulanan), H (Analisa), I (RTL)
                    $sheet->getStyle('D8:D' . $highestRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
                    $sheet->getStyle('H8:I' . $highestRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2EFDA');
                }

                // Add Signature and Footer Information
                $nextRow = $highestRow + 3;
                
                $sheet->setCellValue('H' . $nextRow, 'Mengetahui');
                $sheet->getStyle('H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $nextRow++;
                $sheet->setCellValue('B' . $nextRow, 'KETERANGAN :');
                $sheet->getStyle('B' . $nextRow)->getFont()->setBold(true);

                $sheet->setCellValue('H' . $nextRow, 'Penanggungjawab Program');
                $sheet->getStyle('H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $nextRow++;
                $nextRow++;
                $sheet->setCellValue('B' . $nextRow, 'KOLOM YANG DIISI HANYA YANG BEWARNA HIJAU');
                $sheet->getStyle('B' . $nextRow)->getFont()->setBold(true);

                $nextRow++;
                $sheet->setCellValue('B' . $nextRow, '1. KOLOM NOMOR 5 (PENCAPAIAN BULANAN)');
                $sheet->getStyle('B' . $nextRow)->getFont()->setBold(true);

                $nextRow++;
                $sheet->setCellValue('B' . $nextRow, '2. KOLOM 10 - 11 (ANALISA MASALAH DAN RTL)');
                $sheet->getStyle('B' . $nextRow)->getFont()->setBold(true);

                $sheet->setCellValue('H' . $nextRow, "dr. Indah Chumaidiyah Ma'rifah");
                $sheet->getStyle('H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $nextRow)->getFont()->setUnderline(true)->setBold(true);

                $nextRow++;
                $sheet->setCellValue('H' . $nextRow, 'NIP.19910511 2022032 006');
                $sheet->getStyle('H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
