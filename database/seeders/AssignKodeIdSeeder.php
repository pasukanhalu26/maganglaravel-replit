<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignKodeIdSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Cek apakah username sudah berformat SIP-XXXXXX
            if (!$user->username || !str_starts_with($user->username, 'SIP-')) {
                $hex = strtoupper(base_convert($user->id, 10, 36));
                $kodeId = 'SIP-' . str_pad($hex, 6, '0', STR_PAD_LEFT);
                
                $dataUpdate = ['username' => $kodeId];
                
                // Jika email berisi Kode ID, kembalikan ke format email placeholder
                if (str_starts_with($user->email, 'SIP-')) {
                    $dataUpdate['email'] = strtolower(str_replace(' ', '_', $user->name)) . '@sip.local';
                }

                $user->update($dataUpdate);
                $this->command->info("User [{$user->name}] → Kode ID (Username): {$kodeId}");
            } else {
                $this->command->info("User [{$user->name}] sudah punya Kode ID di Username: {$user->username}");
            }
        }

        $this->command->newLine();
        $this->command->info('✅ Semua user sudah memiliki Kode ID!');
        $this->command->info('ℹ️  Gunakan Kode ID + Password untuk login.');
    }
}
