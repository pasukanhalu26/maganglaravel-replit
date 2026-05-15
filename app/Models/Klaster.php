<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trackable;

class Klaster extends Model
{
    use HasFactory, Trackable;

    protected $table = 'klasters';
    protected $primaryKey = 'id_klaster';
    
    // Jangan lupa kolom baru dimasukkan ke sini biar bisa disave!
    protected $fillable = [
        'nama_klaster', 
        'status', 
        'create_by', 
        'update_by'
    ];

    public function programs()
    {
        return $this->hasMany(Program::class, 'id_klaster');
    }
}