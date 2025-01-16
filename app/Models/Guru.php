<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable
{
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    // Kolom password dienkripsi
    protected $casts = [
        'password' => 'hashed',
    ];

    public function mataPelajarans(): BelongsToMany{
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajarans', 'id_guru', 'id_mata_pelajaran');
    }
}
