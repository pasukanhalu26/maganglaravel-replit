<table>
    <thead>
        <tr>
            <th colspan="9" style="font-weight: bold; text-align: center;">LAPORAN CAPAIAN KINERJA PUSKESMAS</th>
        </tr>
        <tr>
            <th colspan="9" style="text-align: center;">Tanggal: <?php echo e(date('d-m-Y')); ?></th>
        </tr>
        <tr></tr>
        <tr>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Klaster</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Program</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Indikator</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Desa</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Bulan</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Target Bulanan</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Capaian Bulanan</th>
            <th style="background-color: #f2f2f2; font-weight: bold; border: 1px solid #000;">Persentase</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $targetTahunan = $item->target->target_tahunan ?? 0;
            $targetBulanan = $targetTahunan / 12;
            $capaian = $item->capaian_bulan ?? 0;
            $persen = $targetBulanan > 0 ? ($capaian / $targetBulanan) * 100 : 0;
            $bulans = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        ?>
        <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($item->target->klaster->nama_klaster ?? '-'); ?></td>
            <td><?php echo e($item->target->program->nama_program ?? '-'); ?></td>
            <td><?php echo e($item->target->indikator->nama_indikator ?? '-'); ?></td>
            <td><?php echo e($item->desa->nama_desa ?? '-'); ?></td>
            <td><?php echo e($bulans[$item->bulan] ?? $item->bulan); ?></td>
            <td><?php echo e(number_format($targetBulanan, 2)); ?></td>
            <td><?php echo e($capaian); ?></td>
            <td><?php echo e(number_format($persen, 2)); ?>%</td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\laragon\www\maganglaravel\resources\views/capaian/excel_baru.blade.php ENDPATH**/ ?>