<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $table = 'targets';
    protected $primaryKey = 'id_target';

    protected $fillable = [
        'id_klaster',
        'id_program',
        'id_indikator',
        'periode',
        'target_tahunan',
        'status',
        'create_by',
        'update_by',
    ];

    public function klaster()
    {
        return $this->belongsTo(Klaster::class, 'id_klaster');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }
}
