<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'password' => 'hashed',
    ];

    
    public function kelas(): BelongsTo{
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function pengumpulanTugas(): BelongsToMany{
        return $this->belongsToMany(PengumpulanTugas::class, 'id_siswa', 'id');
    }
}
