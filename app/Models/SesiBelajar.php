<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class SesiBelajar extends Model
{
    protected $primaryKey = 'id'; 
    public $incrementing = true; 

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mengisi slug secara otomatis
            $model->slug = Str::random(10);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Menentukan 'slug' sebagai key untuk URL
    }

    public function guruMataPelajaran(): BelongsTo{
        return $this->belongsTo(GuruMataPelajaran::class, 'id_guru_mata_pelajaran', 'id');
    }

    public function materi():HasOne{
        return $this->hasOne(Materi::class, 'id_sesi_belajar', 'id');
    }

    public function fileMateris():HasMany{
        return $this->hasMany(FileMateri::class, 'id_sesi_belajar', 'id');
    }
}
