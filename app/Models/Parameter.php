<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

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

    public function pilihan_kualitatifs(){
        return $this->hasMany(PilihanKualitatif::class);
    }

    protected static function booted()
    {
        static::created(function (Parameter $parameter) {
            $column = 'param' . $parameter->id;
            if (! Schema::hasColumn('monitorings', $column)) {
                Schema::table('monitorings', function (Blueprint $table) use ($column, $parameter) {
                    if ($parameter->jenis === 'kuantitatif') {
                        $table->float($column)
                              ->nullable()
                              ->after('updated_at');
                    } else {
                        $table->string($column)
                              ->nullable()
                              ->after('updated_at');
                    }
                });
            }
        });
    }
}
