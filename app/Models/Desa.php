<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Trackable;

class Desa extends Model
{
    use Trackable;

    protected $table = 'desas';
    protected $primaryKey = 'id_desa'; // Jangan lupa ini, biar Laravel nggak bingung
    protected $fillable = ['kode_desa', 'nama_desa', 'status', 'create_by', 'update_by'];
}