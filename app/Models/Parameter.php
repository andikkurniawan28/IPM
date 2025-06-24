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

    protected static function booted()
    {
        static::created(function ($model) {
            $parameterId = $model->id;
            $columnName = "param{$parameterId}";

            if (!Schema::hasColumn('monitorings', $columnName)) {
                Schema::table('monitorings', function (Blueprint $table) use ($columnName) {
                    $table->float($columnName)->nullable()->after('updated_at');
                });
            }
        });
    }
}
