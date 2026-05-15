<!DOCTYPE html>
<html>
<head>
    <title>Laporan Capaian</title>
    <style>
        @page { size: A4 landscape; margin: 15px; }
        body { font-family: sans-serif; font-size: 8pt; color: #000; }
        .header-title { text-align: center; font-weight: bold; font-size: 10pt; margin-bottom: 20px; text-transform: uppercase; }
        .info-table { width: auto; margin-bottom: 10px; font-weight: bold; font-size: 9pt; }
        .info-table td { padding: 2px 5px; border: none; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; page-break-inside: auto; }
        table.data-table tr { page-break-inside: avoid; page-break-after: auto; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        table.data-table th { background-color: #FFFF00; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 8pt; }
        
        .bg-green { background-color: #92D050; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer-sig { width: 300px; margin-left: auto; text-align: center; font-size: 9pt; margin-top: 30px; }
        .footer-info { margin-top: 10px; font-weight: bold; font-size: 8pt; }
        .footer-info .red-text { color: red; }
    </style>
</head>
<body>
    <?php
        $tahuns = $data->pluck('target.periode')->unique()->filter()->values();
        $tahunTampil = count($tahuns) > 0 ? $tahuns[0] : date('Y');
        
        $bulansArr = [1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',5=>'MEI',6=>'JUNI',
                      7=>'JULI',8=>'AGUSTUS',9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'];
    ?>

    <div class="header-title">
        PENCAPAIAN BULANAN KLASTER 2 UKM PUSKESMAS DRIYOREJO TAHUN <?php echo e($tahunTampil); ?>

    </div>

    <?php $__currentLoopData = $data->groupBy('bulan'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulanVal => $itemsByBulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $namaBulan = $bulansArr[$bulanVal] ?? 'BULAN ' . $bulanVal;
        ?>

        <?php $__currentLoopData = $itemsByBulan->groupBy(function($item) { return $item->target->program->nama_program ?? 'Program Lainnya'; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namaProgram => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $totalTarget = $items->sum(function($item) { return $item->target->target_tahunan ?? 0; });
                $totalCapaian = $items->sum('capaian_bulan');
                $persenProgram = $totalTarget > 0 ? ($totalCapaian / $totalTarget) * 100 : 0;
            ?>
            
            <table class="info-table">
                <tr>
                    <td style="width: 100px;">BULAN</td>
                    <td>: <?php echo e($namaBulan); ?></td>
                </tr>
                <tr>
                    <td>PROGRAM</td>
                    <td>: <?php echo e(strtoupper($namaProgram)); ?></td>
                </tr>
            </table>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">NO.</th>
                        <th>INDIKATOR</th>
                        <th style="width: 60px;">TARGET<br>TAHUNAN</th>
                        <th style="width: 70px;">PENCAPAIAN<br>BULANAN</th>
                        <th style="width: 70px;">PENCAPAIAN<br>KUMULATIF</th>
                        <th style="width: 70px;">PERSENTASE<br>PENCAPAIAN<br>KUMULATIF</th>
                        <th style="width: 80px;">PERSENTASE<br>PENCAPAIAN<br>BULANAN<br>PROGRAM</th>
                        <th style="width: 150px;">ANALISA MASALAH</th>
                        <th style="width: 150px;">RTL</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>5</th>
                        <th>6</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $target = $item->target->target_tahunan ?? 0;
                            $capaian_bulanan = $item->capaian_bulan ?? 0;
                            $kumulatif = $item->capaian_kumulatif ?? 0;
                            $persenKumulatif = $item->persen_kumulatif ?? 0;
                            
                            $analisaMasalah = $item->analisa_masalah;
                            $rtl = $item->rtl;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($item->target->indikator->nama_indikator ?? '-'); ?></td>
                            <td class="text-center"><?php echo e(number_format($target)); ?></td>
                            <td class="text-center bg-green"><?php echo e(number_format($capaian_bulanan)); ?></td>
                            <td class="text-center"><?php echo e(number_format($kumulatif)); ?></td>
                            <td class="text-center"><?php echo e(number_format($persenKumulatif, 0)); ?>%</td>
                            
                            <?php if($index === 0): ?>
                                <td class="text-center" rowspan="<?php echo e(count($items)); ?>" style="vertical-align: middle;">
                                    <?php echo e(number_format($persenProgram, 2)); ?>%
                                </td>
                            <?php endif; ?>
                            
                            <td class="bg-green"><?php echo e($analisaMasalah); ?></td>
                            <td class="bg-green"><?php echo e($rtl); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer-info">
        <div>KETERANGAN :</div>
        <div class="red-text">KOLOM YANG DIISI HANYA YANG BEWARNA HIJAU</div>
        <div>1. KOLOM NOMOR 5 (PENCAPAIAN BULANAN)</div>
        <div>2. KOLOM 10 - 11 (ANALISA MASALAH DAN RTL)</div>
    </div>

    <div class="footer-sig">
        <p>Mengetahui</p>
        <p>Penanggungjawab Program</p>
        <br><br><br>
        <p style="text-decoration: underline; font-weight: bold; margin-bottom: 2px;">dr. Indah Chumaidiyah Ma'rifah</p>
        <p style="margin-top: 0;">NIP.19910511 2022032 006</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\maganglaravel\resources\views/capaian/pdf_baru.blade.php ENDPATH**/ ?>