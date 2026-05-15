<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    use HasFactory;

    protected $table = 'capaians';
    protected $primaryKey = 'id_capaian';

    protected $fillable = [
        'id_target',
        'id_desa',
        'bulan',
        'capaian_bulan',
        'capaian_kumulatif',
        'analisa_masalah',
        'rtl',
        'status',
        'create_by',
        'update_by',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class, 'id_target');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
}