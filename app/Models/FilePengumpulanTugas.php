<?php

namespace App\Models;

use App\Models\PengumpulanTugas;
use Illuminate\Database\Eloquent\Model;

class FilePengumpulanTugas extends Model
{
    protected $keyType = 'int';
    public $incrementing = true;

    public function pengumpulanTugas()
    {
        return $this->belongsTo(PengumpulanTugas::class, 'pengumpulan_tugas_id', 'id');
    }

   
}
