<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_user'); // ID Mahasiswa yang mendaftar
            $table->enum('status_kehadiran', ['belum hadir', 'hadir'])->default('belum hadir');
            $table->timestamp('waktu_presensi')->nullable();
            $table->timestamps();

            // Hubungkan relasi ke tabel events dan users
            $table->foreign('id_event')->references('id_event')->on('events')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};