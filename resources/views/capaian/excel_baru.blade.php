<table>
    <thead>
        <tr>
            <th colspan="9" style="font-weight: bold; text-align: center;">LAPORAN CAPAIAN KINERJA PUSKESMAS</th>
        </tr>
        <tr>
            <th colspan="9" style="text-align: center;">Tanggal: {{ date('d-m-Y') }}</th>
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
        @foreach($data as $index => $item)
        @php
            $targetTahunan = $item->target->target_tahunan ?? 0;
            $targetBulanan = $targetTahunan / 12;
            $capaian = $item->capaian_bulan ?? 0;
            $persen = $targetBulanan > 0 ? ($capaian / $targetBulanan) * 100 : 0;
            $bulans = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        @endphp
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->target->klaster->nama_klaster ?? '-' }}</td>
            <td>{{ $item->target->program->nama_program ?? '-' }}</td>
            <td>{{ $item->target->indikator->nama_indikator ?? '-' }}</td>
            <td>{{ $item->desa->nama_desa ?? '-' }}</td>
            <td>{{ $bulans[$item->bulan] ?? $item->bulan }}</td>
            <td>{{ number_format($targetBulanan, 2) }}</td>
            <td>{{ $capaian }}</td>
            <td>{{ number_format($persen, 2) }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>
