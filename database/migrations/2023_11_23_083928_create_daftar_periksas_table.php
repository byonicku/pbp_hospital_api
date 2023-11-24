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
        Schema::create('daftar_periksas', function (Blueprint $table) {
            $table->id('id_daftar_periksa');
            $table->string('nama_pasien');
            $table->string('dokter_spesialis');
            $table->string('jenis_perawatan');
            $table->string('tanggal_periksa');
            $table->string('gambar_dokter');
            $table->string('ruangan');
            $table->integer('price');
            $table->integer('status_checkin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_periksas');
    }
};
