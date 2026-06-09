<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel ruangans.
     */
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->string('nama_ruangan', 100);
            $table->string('lokasi', 150);
            $table->integer('kapasitas');
            $table->enum('status_ruangan', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel ruangans.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
