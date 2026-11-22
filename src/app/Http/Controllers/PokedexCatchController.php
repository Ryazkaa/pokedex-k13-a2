<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\TrainerCatch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PokedexCatchController extends Controller
{
    /**
     * Menyimpan Pokémon ke koleksi pribadi trainer dari Modal Tambah Koleksi (PokéAPI).
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $validated = $request->validate([
            'nomor_index'  => ['required', 'string'],
            'nama_pokemon' => ['required', 'string', 'max:100'],
            'tipe_1'       => ['required', 'string', 'max:50'],
            'tipe_2'       => ['nullable', 'string', 'max:50'],
'generasi'     => ['required', 'string', 'max:100'],
            'sprite_url'   => ['nullable', 'string'],
        ]);

        // Format nomor indeks (#0001)
        $cleanDigits = preg_replace('/\D/', '', $validated['nomor_index']);
        $idxFormatted = '#' . str_pad($cleanDigits ?: '1', 4, '0', STR_PAD_LEFT);

        // Gabungkan tipe
        $tipe = $validated['tipe_1'];
        if (!empty($validated['tipe_2']) && $validated['tipe_2'] !== '-- Tidak Ada --') {
            $tipe .= '/' . $validated['tipe_2'];
        }

        $sprite = $validated['sprite_url'] ?: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$cleanDigits}.png";

        // Pastikan ada di master Pokemon
        $pokemon = Pokemon::firstOrCreate(
            ['nomor_index' => $idxFormatted],
            [
                'nama_pokemon' => $validated['nama_pokemon'],
                'tipe'         => $tipe,
                'generasi'     => $validated['generasi'],
                'sprite_url'   => $sprite,
            ]
        );

        // Tambahkan ke koleksi trainer aktif
        $catch = TrainerCatch::firstOrCreate(
            [
                'user_id'    => Auth::id(),
                'pokemon_id' => $pokemon->id,
            ],
            [
                'caught_at'   => now(),
                'location'    => 'Wild Encounter',
                'is_favorite' => false,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => "{$pokemon->nama_pokemon} berhasil ditambahkan ke Pokédex Koleksi Anda!",
            'pokemon' => $pokemon
        ]);
    }

    /**
     * Hapus Pokémon dari koleksi pribadi trainer.
     */
    public function destroy($pokemonId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        TrainerCatch::where('user_id', Auth::id())
            ->where('pokemon_id', $pokemonId)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Pokémon dihapus dari koleksi Anda.']);
    }

    /**
     * Toggle status favorit pada koleksi tangkapan.
     */
    public function toggleFavorite($pokemonId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $catch = TrainerCatch::where('user_id', Auth::id())
            ->where('pokemon_id', $pokemonId)
            ->firstOrFail();

        $catch->update(['is_favorite' => !$catch->is_favorite]);

        return response()->json([
            'success' => true,
            'is_favorite' => $catch->is_favorite,
            'message' => $catch->is_favorite ? 'Ditambahkan ke Pokémon Favorit!' : 'Dihapus dari Favorit.'
        ]);
    }

    /**
     * Ekspor daftar koleksi tangkapan trainer ke Excel (.xlsx).
     */
    public function exportExcel()
    {
        $userId = Auth::id() ?: 1;
        $user = Auth::user();
        $catches = TrainerCatch::with('pokemon')->where('user_id', $userId)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Koleksi Pokédex');

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Index');
        $sheet->setCellValue('C1', 'Nama Pokémon');
        $sheet->setCellValue('D1', 'Tipe Elemen');
        $sheet->setCellValue('E1', 'Generasi');
        $sheet->setCellValue('F1', 'Tanggal Tangkap');
        $sheet->setCellValue('G1', 'Lokasi Penangkapan');

        $rowNum = 2;
        foreach ($catches as $idx => $catch) {
            $sheet->setCellValue('A' . $rowNum, $idx + 1);
            $sheet->setCellValue('B' . $rowNum, $catch->pokemon->nomor_index);
            $sheet->setCellValue('C' . $rowNum, $catch->pokemon->nama_pokemon);
            $sheet->setCellValue('D' . $rowNum, $catch->pokemon->tipe);
            $sheet->setCellValue('E' . $rowNum, $catch->pokemon->generasi);
            $sheet->setCellValue('F' . $rowNum, $catch->caught_at->format('Y-m-d H:i'));
            $sheet->setCellValue('G' . $rowNum, $catch->location);
            $rowNum++;
        }

        $filename = 'Pokedex_Koleksi_' . ($user ? str_replace(' ', '_', $user->name) : 'Trainer') . '_' . date('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Unduh Laporan Resmi Koleksi Pokédex format PDF berstandar A4 (DomPDF).
     */
    public function exportPdf()
    {
        $userId = Auth::id() ?: 1;
        $user = Auth::user();
        $catches = TrainerCatch::with('pokemon')->where('user_id', $userId)->orderBy('id', 'asc')->get();

        $data = [
            'trainer' => $user ?: (object)['name' => 'Arya Andra Diazka', 'trainer_class' => 'Lead Architect', 'role' => 'developer'],
            'catches' => $catches,
            'generated_at' => now()->translatedFormat('d F Y - H:i') . ' WIB',
            'total_caught' => $catches->count(),
        ];

        $pdf = Pdf::loadView('pokedex.reports.pokedex-pdf', $data)->setPaper('a4', 'portrait');
        $filename = 'Laporan_Pokedex_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}