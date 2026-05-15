<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desa;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $desas = [
            ['id_desa' => 1, 'nama_desa' => 'DRIYOREJO', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 2, 'nama_desa' => 'CANGKIR', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 3, 'nama_desa' => 'BAMBE', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 4, 'nama_desa' => 'KESAMBEN WETAN', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 5, 'nama_desa' => 'PETIKEN', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 6, 'nama_desa' => 'TENARU', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 7, 'nama_desa' => 'MULUNG', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 8, 'nama_desa' => 'GADUNG', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 9, 'nama_desa' => 'RANDEGAN SARI', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_desa' => 10, 'nama_desa' => 'WEDORO ANOM', 'status' => 1, 'create_by' => 'Sistem Seeder'],
        ];

        foreach ($desas as $desa) {
            // Pakai updateOrCreate biar kalau dieksekusi 2 kali nggak error dobel
            Desa::updateOrCreate(['id_desa' => $desa['id_desa']], $desa);
        }
    }
}