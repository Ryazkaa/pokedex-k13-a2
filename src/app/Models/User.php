<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'trainer_class',
        'avatar_badge',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Memeriksa apakah user merupakan developer tim pengembang.
     */
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    /**
     * Memastikan akun evaluasi dosen (Developer & Basic Trainer) tersedia dengan role yang sesuai.
     */
    public static function syncEvaluationAccounts(): void
    {
        $accounts = [
            'developer@gmail.com' => [
                'name'          => 'Developer K13',
                'password'      => '123456',
                'role'          => 'developer',
                'trainer_class' => 'Developer Admin',
                'avatar_badge'  => 'badge_dev.png',
            ],
            'basic@gmail.com' => [
                'name'          => 'Basic Trainer',
                'password'      => '123456',
                'role'          => 'trainer',
                'trainer_class' => 'Pokemon Trainer',
                'avatar_badge'  => 'badge_trainer.png',
            ],
        ];

        foreach ($accounts as $email => $cfg) {
            $user = self::firstOrCreate(
                ['email' => $email],
                [
                    'name'          => $cfg['name'],
                    'password'      => Hash::make($cfg['password']),
                    'role'          => $cfg['role'],
                    'trainer_class' => $cfg['trainer_class'],
                    'avatar_badge'  => $cfg['avatar_badge'],
                ]
            );

            if ($user->role !== $cfg['role']) {
                $user->update([
                    'role'          => $cfg['role'],
                    'trainer_class' => $cfg['trainer_class'],
                ]);
            }
        }
    }

    /**
     * Relasi ke daftar tangkapan Pokédex milik trainer ini (Modul Madina).
     */
    public function trainerCatches(): HasMany
    {
        return $this->hasMany(TrainerCatch::class, 'user_id');
    }

    /**
     * Relasi ke catatan taktis & jurnal lapangan trainer ini (Modul Iasha).
     */
    public function trainerNotes(): HasMany
    {
        return $this->hasMany(TrainerNote::class, 'user_id');
    }
}
