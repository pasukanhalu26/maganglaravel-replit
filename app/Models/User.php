<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'id_desa',
        'status',
        'create_by',
        'update_by'
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    /*
     * Default-nya 'email', kita tetap pakai email karena Kode ID (SIP-XXXXXX) disimpan di sana.
     */
    // public function username(): string
    // {
    //     return 'username';
    // }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}