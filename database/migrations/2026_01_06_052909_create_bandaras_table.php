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
        Schema::create('bandaras', function (Blueprint $table) {
            $table->id();
            $table->string('kode_iata', 5)->unique(); 
            $table->string('nama_bandara');
            $table->string('kota');
            $table->string('negara')->default('Indonesia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bandaras');
    }
};
