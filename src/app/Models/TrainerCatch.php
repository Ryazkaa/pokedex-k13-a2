<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerCatch extends Model
{
    use HasFactory;

    protected $table = 'trainer_catches';

    protected $fillable = [
'user_id',
        'pokemon_id',
        'caught_at',
        'location',
        'is_favorite',
    ];

    protected $casts = [
        'caught_at'   => 'datetime',
        'is_favorite' => 'boolean',
    ];

    /**
     * Relasi ke trainer pemilik tangkapan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke data Pokémon master.
     */
    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }
}