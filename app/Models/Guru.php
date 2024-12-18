<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guru extends Model
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
