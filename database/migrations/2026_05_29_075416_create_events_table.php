<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('ruangans')->onDelete('cascade');

            $table->date('tanggal_pengajuan');
            $table->string('nama_event');
            $table->text('deskripsi');

            $table->date('tanggal_pelaksanaan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');

            $table->integer('kuota');

            $table->string('poster')->nullable();
            $table->string('proposal')->nullable();

            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');

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