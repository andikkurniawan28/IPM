<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            // $table->boolean('izin_akses_input')->default(1);
            // $table->boolean('izin_akses_laporan')->default(1);
            // $table->boolean('izin_akses_master')->default(1);
            $table->boolean('akses_master_daftar_kategori_parameter')->default(1);
            $table->boolean('akses_master_tambah_kategori_parameter')->default(1);
            $table->boolean('akses_master_edit_kategori_parameter')->default(1);
            $table->boolean('akses_master_hapus_kategori_parameter')->default(1);
            $table->boolean('akses_master_daftar_satuan')->default(1);
            $table->boolean('akses_master_tambah_satuan')->default(1);
            $table->boolean('akses_master_edit_satuan')->default(1);
            $table->boolean('akses_master_hapus_satuan')->default(1);
            $table->boolean('akses_master_daftar_jenis_pilihan_kualitatif')->default(1);
            $table->boolean('akses_master_tambah_jenis_pilihan_kualitatif')->default(1);
            $table->boolean('akses_master_edit_jenis_pilihan_kualitatif')->default(1);
            $table->boolean('akses_master_hapus_jenis_pilihan_kualitatif')->default(1);
            $table->boolean('akses_master_daftar_parameter')->default(1);
            $table->boolean('akses_master_tambah_parameter')->default(1);
            $table->boolean('akses_master_edit_parameter')->default(1);
            $table->boolean('akses_master_hapus_parameter')->default(1);
            $table->boolean('akses_master_daftar_zona')->default(1);
            $table->boolean('akses_master_tambah_zona')->default(1);
            $table->boolean('akses_master_edit_zona')->default(1);
            $table->boolean('akses_master_hapus_zona')->default(1);
            $table->boolean('akses_master_daftar_titik_pengamatan')->default(1);
            $table->boolean('akses_master_tambah_titik_pengamatan')->default(1);
            $table->boolean('akses_master_edit_titik_pengamatan')->default(1);
            $table->boolean('akses_master_hapus_titik_pengamatan')->default(1);
            $table->boolean('akses_master_daftar_role')->default(1);
            $table->boolean('akses_master_tambah_role')->default(1);
            $table->boolean('akses_master_edit_role')->default(1);
            $table->boolean('akses_master_hapus_role')->default(1);
            $table->boolean('akses_master_daftar_user')->default(1);
            $table->boolean('akses_master_tambah_user')->default(1);
            $table->boolean('akses_master_edit_user')->default(1);
            $table->boolean('akses_master_hapus_user')->default(1);
            $table->boolean('akses_daftar_input_monitoring')->default(1);
            $table->boolean('akses_tambah_input_monitoring')->default(1);
            $table->boolean('akses_edit_input_monitoring')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
