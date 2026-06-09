<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            // Menggunakan id_event sebagai primary key agar sinkron dengan model dan controller
            $table->id('id_event');

            // Menyesuaikan nama kolom foreign key agar pas dengan relasi database ($request->id_ruangan)
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_ruangan');

            $table->date('tanggal_pengajuan');
            $table->string('nama_event');
            $table->text('deskripsi')->nullable();

            $table->date('tanggal_pelaksanaan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');

            $table->integer('kuota');

            // Menggunakan properti nullable() yang aman dari eror field doesn't have a default value
            $table->string('poster')->nullable();
            $table->string('proposal')->nullable();

            // Menyesuaikan string status dengan logika perizinan pada aplikasi
            $table->string('status')->default('pending'); // pending, disetujui, ditolak

            $table->text('alasan_penolakan')->nullable();

            $table->boolean('is_delete')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};