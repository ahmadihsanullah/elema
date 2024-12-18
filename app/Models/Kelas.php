<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelas extends Model
{
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    
   public function jurusan(): BelongsTo{
       return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id');
   }

   public function angkatan(): BelongsTo{
    return $this->belongsTo(Angkatan::class, 'id_angkatan', 'id');
}

}
