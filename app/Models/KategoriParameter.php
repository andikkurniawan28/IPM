<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriParameter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parameters(){
        return $this->hasMany(Parameter::class);
    }
}
