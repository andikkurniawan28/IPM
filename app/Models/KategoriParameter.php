<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriParameter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parameters(){
        return $this->hasMany(Parameter::class);
    }

    protected static function booted()
    {
        static::created(function (KategoriParameter $kategori) {
            $columnName = 'akses_monitoring_kategori' . Str::slug($kategori->id, '_');

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
