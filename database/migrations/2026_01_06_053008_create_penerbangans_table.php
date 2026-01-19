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
        Schema::create('penerbangans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_penerbangan')->unique();
            $table->string('maskapai');
            $table->foreignId('id_bandara_asal')->constrained('bandaras')->onDelete('cascade');
            $table->foreignId('id_bandara_tujuan')->constrained('bandaras')->onDelete('cascade');
            $table->dateTime('waktu_berangkat');
            $table->dateTime('waktu_datang');
            $table->decimal('harga_dasar', 12, 2);
            $table->integer('sisa_kursi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerbangans');
    }
};
