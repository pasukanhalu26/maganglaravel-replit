<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        // Reset password untuk semua user Admin
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            // Kalau tidak ada admin, reset semua user
            $admins = User::all();
        }

        foreach ($admins as $user) {
            $user->update(['password' => Hash::make('admin123')]);
            $this->command->info("✅ Password direset → Nama: [{$user->name}] | Kode ID: [{$user->username}] | Password baru: admin123");
        }

        $this->command->newLine();
        $this->command->info('🔐 Setelah login, segera ganti password Anda via halaman Master User!');
    }
}
