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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_parameter_id')->constrained();

            // Boleh kosong jika jenis = 'kualitatif'
            $table->foreignId('satuan_id')->nullable()->constrained();

            $table->string('nama')->unique(); // Nama parameter (misalnya: "Tekanan")
            $table->string('simbol'); // Selalu diisi, untuk tampilan tabel (misalnya: "TK", "AKT")

            $table->enum('jenis', ['kuantitatif', 'kualitatif_opsional', 'kualitatif_entry'])->default('kuantitatif');

            // Hanya berlaku untuk kuantitatif
            $table->enum('metode_agregasi', ['sum', 'avg', 'count'])->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
