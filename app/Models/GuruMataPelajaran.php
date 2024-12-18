<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuruMataPelajaran extends Model
{
    protected $primaryKey = 'id'; // Kolom 'id' sebagai primary key secara default
    public $incrementing = true; // Menggunakan auto-increment untuk kolom 'id'
    public $timestamps = false; 

    public function guru(): BelongsTo{
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function mataPelajaran(): BelongsTo{
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_guru_mata_pelajaran', 'id');
    }

}
