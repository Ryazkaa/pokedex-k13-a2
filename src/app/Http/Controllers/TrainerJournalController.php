<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\TrainerNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerJournalController extends Controller
{
    /**
     * Mengambil data catatan taktis trainer untuk Pokémon tertentu via AJAX.
     */
    public function show($pokemonId)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => true,
                'note'    => null,
            ]);
        }

        $note = TrainerNote::where('user_id', $userId)
            ->where('pokemon_id', $pokemonId)
            ->first();

        return response()->json([
            'success' => true,
            'note' => $note ? [
                'title'           => $note->title,
                'content'         => $note->content,
                'caught_date'     => $note->caught_date ? $note->caught_date->format('Y-m-d') : null,
                'caught_location' => $note->caught_location,
                'updated_at'      => $note->updated_at ? $note->updated_at->diffForHumans() : null,
            ] : null,
        ]);
    }

    /**
     * Menyimpan atau memperbarui catatan taktis lapangan.
     */
    public function store(Request $request, $pokemonId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masuk atau daftar akun Trainer terlebih dahulu untuk menyimpan catatan taktis.'
            ], 401);
        }

        $pokemon = Pokemon::find($pokemonId);
        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pokémon tidak ditemukan di database.'
            ], 404);
        }

        $validated = $request->validate([
            'title'           => ['nullable', 'string', 'max:255'],
            'content'         => ['nullable', 'string'],
            'caught_date'     => ['nullable', 'date'],
            'caught_location' => ['nullable', 'string', 'max:150'],
        ]);

        // Sanitasi HTML Anti-XSS (mengizinkan tag aman untuk format tulisan)
        $cleanContent = strip_tags(
            $validated['content'] ?? '',
            '<p><br><strong><em><u><ol><ul><li><blockquote><h1><h2><h3>'
        );

        $caughtDate = !empty($validated['caught_date']) ? $validated['caught_date'] : null;
        $caughtLocation = !empty($validated['caught_location']) ? trim($validated['caught_location']) : 'Wild Route';
        $title = !empty($validated['title']) ? trim($validated['title']) : 'Catatan Taktis: ' . $pokemon->nama_pokemon;

        $note = TrainerNote::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'pokemon_id' => $pokemon->id,
            ],
            [
                'title'           => $title,
                'content'         => $cleanContent,
                'caught_date'     => $caughtDate,
                'caught_location' => $caughtLocation,
            ]
        );

        return response()->json([
            'success'      => true,
            'message'      => 'Jurnal taktis dan strategi bertarung untuk ' . $pokemon->nama_pokemon . ' berhasil disimpan!',
            'pokemon_name' => $pokemon->nama_pokemon,
            'note'         => $note,
        ]);
    }

    /**
     * Menghapus catatan taktis.
     */
    public function destroy($pokemonId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $pokemon = Pokemon::find($pokemonId);
        $deleted = TrainerNote::where('user_id', Auth::id())
            ->where('pokemon_id', $pokemonId)
            ->delete();

        return response()->json([
            'success'      => true,
            'message'      => 'Catatan jurnal taktis ' . ($pokemon ? $pokemon->nama_pokemon : '') . ' berhasil dihapus dari Pokédex Anda.',
            'pokemon_name' => $pokemon ? $pokemon->nama_pokemon : null,
        ]);
    }
}
