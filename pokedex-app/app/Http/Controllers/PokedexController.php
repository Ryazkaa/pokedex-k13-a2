<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PokedexController extends Controller
{
    /**
     * Landing page Pokédex: hero, bento grid, tabel, dan showcase modal.
     */
    public function index(): View
    {
        $pokemons = Pokemon::query()->get()->sortBy('number')->values();

        // Pokémon unggulan di Hero Banner (diawali #0006 Charizard sesuai spesifikasi)
        $featuredOrder = ['#0006', '#0003', '#0009', '#0025', '#0150'];
        $featured = collect($featuredOrder)
            ->map(fn (string $no) => $pokemons->firstWhere('nomor_index', $no))
            ->filter()
            ->values();

        if ($featured->isEmpty()) {
            $featured = $pokemons->take(5)->values();
        }

        // Daftar generasi (urut I..IX) & tipe (urut terbanyak) untuk filter.
        $generasiList = $pokemons->sortBy('gen_number')->pluck('generasi')->unique()->values();
        $tipeCounts = $pokemons->flatMap(fn (Pokemon $p) => $p->type_list)
            ->countBy()->sortDesc();

        return view('pokedex.index', [
            'pokemons' => $pokemons,
            'featured' => $featured,
            'generasiList' => $generasiList,
            'tipeCounts' => $tipeCounts,
            'importResult' => session('import_result'),
        ]);
    }

    /**
     * Export seluruh data Pokédex ke file .xlsx dengan timestamp WIB (Asia/Jakarta).
     * Contoh nama file: Pokedex_Library_2026-11-06_19-15-30.xlsx
     */
    public function export(): StreamedResponse
    {
        $pokemons = Pokemon::query()->get()->sortBy('number')->values();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator(config('pokedex.trainer', 'Arya Andra Diazka'))
            ->setTitle('Pokedex Library')
            ->setSubject('Data Pokédex')
            ->setDescription('Export data Pokédex menggunakan PhpSpreadsheet.');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pokedex Library');

        // Header kolom sesuai spesifikasi database & Excel
        $headers = [
            'A1' => 'nomor_index',
            'B1' => 'nama_pokemon',
            'C1' => 'tipe',
            'D1' => 'generasi',
        ];

        foreach ($headers as $cell => $label) {
            $sheet->setCellValue($cell, $label);
        }

        // Styling baris header (warna #75020F dengan teks putih tebal)
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF75020F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(24);

        // Isi baris data Pokémon
        $rowNum = 2;
        foreach ($pokemons as $pokemon) {
            $sheet->setCellValueExplicit("A{$rowNum}", $pokemon->nomor_index, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$rowNum}", $pokemon->nama_pokemon);
            $sheet->setCellValue("C{$rowNum}", $pokemon->tipe);
            $sheet->setCellValue("D{$rowNum}", $pokemon->generasi);
            $rowNum++;
        }

        $lastRow = max(1, $rowNum - 1);
        $sheet->getStyle("A1:D{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD0C9CB'],
                ],
            ],
        ]);

        // Auto-size lebar kolom A..D & freeze baris header
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->freezePane('A2');

        $filename = 'Pokedex_Library_' . now('Asia/Jakarta')->format('Y-m-d_H-i-s') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            'Pragma' => 'public',
        ]);
    }

    /**
     * Import data Pokémon dari file .xlsx dengan validasi 3 status:
     * 1. Data berhasil (4 kolom valid & sesuai data Pokémon, nomor_index belum ada)
     * 2. Data ditolak / duplikat (nomor_index sudah ada di database / duplikat di file)
     * 3. Data tidak valid (ada kolom kosong atau data 4 kolom tidak memenuhi Pokémon tersebut)
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx', 'max:5120'],
        ], [
            'file_excel.required' => 'Pilih file Excel (.xlsx) terlebih dahulu.',
            'file_excel.mimes' => 'File harus berformat .xlsx.',
            'file_excel.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $file = $request->file('file_excel');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
        } catch (Throwable) {
            return back()->withErrors([
                'file_excel' => 'File Excel tidak dapat dibaca atau rusak. Pastikan menggunakan format .xlsx yang valid.',
            ]);
        }

        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        $spreadsheet->disconnectWorksheets();

        $berhasil = 0;
        $duplikat = 0;
        $tidakValid = 0;
        $newIds = [];

        $catalog = config('pokedex_catalog', []);

        // Simpan kumpulan nomor_index yang sudah ada di DB (case-insensitive)
        $existingSet = Pokemon::query()
            ->pluck('nomor_index')
            ->mapWithKeys(fn (string $no) => [strtoupper(trim($no)) => true])
            ->all();

        foreach ($rows as $index => $row) {
            $colA = trim((string) ($row[0] ?? ''));
            $colB = trim((string) ($row[1] ?? ''));
            $colC = trim((string) ($row[2] ?? ''));
            $colD = trim((string) ($row[3] ?? ''));

            // Lewati baris yang sepenuhnya kosong
            if ($colA === '' && $colB === '' && $colC === '' && $colD === '') {
                continue;
            }

            // Lewati baris pertama bila merupakan header kolom
            if ($index === 0 && $this->isHeaderRow($colA, $colB)) {
                continue;
            }

            // 1. Validasi kelengkapan 4 kolom & format nomor_index
            $nomorIndex = $this->normalizeNomorIndex($colA);
            if (
                $nomorIndex === null ||
                $colB === '' ||
                $colC === '' ||
                $colD === '' ||
                mb_strlen($nomorIndex) > 10 ||
                mb_strlen($colB) > 100 ||
                mb_strlen($colC) > 50 ||
                mb_strlen($colD) > 50
            ) {
                $tidakValid++;
                continue;
            }

            // 2. Cek duplikat berdasarkan nomor_index terlebih dahulu
            $key = strtoupper($nomorIndex);
            if (isset($existingSet[$key])) {
                $duplikat++;
                continue;
            }

            // 3. Validasi kecocokan ke-4 kolom terhadap data referensi Pokémon
            $resolved = $this->resolveAndValidatePokemon($nomorIndex, $colB, $colC, $colD, $catalog);
            if ($resolved === null) {
                $tidakValid++;
                continue;
            }

            // 4. Simpan data baru yang valid (gambar otomatis tampil berdasarkan nomor_index)
            Pokemon::create($resolved);

            $existingSet[$key] = true;
            $newIds[] = $nomorIndex;
            $berhasil++;
        }

        return to_route('pokedex.index')->with('import_result', [
            'file' => $file->getClientOriginalName(),
            'berhasil' => $berhasil,
            'duplikat' => $duplikat,
            'tidak_valid' => $tidakValid,
            'new_ids' => $newIds,
        ]);
    }

    /**
     * Pastikan ke-4 kolom memenuhi data Pokémon yang bersangkutan.
     * Jika nomor_index ada di katalog (#0001 - #0251), nama, tipe, dan generasi harus sesuai.
     */
    private function resolveAndValidatePokemon(
        string $nomorIndex,
        string $nama,
        string $tipe,
        string $generasi,
        array $catalog
    ): ?array {
        if (isset($catalog[$nomorIndex])) {
            $ref = $catalog[$nomorIndex];

            $normInputName = $this->normalizeText($nama);
            $normRefName = $this->normalizeText($ref['nama_pokemon']);

            $normInputTypes = $this->normalizeTypes($tipe);
            $normRefTypes = $this->normalizeTypes($ref['tipe']);

            $normInputGen = $this->normalizeGen($generasi);
            $normRefGen = $this->normalizeGen($ref['generasi']);

            if (
                $normInputName !== $normRefName ||
                $normInputTypes !== $normRefTypes ||
                $normInputGen !== $normRefGen
            ) {
                return null;
            }

            return [
                'nomor_index' => $nomorIndex,
                'nama_pokemon' => $ref['nama_pokemon'],
                'tipe' => $ref['tipe'],
                'generasi' => $ref['generasi'],
            ];
        }

        // Untuk Pokémon di luar #0251 (#0252 - #1025), pastikan tipe & generasi valid
        $types = $this->normalizeTypes($tipe);
        $validTypes = array_keys(config('pokedex.types', []));
        if (empty($types) || count(array_diff($types, $validTypes)) > 0) {
            return null;
        }

        if ($this->normalizeGen($generasi) === '') {
            return null;
        }

        return [
            'nomor_index' => $nomorIndex,
            'nama_pokemon' => $nama,
            'tipe' => implode(' / ', array_map('ucfirst', $types)),
            'generasi' => $generasi,
        ];
    }

    private function normalizeText(string $val): string
    {
        return strtolower(preg_replace('/[^a-z0-9]/i', '', $val));
    }

    private function normalizeTypes(string $tipe): array
    {
        $parts = preg_split('/[\/,&]+/', strtolower($tipe)) ?: [];

        return array_values(array_filter(array_map('trim', $parts)));
    }

    private function normalizeGen(string $generasi): string
    {
        $romanMap = [
            '1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V',
            '6' => 'VI', '7' => 'VII', '8' => 'VIII', '9' => 'IX',
        ];

        if (preg_match('/(?:generasi|gen)\.?\s*([ivx]+|\d+)\b/i', $generasi, $m)) {
            $token = strtoupper($m[1]);

            return $romanMap[$token] ?? $token;
        }

        return '';
    }

    /**
     * Deteksi apakah baris pertama merupakan header tabel/Excel.
     */
    private function isHeaderRow(string $colA, string $colB): bool
    {
        $a = strtolower(preg_replace('/[^a-z0-9_]/', '', $colA));
        $b = strtolower(preg_replace('/[^a-z0-9_]/', '', $colB));

        return in_array($a, ['nomor_index', 'nomorindex', 'no', 'index', 'id'], true)
            || in_array($b, ['nama_pokemon', 'namapokemon', 'nama', 'pokemon'], true);
    }

    /**
     * Normalisasi nomor_index agar konsisten dengan format "#0006".
     * Mengembalikan null bila string kosong atau tidak mengandung angka positif.
     */
    private function normalizeNomorIndex(string $raw): ?string
    {
        if ($raw === '') {
            return null;
        }

        if (preg_match('/^#?(\d{1,4})$/', $raw, $m)) {
            $num = (int) $m[1];
            if ($num <= 0 || $num > 1025) {
                return null;
            }

            return '#' . str_pad((string) $num, 4, '0', STR_PAD_LEFT);
        }

        return null;
    }
}
