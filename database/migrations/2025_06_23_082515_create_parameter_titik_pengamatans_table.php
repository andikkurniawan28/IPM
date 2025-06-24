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
        Schema::create('parameter_titik_pengamatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('titik_pengamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('parameter_id')->constrained();
            // $table->float('nilai')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_titik_pengamatans');
    }
};
