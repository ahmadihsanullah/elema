<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SesiBelajar extends Model
{
    protected $primaryKey = 'id'; 
    public $incrementing = true; 
    public $timestamps = false; 

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mengisi slug secara otomatis
            $model->slug = Str::random(10);
        });
    }

    public function guruMataPelajaran(): BelongsTo{
        return $this->belongsTo(GuruMataPelajaran::class, 'id_guru_mata_pelajaran', 'id');
    }
}
