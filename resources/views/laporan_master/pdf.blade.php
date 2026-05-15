<!DOCTYPE html>
<html>
<head>
    <title>Laporan Capaian</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN CAPAIAN PUSKESMAS</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Indikator</th>
                <th>Desa</th>
                <th>Bulan</th>
                <th>Target</th>
                <th>Capaian</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            @php
                $target = $item->target->target_tahunan ?? 0;
                $capaian = $item->capaian_bulan ?? 0;
                $persen = $target > 0 ? ($capaian / ($target/12)) * 100 : 0;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->target->indikator->nama_indikator ?? '-' }}</td>
                <td>{{ $item->desa->nama_desa ?? '-' }}</td>
                <td class="text-center">{{ $item->bulan }}</td>
                <td class="text-center">{{ number_format($target/12, 2) }}</td>
                <td class="text-center">{{ $capaian }}</td>
                <td class="text-center">{{ number_format($persen, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
