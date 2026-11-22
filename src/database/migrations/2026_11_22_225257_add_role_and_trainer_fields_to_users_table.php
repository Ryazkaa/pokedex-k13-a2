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
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['developer', 'trainer'])->default('trainer')->after('password');
            }
            if (!Schema::hasColumn('users', 'trainer_class')) {
                $table->string('trainer_class', 60)->default('Pokemon Trainer')->after('role');
            }
            if (!Schema::hasColumn('users', 'avatar_badge')) {
                $table->string('avatar_badge', 100)->nullable()->after('trainer_class');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'trainer_class', 'avatar_badge']);
        });
    }
};
