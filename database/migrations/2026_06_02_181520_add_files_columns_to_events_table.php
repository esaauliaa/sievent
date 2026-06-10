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
            if (!Schema::hasColumn('events', 'poster')) {
                $table->string('poster')->nullable()->after('status');
            }
            if (!Schema::hasColumn('events', 'proposal')) {
                $table->string('proposal')->nullable()->after('poster');
            }
            if (!Schema::hasColumn('events', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('proposal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $columns = [];
            
            if (Schema::hasColumn('events', 'poster')) {
                $columns[] = 'poster';
            }
            if (Schema::hasColumn('events', 'proposal')) {
                $columns[] = 'proposal';
            }
            if (Schema::hasColumn('events', 'alasan_penolakan')) {
                $columns[] = 'alasan_penolakan';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};