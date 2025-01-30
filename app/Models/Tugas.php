<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tugas extends Model
{
    public function sesiBelajars(): BelongsTo{
        return $this->belongsTo(SesiBelajar::class, "id_sesi_belajar");
    }

    public function pengumpulanTugas(): BelongsToMany{
        return $this->belongsToMany(PengumpulanTugas::class, 'id_tugas', 'id');
    }
}
