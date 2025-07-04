<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function titik_pengamatans(){
        return $this->hasMany(TitikPengamatan::class);
    }
}
