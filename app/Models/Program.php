<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trackable;

class Program extends Model
{
    use HasFactory, Trackable;

    protected $table = 'programs';
    protected $primaryKey = 'id_program';
    
    // Tambahkan kolom status, create_by, update_by
    protected $fillable = [
        'id_klaster', 
        'nama_program', 
        'status', 
        'create_by', 
        'update_by'
    ];

    public function klaster()
    {
        return $this->belongsTo(Klaster::class, 'id_klaster');
    }

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'id_program');
    }
}