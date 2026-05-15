<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateEmergencyAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cari user ID 1 atau create baru
        $user = User::find(1);
        
        if (!$user) {
            $user = User::create([
                'id' => 1,
                'name' => 'Super Admin',
                'username' => 'SIP-000001',
                'email' => 'admin@sip.local',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 1,
                'create_by' => 'System',
            ]);
        } else {
            $user->update([
                'username' => 'SIP-000001',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 1,
            ]);
        }

        $this->command->info("✅ Emergency Admin Ready!");
        $this->command->info("Username: SIP-000001");
        $this->command->info("Password: admin123");
    }
}
