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
        Schema::create('detail_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pemesanan')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('id_penerbangan')->constrained('penerbangans')->onDelete('cascade');
            $table->string('nama_penumpang');
            $table->string('nik', 20);
            $table->string('nomor_telepon', 15); 
            $table->string('nomor_kursi');
            $table->enum('tipe_kelas', ['ekonomi', 'first class'])->default('ekonomi');
            $table->decimal('harga_beli', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tickets');
    }
};
