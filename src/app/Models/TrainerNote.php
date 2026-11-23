<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerNote extends Model
{
    use HasFactory;

    protected $table = 'trainer_notes';

    protected $fillable = [
        'user_id',
        'pokemon_id',
        'title',
        'content',
        'caught_date',
        'caught_location',
    ];

    protected $casts = [
        'caught_date' => 'date',
    ];

    /**
     * Relasi ke trainer pembuat catatan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke data Pokémon terkait.
     */
    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }
}
