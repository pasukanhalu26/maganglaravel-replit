<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $fillable = ['phone_number', 'is_hidden'];
    
    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    // Local Scope: Hanya mengambil nomor yang tidak di-private
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
