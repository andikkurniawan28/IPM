<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikPengamatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function zona(){
        return $this->belongsTo(Zona::class);
    }

    public function parameter_titik_pengamatans(){
        return $this->hasMany(ParameterTitikPengamatan::class);
    }
}
