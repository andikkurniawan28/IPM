<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterTitikPengamatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function titik_pengamatan(){
        return $this->belongsTo(TitikPengamatan::class);
    }

    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }
}
