<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trackable;

class Indikator extends Model
{
    use HasFactory, Trackable;

    protected $table = 'indikators';
    protected $primaryKey = 'id_indikator';

    // ID sekarang auto increment (integer)
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_klaster',
        'id_program',
        'nama_indikator',
        'status',
        'create_by',
        'update_by'
    ];

    public function klaster()
    {
        return $this->belongsTo(Klaster::class, 'id_klaster');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function capaians()
    {
        return $this->hasMany(Capaian::class, 'id_indikator');
    }
}