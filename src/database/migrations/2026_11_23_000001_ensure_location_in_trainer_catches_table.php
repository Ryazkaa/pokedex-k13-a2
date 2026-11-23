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
        if (Schema::hasTable('trainer_catches')) {
            Schema::table('trainer_catches', function (Blueprint $table) {
                if (!Schema::hasColumn('trainer_catches', 'location')) {
                    $table->string('location', 150)->nullable()->default('Kanto Route 1')->after('caught_at');
                }
                if (!Schema::hasColumn('trainer_catches', 'is_favorite')) {
                    $table->boolean('is_favorite')->default(false)->after('location');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('trainer_catches')) {
            Schema::table('trainer_catches', function (Blueprint $table) {
                if (Schema::hasColumn('trainer_catches', 'location')) {
                    $table->dropColumn('location');
                }
            });
        }
    }
};
