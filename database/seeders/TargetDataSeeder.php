<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class TargetDataSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel target lama jika ada (agar rapi dari ID 1)
        DB::table('targets')->truncate();

        $data = [
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 1, 'periode' => 2025, 'target_tahunan' => 940],
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 2, 'periode' => 2025, 'target_tahunan' => 940],
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 3, 'periode' => 2025, 'target_tahunan' => 141],
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 4, 'periode' => 2025, 'target_tahunan' => 965],
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 5, 'periode' => 2025, 'target_tahunan' => 940],
            ['id_klaster' => 2, 'id_program' => 1, 'id_indikator' => 8, 'periode' => 2025, 'target_tahunan' => 941],
        ];

        foreach ($data as $item) {
            Target::create([
                'id_klaster'     => $item['id_klaster'],
                'id_program'     => $item['id_program'],
                'id_indikator'   => $item['id_indikator'],
                'periode'        => $item['periode'],
                'target_tahunan' => $item['target_tahunan'],
                'status'         => 1,
                'create_by'      => 'admin123',
            ]);
        }
    }
}
