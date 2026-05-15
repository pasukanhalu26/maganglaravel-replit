<!DOCTYPE html>
<html>
<head>
    <title>Laporan Capaian Kinerja</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #2D0B5A; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        .info { margin-bottom: 15px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        th { background-color: #2D0B5A; color: white; padding: 8px; font-size: 10px; text-transform: uppercase; border: 1px solid #ddd; }
        td { padding: 6px; font-size: 9px; border: 1px solid #ddd; word-wrap: break-word; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 9px; color: #aaa; padding-top: 10px; border-top: 1px solid #eee; }
        @page { margin: 1cm; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Capaian Kinerja Bulanan</h2>
        <p>Kecamatan Driyorejo - Kabupaten Gresik</p>
    </div>

    <div class="info">
        <table style="border: none; margin-bottom: 0;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">Tanggal Cetak: {{ date('d-m-Y H:i') }}</td>
                <td style="border: none; width: 50%; text-align: right;">Dicetak Oleh: {{ Auth::user()->name }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="30%">Indikator</th>
                <th width="15%">Desa</th>
                <th width="10%">Bulan</th>
                <th width="12%">Capaian</th>
                <th width="12%">Target</th>
                <th width="16%">Persentase (%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $bulans = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                          7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            @endphp
            @foreach($data as $item)
            @php
                $target = $item->target->target_tahunan ?? 0;
                $persen = $target > 0 ? ($item->capaian_bulan / $target) * 100 : 0;
                $color = $persen >= 100 ? '#157347' : ($persen >= 50 ? '#b45309' : '#dc3545');
            @endphp
            <tr>
                <td class="text-center">#{{ str_pad($item->id_capaian, 3, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="fw-bold">{{ $item->target->indikator->nama_indikator ?? '-' }}</div>
                    <div style="font-size: 7px; color: #666;">P-{{ $item->target->id_program }} | K-{{ $item->target->id_klaster }}</div>
                </td>
                <td class="text-center">{{ $item->desa->nama_desa ?? '-' }}</td>
                <td class="text-center">{{ $bulans[$item->bulan] ?? $item->bulan }}</td>
                <td class="text-center fw-bold">{{ number_format($item->capaian_bulan) }}</td>
                <td class="text-center">{{ number_format($target) }}</td>
                <td class="text-center fw-bold" style="color: {{ $color }}; font-size: 11px;">
                    {{ number_format($persen, 2) }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; width: 250px; text-align: center;">
        <p style="font-size: 11px; margin-bottom: 60px;">Driyorejo, {{ date('d F Y') }}<br>Mengetahui,</p>
        <p style="font-size: 11px; font-weight: bold; border-bottom: 1px solid #000; display: inline-block; padding: 0 20px;">( ............................................ )</p>
        <p style="font-size: 10px; margin-top: 5px;">Kepala Instansi</p>
    </div>

    <div class="footer">
        Halaman 1 dari 1 | SIP Driyorejo &copy; {{ date('Y') }}
    </div>
</body>
</html>