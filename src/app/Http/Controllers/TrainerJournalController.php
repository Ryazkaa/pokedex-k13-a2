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
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $validated = $request->validate([
            'title'           => ['nullable', 'string', 'max:255'],
            'content'         => ['nullable', 'string'],
            'caught_date'     => ['nullable', 'date'],
            'caught_location' => ['nullable', 'string', 'max:150'],
        ]);

        // Sanitasi HTML Anti-XSS (mengizinkan tag aman untuk formatting teks)
        $cleanContent = strip_tags(
            $validated['content'] ?? '',
            '<p><br><strong><em><u><ol><ul><li><blockquote><h1><h2><h3>'
        );

        $note = TrainerNote::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'pokemon_id' => $pokemonId,
            ],
            [
                'title'           => $validated['title'] ?: 'Catatan Taktis Pertarungan',
                'content'         => $cleanContent,
                'caught_date'     => $validated['caught_date'] ?: null,
                'caught_location' => $validated['caught_location'] ?: 'Wild Encounter',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jurnal taktik dan catatan lapangan berhasil disimpan!',
            'note'    => $note,
        ]);
    }

    /**
     * Menghapus catatan taktis.
     */
    public function destroy($pokemonId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        TrainerNote::where('user_id', Auth::id())
            ->where('pokemon_id', $pokemonId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catatan jurnal berhasil dihapus.',
        ]);
    }
}
