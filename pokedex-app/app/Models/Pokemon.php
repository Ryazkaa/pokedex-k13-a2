<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = ['nomor_index', 'nama_pokemon', 'tipe', 'generasi'];

    private const ROMAN = ['I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5, 'VI' => 6, 'VII' => 7, 'VIII' => 8, 'IX' => 9];

    private const SPRITE_BASE = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon';

    /** "#0006" -> 6 */
    public function getNumberAttribute(): int
    {
        return (int) preg_replace('/\D/', '', $this->nomor_index);
    }

    /** "Fire / Flying" -> ['Fire', 'Flying'] */
    public function getTypeListAttribute(): array
    {
        return array_values(array_filter(array_map('trim', explode('/', $this->tipe))));
    }

    /** "Generasi I (Kanto)" -> "I" */
    public function getGenRomanAttribute(): string
    {
        if (! preg_match('/(?:generasi|gen)\.?\s*([ivx]+|\d+)\b/i', $this->generasi, $m)) {
            return '';
        }

        // Mendukung "Generasi 1" maupun "Generasi I".
        return is_numeric($m[1])
            ? (array_search((int) $m[1], self::ROMAN, true) ?: '')
            : strtoupper($m[1]);
    }

    public function getGenNumberAttribute(): int
    {
        return self::ROMAN[$this->gen_roman] ?? 0;
    }

    /** "Generasi I (Kanto)" -> "Kanto" */
    public function getRegionAttribute(): string
    {
        if (preg_match('/\(([^)]+)\)/', $this->generasi, $m)) {
            return trim($m[1]);
        }

        return config("pokedex.regions.{$this->gen_roman}.name", '-');
    }

    public function getArtworkUrlAttribute(): string
    {
        return self::SPRITE_BASE."/other/official-artwork/{$this->number}.png";
    }

    public function getSpriteUrlAttribute(): string
    {
        return self::SPRITE_BASE."/{$this->number}.png";
    }

    /** Deskripsi resmi Bahasa Indonesia dari katalog Pokédex (id.portal-pokemon.com). */
    public function getDeskripsiAttribute(): string
    {
        return (string) config("pokedex_catalog.{$this->nomor_index}.deskripsi", '');
    }

    /** Data ringkas untuk JavaScript (search, filter, showcase). */
    public function toClient(): array
    {
        return [
            'no' => $this->nomor_index,
            'num' => $this->number,
            'name' => $this->nama_pokemon,
            'tipe' => $this->tipe,
            'types' => $this->type_list,
            'generasi' => $this->generasi,
            'gen' => $this->gen_roman,
            'genNum' => $this->gen_number,
            'region' => $this->region,
            'lore' => $this->deskripsi,
        ];
    }
}
