<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;

class KlasterSeeder extends Seeder
{
    public function run(): void
    {
        $klasters = [
            ['id_klaster' => 1, 'nama_klaster' => 'MANAJEMEN', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_klaster' => 2, 'nama_klaster' => 'KIA', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_klaster' => 3, 'nama_klaster' => 'DEWASA & LANSIA', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_klaster' => 4, 'nama_klaster' => 'PENYAKIT MENULAR & LINGKUNGAN', 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_klaster' => 5, 'nama_klaster' => 'LINTAS KLASTER', 'status' => 1, 'create_by' => 'Sistem Seeder'],
        ];

        foreach ($klasters as $klaster) {
            // updateOrCreate biar ID-nya terkunci sesuai data yang Abang kasih
            Klaster::updateOrCreate(['id_klaster' => $klaster['id_klaster']], $klaster);
        }
    }
}