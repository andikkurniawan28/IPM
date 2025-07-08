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
            $monitoringColumn = 'param' . $parameter->id;
            $roleColumn = 'akses_input_param' . $parameter->id;

            // Tambahkan kolom pada tabel monitorings jika belum ada
            if (!Schema::hasColumn('monitorings', $monitoringColumn)) {
                Schema::table('monitorings', function (Blueprint $table) use ($monitoringColumn, $parameter) {
                    if ($parameter->jenis === 'kuantitatif') {
                        $table->float($monitoringColumn)
                            ->nullable()
                            ->after('updated_at');
                    } else {
                        $table->string($monitoringColumn)
                            ->nullable()
                            ->after('updated_at');
                    }
                });

                // Tambahkan index
                DB::statement("CREATE INDEX idx_{$monitoringColumn} ON monitorings ({$monitoringColumn})");
            }

            // Tambahkan kolom izin_param{id} di tabel roles jika belum ada
            if (!Schema::hasColumn('roles', $roleColumn)) {
                Schema::table('roles', function (Blueprint $table) use ($roleColumn) {
                    $table->boolean($roleColumn)
                        ->default(false)
                        ->after('updated_at');
                });
            }
        });
    }

}
