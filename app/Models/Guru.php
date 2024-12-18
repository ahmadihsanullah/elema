<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    // Kolom password dienkripsi
    protected $casts = [
        'password' => 'hashed',
    ];
}
