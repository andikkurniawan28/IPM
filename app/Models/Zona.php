<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class Zona extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function titik_pengamatans()
    {
        return $this->hasMany(TitikPengamatan::class);
    }

    protected static function booted()
    {
        static::created(function (Zona $zona) {
            $columnName = 'akses_monitoring_zona' . Str::slug($zona->id, '_');

            if (!Schema::hasColumn('roles', $columnName)) {
                Schema::table('roles', function (Blueprint $table) use ($columnName) {
                    $table->boolean($columnName)
                        ->default(false)
                        ->after('updated_at');
                });
            }
        });
    }
}
