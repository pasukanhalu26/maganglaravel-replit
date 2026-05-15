<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indikator;

class UpdateIndikatorTargetSeeder extends Seeder
{
    public function run(): void
    {
        $targets = [
            1 => 940,
            2 => 940,
            3 => 141,
            4 => 965,
            5 => 940,
            8 => 941,
        ];

        foreach ($targets as $id => $targetValue) {
            $indikator = Indikator::find($id);
            if ($indikator) {
                $indikator->update([
                    'target' => (string) $targetValue,
                    'satuan' => 'Orang' // Sesuai konteks jumlah sasaran biasanya dalam 'Orang' untuk angka ribuan ini
                ]);
            }
        }
    }
}
