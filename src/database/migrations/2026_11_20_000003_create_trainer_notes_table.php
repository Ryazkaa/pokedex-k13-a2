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
        if (!Schema::hasTable('trainer_notes')) {
            Schema::create('trainer_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('pokemon_id')->constrained('pokemons')->cascadeOnDelete();
                $table->string('title', 255)->nullable()->default('Catatan Taktis Pertarungan');
                $table->longText('content')->nullable();
                $table->date('caught_date')->nullable();
                $table->string('caught_location', 150)->nullable()->default('Wild Route');
                $table->timestamps();

                $table->unique(['user_id', 'pokemon_id']);
            });
        } else {
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
        Schema::dropIfExists('trainer_notes');
    }
};
