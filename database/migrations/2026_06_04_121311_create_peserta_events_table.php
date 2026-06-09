<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Pastikan menggunakan Schema::create, bukan Route::create
        Schema::create('peserta_events', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_user'); 
            $table->date('tanggal_daftar');
            $table->timestamps();

            // Foreign key ke tabel events
            $table->foreign('id_event')->references('id_event')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_events');
    }
};
