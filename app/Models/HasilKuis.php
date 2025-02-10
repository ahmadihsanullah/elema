<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilKuis extends Model
{
    public function kuis(): BelongsTo{
        return $this->belongsTo(Kuis::class, 'id_kuis', 'id');
    }

    public function siswa(): BelongsTo{
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function jawabanSiswa()
{
    return $this->hasMany(JawabanSiswa::class, 'id_hasil_kuis');
}

}
