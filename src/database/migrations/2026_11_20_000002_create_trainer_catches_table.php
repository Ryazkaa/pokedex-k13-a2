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
        if (!Schema::hasTable('trainer_catches')) {
            Schema::create('trainer_catches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('pokemon_id')->constrained('pokemons')->cascadeOnDelete();
                $table->timestamp('caught_at')->useCurrent();
                $table->string('location', 150)->nullable()->default('Kanto Route 1');
                $table->boolean('is_favorite')->default(false);
                $table->timestamps();

                $table->unique(['user_id', 'pokemon_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_catches');
    }
};