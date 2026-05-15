<!DOCTYPE html>
<html>
<head>
    <title>Laporan Capaian Kinerja</title>
</head>
<body>
    @php
        $bulans = [1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',5=>'MEI',6=>'JUNI',
                   7=>'JULI',8=>'AGUSTUS',9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'];
        
        // Group by Desa, then Bulan, then Program to separate tables per category
        $groupedData = $data->groupBy(function($item) {
            return ($item->id_desa ?? '0') . '|' . $item->bulan . '|' . ($item->target->id_program ?? '0');
        });
    @endphp

    @foreach($groupedData as $key => $items)
        @php
            $parts = explode('|', $key);
            $id_desa = $parts[0];
            $bulan = $parts[1];
            $id_program = $parts[2];
            
            $nama_desa = $items->first()->desa->nama_desa ?? '-';
            $nama_program = $items->first()->target->program->nama_program ?? '-';
            $nama_bulan = $bulans[$bulan] ?? $bulan;
            
            // Calculate totals for "PERSENTASE PENCAPAIAN BULANAN PROGRAM"
            $totalTarget = $items->sum(function($item) { return $item->target->target_tahunan ?? 0; });
            $totalCapaian = $items->sum('capaian_bulan'); 
            $persenProgram = $totalTarget > 0 ? ($totalCapaian / $totalTarget) * 100 : 0;
        @endphp

        <table>
            <tr>
                <td colspan="2" style="font-weight: bold;">DESA</td>
                <td colspan="7" style="font-weight: bold;">: {{ strtoupper($nama_desa) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">BULAN</td>
                <td colspan="7" style="font-weight: bold;">: {{ $nama_bulan }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">PROGRAM</td>
                <td colspan="7" style="font-weight: bold;">: {{ strtoupper($nama_program) }}</td>
            </tr>
            <tr>
                <td colspan="9"></td>
            </tr>
        </table>

        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">NO.</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">INDIKATOR</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">TARGET<br>TAHUNAN</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">PENCAPAIAN<br>BULANAN</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">PENCAPAIAN<br>KUMULATIF</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">PERSENTASE<br>PENCAPAIAN<br>KUMULATIF</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">PERSENTASE<br>PENCAPAIAN<br>BULANAN<br>PROGRAM</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">ANALISA MASALAH</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #000;">RTL</th>
                </tr>
                <tr>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">1</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">2</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">3</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">5</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">6</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">8</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">9</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">10</th>
                    <th style="background-color: #FFFF00; font-weight: bold; text-align: center; border: 1px solid #000;">11</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                @php
                    $target = $item->target->target_tahunan ?? 0;
                    $capaian_bulanan = $item->capaian_bulan;
                    
                    // Hitung kumulatif (bulan ini dan sebelumnya untuk desa & target yang sama)
                    $kumulatif = \App\Models\Capaian::where('id_target', $item->id_target)
                                    ->where('id_desa', $item->id_desa)
                                    ->where('bulan', '<=', $item->bulan)
                                    ->sum('capaian_bulan');
                                    
                    $persenKumulatif = $target > 0 ? ($kumulatif / $target) * 100 : 0;
                    
                    $isAchieved = $persenKumulatif >= ($item->bulan / 12 * 100); 
                    $analisaMasalah = $isAchieved ? 'tercapai' : 'belum tercapai , masih ada kendala di lapangan';
                    $rtl = $isAchieved ? '' : 'dilaksanakan evaluasi dan perbaikan bulan depan';
                    
                    $greenBg = 'background-color: #92D050;';
                @endphp
                <tr>
                    <td style="text-align: center; border: 1px solid #000;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #000;">{{ $item->target->indikator->nama_indikator ?? '-' }}</td>
                    <td style="text-align: center; border: 1px solid #000;">{{ $target }}</td>
                    <td style="text-align: center; border: 1px solid #000; {{ $greenBg }}">{{ $capaian_bulanan }}</td>
                    <td style="text-align: center; border: 1px solid #000;">{{ $kumulatif }}</td>
                    <td style="text-align: center; border: 1px solid #000;">{{ number_format($persenKumulatif, 0) }}%</td>
                    
                    @if($index == 0)
                    <td rowspan="{{ count($items) }}" style="text-align: center; vertical-align: middle; border: 1px solid #000;">
                        {{ str_replace('.', ',', number_format($persenProgram, 2)) }}%
                    </td>
                    @endif
                    
                    <td style="text-align: center; border: 1px solid #000; {{ $greenBg }}">{{ $analisaMasalah }}</td>
                    <td style="text-align: center; border: 1px solid #000; {{ $greenBg }}">{{ $rtl }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
    @endforeach
</body>
</html>
