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
        if (Schema::hasTable('trainer_notes')) {
            Schema::table('trainer_notes', function (Blueprint $table) {
                if (!Schema::hasColumn('trainer_notes', 'caught_date')) {
                    $table->date('caught_date')->nullable()->after('content');
                }
                if (!Schema::hasColumn('trainer_notes', 'caught_location')) {
                    $table->string('caught_location', 150)->nullable()->default('Wild Route')->after('caught_date');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('trainer_notes')) {
            Schema::table('trainer_notes', function (Blueprint $table) {
                if (Schema::hasColumn('trainer_notes', 'caught_location')) {
                    $table->dropColumn('caught_location');
                }
                if (Schema::hasColumn('trainer_notes', 'caught_date')) {
                    $table->dropColumn('caught_date');
                }
            });
        }
    }
};
