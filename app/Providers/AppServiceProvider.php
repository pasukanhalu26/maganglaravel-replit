<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
// Tambahin ini buat bikin Gembok (Gate)
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // 1. GEMBOK MENU USER (Hanya Admin)
        Gate::define('kelola_user', function(User $user) {
            return $user->role === 'admin';
        });

        // 2. GEMBOK MENU MASTER DATA (Admin & PJ Program)
        Gate::define('kelola_master', function(User $user) {
            return in_array($user->role, ['admin', 'pj_program']);
        });

        // 3. GEMBOK MENU CAPAIAN (Bisa Semua: Admin, PJ, Staff)
        Gate::define('kelola_capaian', function(User $user) {
            return in_array($user->role, ['admin', 'pj_program', 'staff_desa']);
        });
    }
}