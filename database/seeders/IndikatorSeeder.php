<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indikator;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $indikators = [
            // PROGRAM KIA (ID: 1)
            ['id_indikator' => '1', 'nama_indikator' => 'Pelayanan Kesehatan Neonatus pertama (KN1)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '2', 'nama_indikator' => 'Pelayanan Kesehatan Neonatus 0 - 28 hari (KN lengkap)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '3', 'nama_indikator' => 'Penanganan komplikasi neonatus', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '4', 'nama_indikator' => 'Pelayanan kesehatan bayi 29 hari - 11 bulan', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '5', 'nama_indikator' => 'Persentase penduduk penerima pemeriksaan kesehatan gratis kelompok usia bayi baru lahir (%)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '6', 'nama_indikator' => 'Bayi lahir mendapat HBO <24 jam', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '7', 'nama_indikator' => 'Bayi lahir mendapat HBIG <24 jam', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '8', 'nama_indikator' => 'Persentase anak pra sekolah (60-72 bulan) mendapatkan pelayanan kesehatan sesuai standar', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '9', 'nama_indikator' => 'Pelayanan kesehatan balita (0-59 bulan)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '10', 'nama_indikator' => 'Balita dipantau pertumbuhan dan perkembangan', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '11', 'nama_indikator' => 'Kunjungan Pertama Ibu Hamil (K1 Murni)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '12', 'nama_indikator' => 'Ibu hamil yang mendapatkan pemeriksaan kehamilan 6 kali (K6)( INM )', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '13', 'nama_indikator' => 'Pelayanan Nifas oleh tenaga kesehatan (KF)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '14', 'nama_indikator' => 'Penanganan komplikasi kebidanan (PK)', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '15', 'nama_indikator' => 'Ibu hamil yang diperiksa ANC Terpadu ( yang diperiksa HIV ,HbsAg, Syphilis )', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '16', 'nama_indikator' => 'Persalinan oleh nakes', 'id_program' => 1, 'target' => 100, 'satuan' => '%'],

            // PROGRAM Anak Usia Sekolah & Remaja (ID: 2)
            ['id_indikator' => '17', 'nama_indikator' => 'Sekolah setingkat SD/MI/SDLB yang melaksanakan skrining kesehatan', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '18', 'nama_indikator' => 'Sekolah setingkat SMP/MTs/SMPLB yang melaksanakan skrining kesehatan', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '19', 'nama_indikator' => 'Sekolah setingkat SMA/MA/SMK/SMALB yang melaksanakan skrining kesehatan', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '20', 'nama_indikator' => 'Pelayanan Kesehatan pada Usia Pendidikan Dasar kelas 1 sampai dengan kelas 9', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '21', 'nama_indikator' => 'Skrining anemia pada remaja putri', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '22', 'nama_indikator' => 'Remaja putri mengonsumsi tablet tambah darah', 'id_program' => 2, 'target' => 100, 'satuan' => '%'],

            // PROGRAM GIZI (ID: 3)
            ['id_indikator' => '23', 'nama_indikator' => 'Ibu hamil KEK mendapat makanan tambahan', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '24', 'nama_indikator' => 'Anak 6-23 bulan mendapatkan MP-ASI', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '25', 'nama_indikator' => 'Pemberian Suplementasi Vitamin A pada Balita Usia 6-59 Bulan', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '26', 'nama_indikator' => 'Pemberian tambahan asupan gizi bagi balita gizi kurang', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '27', 'nama_indikator' => 'Balita gizi buruk mendapat perawatan sesuai standar', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '28', 'nama_indikator' => 'Stunting', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '29', 'nama_indikator' => 'Underweight', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '30', 'nama_indikator' => 'Wasting', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '31', 'nama_indikator' => 'Bayi usia 6 bulan mendapat ASI Eksklusif', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
            ['id_indikator' => '32', 'nama_indikator' => 'Ibu hamil mendapat suplementasi gizi', 'id_program' => 3, 'target' => 100, 'satuan' => '%'],
        ];

        foreach ($indikators as $item) {
            Indikator::updateOrCreate(
                ['id_indikator' => $item['id_indikator']],
                [
                    'nama_indikator' => $item['nama_indikator'],
                    'id_program'     => $item['id_program'],
                    'target'         => $item['target'],
                    'satuan'         => $item['satuan'],
                    'status'         => 1,
                    'create_by'      => 'Sistem Seeder'
                ]
            );
        }
    }
}