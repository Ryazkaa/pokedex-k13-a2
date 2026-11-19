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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'trainer_class')) {
                $table->string('trainer_class')->default('Trainer')->after('password');
            }
            if (!Schema::hasColumn('users', 'avatar_badge')) {
                $table->string('avatar_badge')->default('pokeball')->after('trainer_class');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['trainer_class', 'avatar_badge']);
        });
    }
};
