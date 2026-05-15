<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['id_program' => 1, 'nama_program' => 'KIA', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 2, 'nama_program' => 'Anak Usia Sekolah & Remaja', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 3, 'nama_program' => 'GIZI', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 4, 'nama_program' => 'DIARE', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 5, 'nama_program' => 'HEPATITIS', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 6, 'nama_program' => 'KUSTA', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 7, 'nama_program' => 'TBC', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 8, 'nama_program' => 'HIV', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 9, 'nama_program' => 'IMUNISASI', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 10, 'nama_program' => 'Jiwa & NAPZA', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 11, 'nama_program' => 'GILUT', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 12, 'nama_program' => 'KESTRAD', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 13, 'nama_program' => 'PKG', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 14, 'nama_program' => 'PNEUMONIA', 'id_klaster' => 2, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 15, 'nama_program' => 'KENAIKAN PANGKAT', 'id_klaster' => 1, 'status' => 1, 'create_by' => 'Sistem Seeder'],
            ['id_program' => 16, 'nama_program' => 'TEKANAN DARAH TINGGI', 'id_klaster' => 3, 'status' => 1, 'create_by' => 'Sistem Seeder'],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(['id_program' => $program['id_program']], $program);
        }
    }
}