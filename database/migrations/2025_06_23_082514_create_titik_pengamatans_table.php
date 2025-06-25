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
        Schema::create('titik_pengamatans', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan')->nullable()->unique();
            $table->foreignId('zona_id')->constrained();
            $table->string('kode')->unique();
            $table->string('nama')->unique();
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
        Schema::dropIfExists('titik_pengamatans');
    }
};
