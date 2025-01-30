<?php

namespace App\Models;

use App\Models\SesiBelajar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Kuis extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mengisi slug secara otomatis
            $model->slug = Str::random(10);
        });
    }
    
    public function sesiBelajar(): BelongsTo{
        return $this->belongsTo(SesiBelajar::class, 'id_sesi_belajar', 'id');
    }
}
