<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('peserta_events', 'status_kehadiran')) {
            Schema::table('peserta_events', function (Blueprint $table) {
                $table->string('status_kehadiran')->default('belum_hadir')->after('tanggal_daftar');
            });
        }

        if (! Schema::hasColumn('peserta_events', 'waktu_presensi')) {
            Schema::table('peserta_events', function (Blueprint $table) {
                $table->timestamp('waktu_presensi')->nullable()->after('status_kehadiran');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('peserta_events', 'waktu_presensi')) {
            Schema::table('peserta_events', function (Blueprint $table) {
                $table->dropColumn('waktu_presensi');
            });
        }

        if (Schema::hasColumn('peserta_events', 'status_kehadiran')) {
            Schema::table('peserta_events', function (Blueprint $table) {
                $table->dropColumn('status_kehadiran');
            });
        }
    }
};
