<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jawaban extends Model
{
    public function pertanyaan(): BelongsTo{
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan', 'id');
    }
}
