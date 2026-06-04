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
        Schema::table('events', function (Blueprint $table) {
            // Menambahkan kolom poster, proposal, dan alasan_penolakan agar sinkron dengan Controller & Model
            $table->string('poster')->nullable()->after('status');
            $table->string('proposal')->nullable()->after('poster');
            $table->text('alasan_penolakan')->nullable()->after('proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['poster', 'proposal', 'alasan_penolakan']);
        });
    }
};