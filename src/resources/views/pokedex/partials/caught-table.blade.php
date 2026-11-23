{{-- Tabel Koleksi Pokédex DataTables & Ekspor (Madina Dwiyana Putri) --}}
@php
    $caughtList = $caughtList ?? \App\Models\TrainerCatch::with('pokemon')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();
@endphp
<section id="pokedex-caught" class="pokedex section" style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 36px;">
    <div class="pokedex__head" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <p class="section-kicker" style="color: #10B981; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; margin: 0 0 4px 0;">Pokédex Collection Tracker</p>
            <h2 class="section-title section-title--lg" style="margin: 0; font-size: 1.8rem; color: #F1F5F9;">Koleksi Tangkapan Trainer</h2>
            <p style="color: #94A3B8; font-size: 0.9rem; margin: 4px 0 0 0;">Daftar Pokémon yang berhasil Anda tangkap di lapangan, lengkap dengan lokasi dan catatan strategi.</p>
        </div>

        {{-- Toolbar Tombol Aksi --}}
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="btn btn--primary" onclick="document.getElementById('addCaughtModal').hidden = false"
                    style="background: #2563EB; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                <span>+</span> Tambah Koleksi
            </button>
            <a href="{{ route('pokedex.exportExcel') }}" class="btn btn--subtle"
               style="background: rgba(16, 185, 129, 0.15); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">
                📊 Ekspor Excel
            </a>
            <a href="{{ route('pokedex.exportPdf') }}" class="btn btn--subtle"
               style="background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">
                📄 Unduh Laporan PDF
            </a>
        </div>
    </div>

    {{-- Container DataTables --}}
    <div class="table-wrap" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 16px;">
        <table id="caughtDataTable" class="dex-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left; color: #94A3B8; font-size: 0.85rem;">
                    <th style="padding: 12px;">NO INDEX</th>
                    <th style="padding: 12px;">SPRITE</th>
                    <th style="padding: 12px;">NAMA POKÉMON</th>
                    <th style="padding: 12px;">TIPE</th>
                    <th style="padding: 12px;">GENERASI</th>
                    <th style="padding: 12px;">TANGGAL TANGKAP</th>
                    <th style="padding: 12px; text-align: center;">AKSI & JURNAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($caughtList ?? [] as $catch)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); color: #F1F5F9;">
                        <td style="padding: 12px; font-family: monospace; font-weight: 700; color: #38BDF8;">
                            {{ $catch->pokemon->nomor_index }}
                        </td>
                        <td style="padding: 12px;">
                            <img src="{{ $catch->pokemon->sprite_url }}" alt="{{ $catch->pokemon->nama_pokemon }}" width="40" height="40" style="image-rendering: pixelated;">
                        </td>
                        <td style="padding: 12px; font-weight: 600;">
                            {{ $catch->pokemon->nama_pokemon }}
                        </td>
                        <td style="padding: 12px;">
                            <span style="background: rgba(255,255,255,0.08); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">
                                {{ $catch->pokemon->tipe }}
                            </span>
                        </td>
                        <td style="padding: 12px; font-size: 0.85rem; color: #94A3B8;">
                            {{ $catch->pokemon->generasi }}
                        </td>
                        <td style="padding: 12px; font-size: 0.85rem; color: #94A3B8;">
                            {{ $catch->caught_at ? $catch->caught_at->format('d M Y') : '-' }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <button type="button" class="btn btn--subtle" onclick="openJournalModal('{{ $catch->pokemon_id }}', '{{ $catch->pokemon->nama_pokemon }}', '{{ $catch->pokemon->sprite_url }}')"
                                    style="padding: 4px 10px; font-size: 0.78rem; border-radius: 4px; background: rgba(56, 189, 248, 0.15); color: #38BDF8; border: 1px solid rgba(56, 189, 248, 0.3);">
                                📝 Catat Taktik
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 32px; text-align: center; color: #94A3B8;">
                            Belum ada Pokémon yang dikoleksi. Klik tombol <strong>+ Tambah Koleksi</strong> di atas untuk menambahkan tangkapan pertama Anda via PokéAPI!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@push('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    if ($('#caughtDataTable tbody tr td[colspan]').length === 0) {
        $('#caughtDataTable').DataTable({ pageLength: 10, order: [[0, 'asc']] });
    }
});
</script>
@endpush