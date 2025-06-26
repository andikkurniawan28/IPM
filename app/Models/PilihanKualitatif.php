<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanKualitatif extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenis_pilihan_kualitatif(){
        return $this->belongsTo(JenisPilihanKualitatif::class);
    }

    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }
}
