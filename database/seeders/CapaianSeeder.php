<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Capaian;
use Illuminate\Support\Facades\DB;

class CapaianSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('capaians')->truncate();

        // Mengacu pada gambar excel yang diberikan:
        // Semua data ini adalah untuk Klaster 2, Program 1, Indikator 1 (yaitu id_target = 1 yang baru kita buat)
        // Bulan 1 (Januari)
        $data = [
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 1, 'capaian_bulan' => 8],  // DRIYOREJO
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 2, 'capaian_bulan' => 5],  // CANGKIR
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 3, 'capaian_bulan' => 12], // BAMBE
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 4, 'capaian_bulan' => 7],  // KESAMBEN WETAN
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 5, 'capaian_bulan' => 17], // PETIKEN
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 6, 'capaian_bulan' => 4],  // TENARU
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 7, 'capaian_bulan' => 7],  // MULUNG
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 8, 'capaian_bulan' => 6],  // GADUNG
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 9, 'capaian_bulan' => 10], // RANDEGAN SARI
            ['id_target' => 1, 'bulan' => 1, 'id_desa' => 10, 'capaian_bulan' => 6], // WEDORO ANOM

            // Bulan 2 (Februari)
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 1, 'capaian_bulan' => 8],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 2, 'capaian_bulan' => 6],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 3, 'capaian_bulan' => 10],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 4, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 5, 'capaian_bulan' => 11],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 6, 'capaian_bulan' => 5],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 7, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 8, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 9, 'capaian_bulan' => 6],
            ['id_target' => 1, 'bulan' => 2, 'id_desa' => 10, 'capaian_bulan' => 5],
            
            // Bulan 3 (Maret)
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 1, 'capaian_bulan' => 8],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 2, 'capaian_bulan' => 6],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 3, 'capaian_bulan' => 9],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 4, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 5, 'capaian_bulan' => 11],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 6, 'capaian_bulan' => 5],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 7, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 8, 'capaian_bulan' => 6],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 9, 'capaian_bulan' => 7],
            ['id_target' => 1, 'bulan' => 3, 'id_desa' => 10, 'capaian_bulan' => 6],
        ];

        foreach ($data as $item) {
            Capaian::create([
                'id_target'     => $item['id_target'],
                'id_desa'       => $item['id_desa'],
                'bulan'         => $item['bulan'],
                'capaian_bulan' => $item['capaian_bulan'],
                'status'        => 1,
                'create_by'     => 'admin123',
            ]);
        }
    }
}
