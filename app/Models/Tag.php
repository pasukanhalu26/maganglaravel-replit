<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['number_id', 'name'];

    public function number()
    {
        return $this->belongsTo(Number::class);
    }
}
