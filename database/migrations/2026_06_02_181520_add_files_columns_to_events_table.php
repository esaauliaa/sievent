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
        if (
            Schema::hasColumn('events', 'poster') &&
            Schema::hasColumn('events', 'proposal') &&
            Schema::hasColumn('events', 'alasan_penolakan')
        ) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            // Kolom ini sudah ada pada migration create_events terbaru; blok ini menjaga kompatibilitas database lama.
            if (! Schema::hasColumn('events', 'poster')) {
                $table->string('poster')->nullable()->after('status');
            }

            if (! Schema::hasColumn('events', 'proposal')) {
                $table->string('proposal')->nullable()->after('poster');
            }

            if (! Schema::hasColumn('events', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('proposal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: kolom ini sekarang dimiliki oleh migration create_events.
    }
};
