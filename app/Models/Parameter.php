<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategori_parameter(){
        return $this->belongsTo(KategoriParameter::class);
    }

    public function satuan(){
        return $this->belongsTo(Satuan::class);
    }
}
