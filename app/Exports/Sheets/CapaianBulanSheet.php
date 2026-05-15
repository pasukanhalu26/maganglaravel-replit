<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CapaianBulanSheet implements FromCollection, WithTitle, WithCustomStartCell, WithEvents, WithColumnFormatting, WithHeadings, WithStyles
{
    protected $bulan;
    protected $tahun;
    protected $namaProgram;
    protected $data;
    protected $persentaseProgram;

    public function __construct($bulan, $tahun, $namaProgram, $data, $persentaseProgram)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->namaProgram = $namaProgram;
        $this->data = $data;
        $this->persentaseProgram = $persentaseProgram;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function title(): string
    {
        return strtoupper($this->bulan . ' ' . $this->tahun);
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            ['NO.', 'INDIKATOR', 'TARGET TAHUNAN', 'PENCAPAIAN BULANAN', 'PENCAPAIAN KUMULATIF', 'PERSENTASE PENCAPAIAN KUMULATIF', 'PERSENTASE PENCAPAIAN BULANAN PROGRAM', 'ANALISA MASALAH', 'RTL'],
            ['1', '2', '3', '5', '6', '8', '9', '10', '11']
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

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_PERCENTAGE,
            'G' => NumberFormat::FORMAT_PERCENTAGE_00,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'PENCAPAIAN BULANAN KLASTER 2 UKM PUSKESMAS DRIYOREJO TAHUN ' . $this->tahun);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $sheet->setCellValue('B3', 'BULAN');
                $sheet->setCellValue('C3', ': ' . strtoupper($this->bulan));
                
                $sheet->setCellValue('B4', 'PROGRAM');
                $sheet->setCellValue('C4', ': ' . strtoupper($this->namaProgram));
                
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
                    
                    if ($this->persentaseProgram !== null && $this->persentaseProgram !== 0) {
                        $sheet->mergeCells("G8:G{$highestRow}");
                        $sheet->setCellValue('G8', $this->persentaseProgram);
                    }

                    for ($row = 8; $row <= $highestRow; $row++) {
                        $analisa = $sheet->getCell('H' . $row)->getValue();
                        
                        if (strtolower(trim($analisa)) === 'tercapai') {
                            $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
                            $sheet->getStyle("H{$row}:I{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
                        }
                    }

                    // Add Signature and Footer Information
                    $highestRow = $sheet->getHighestRow();
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
                }
            },
        ];
    }
}
