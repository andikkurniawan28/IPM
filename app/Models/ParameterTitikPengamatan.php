<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

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

    protected static function booted()
    {
        static::created(function ($model) {
            $parameterId = $model->parameter_id;
            $titikId = $model->titik_pengamatan_id;
            $columnName = "value_{$parameterId}_{$titikId}";

            // Cek apakah kolom sudah ada
            if (!Schema::hasColumn('monitorings', $columnName)) {
                Schema::table('monitorings', function (Blueprint $table) use ($columnName) {
                    $table->float($columnName)->nullable()->after('id');
                });
            }
        });

        // Tidak melakukan apa-apa saat deleted, jadi tidak perlu static::deleted
    }
}
