<?php

namespace App\Imports;

use App\Models\Capaian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Exception;

class CapaianImport implements ToCollection
{
    protected $id_desa;
    protected $bulan;

    public function __construct($id_desa, $bulan)
    {
        $this->id_desa = $id_desa;
        $this->bulan = $bulan;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Kolom J (index 9) adalah ID_TARGET yang di-hidden.
            // Jika baris ini bukan baris data (kosong atau header teks), kita lewati.
            if (!isset($row[9]) || empty($row[9]) || !is_numeric($row[9])) {
                continue;
            }

            $id_target = $row[9];

            // Kolom Pencapaian Bulanan adalah Kolom D (index 3)
            $capaian_bulanan = $row[3];
            
            // Analisa Masalah (Kolom H - index 7)
            $analisa_masalah = $row[7] ?? null;
            
            // RTL (Kolom I - index 8)
            $rtl = $row[8] ?? null;

            if ($capaian_bulanan !== null && $capaian_bulanan !== '' && !is_numeric($capaian_bulanan)) {
                $baris = $index + 1;
                throw new Exception("Kolom Pencapaian Bulanan pada baris ke-{$baris} harus berupa angka. Anda memasukkan huruf atau karakter tidak valid.");
            }

            // Jika kosong, anggap 0
            $capaian_bulanan = $capaian_bulanan !== null && $capaian_bulanan !== '' ? floatval($capaian_bulanan) : 0;

            // Hitung capaian kumulatif (jumlahkan capaian bulan-bulan sebelumnya + bulan ini)
            $capaian_sebelumnya = Capaian::where('id_target', $id_target)
                ->where('id_desa', $this->id_desa)
                ->where('bulan', '<', $this->bulan)
                ->sum('capaian_bulan');
                
            $capaian_kumulatif = $capaian_sebelumnya + $capaian_bulanan;

            // Update jika ada, Insert jika belum ada
            Capaian::updateOrCreate(
                [
                    'id_target' => $id_target,
                    'id_desa' => $this->id_desa,
                    'bulan' => $this->bulan,
                ],
                [
                    'capaian_bulan' => $capaian_bulanan,
                    'capaian_kumulatif' => $capaian_kumulatif,
                    'analisa_masalah' => $analisa_masalah,
                    'rtl' => $rtl,
                    'status' => 1,
                    'create_by' => Auth::user()->name,
                    'update_by' => Auth::user()->name,
                ]
            );
            
            // Rekalkulasi kumulatif untuk bulan-bulan setelahnya (jika user menginput bulan lama)
            // Agar data bulan ke depan (jika sudah ada) tetap sinkron
            $bulan_selanjutnya = Capaian::where('id_target', $id_target)
                ->where('id_desa', $this->id_desa)
                ->where('bulan', '>', $this->bulan)
                ->orderBy('bulan', 'asc')
                ->get();
                
            $current_kumulatif = $capaian_kumulatif;
            foreach ($bulan_selanjutnya as $bs) {
                $current_kumulatif += $bs->capaian_bulan;
                $bs->update(['capaian_kumulatif' => $current_kumulatif]);
            }
        }
    }
}
