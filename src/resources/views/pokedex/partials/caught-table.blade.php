{{-- Tabel Koleksi Pokédex DataTables & Ekspor (Madina Dwiyana Putri & Arya Andra Diazka) --}}
@php
    $caughtList = $caughtList ?? \App\Models\TrainerCatch::with('pokemon')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();
@endphp
<section id="pokedex-caught" class="pokedex section" style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 36px;">
    <div class="pokedex__head" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <p class="section-kicker" style="color: #10B981; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; margin: 0 0 4px 0;" data-i18n="caught_kicker">Pokédex Collection Tracker</p>
            <h2 class="section-title section-title--lg" style="margin: 0; font-size: 1.8rem; color: #F1F5F9;" data-i18n="caught_title">Koleksi Tangkapan Trainer</h2>
            <p style="color: #94A3B8; font-size: 0.9rem; margin: 4px 0 0 0;" data-i18n="caught_subtitle">Daftar Pokémon yang berhasil Anda tangkap di lapangan, lengkap dengan lokasi dan catatan strategi.</p>
        </div>

        {{-- Toolbar Tombol Aksi --}}
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @auth
                <button type="button" class="btn btn--primary" onclick="openAddCaughtModal()"
                        style="background: var(--crimson, #ff4655); border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(255, 70, 85, 0.35); cursor: pointer; color: #fff;">
                    <span style="font-size: 1.1rem; line-height: 1;">+</span> <span data-i18n="btn_add_collection">Tambah Koleksi</span>
                </button>
            @else
                <button type="button" class="btn btn--primary" onclick="openCaughtAuthPromptModal()"
                        style="background: var(--crimson, #ff4655); border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(255, 70, 85, 0.35); cursor: pointer; color: #fff;"
                        title="Perlu Login untuk Tambah Koleksi">
                    <span style="font-size: 1.1rem; line-height: 1;">+</span> <span data-i18n="btn_add_collection">Tambah Koleksi</span>
                </button>
            @endauth
            <a href="{{ route('pokedex.exportExcel') }}" class="btn btn--subtle"
               style="background: rgba(16, 185, 129, 0.15); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span data-i18n="btn_export_excel">Ekspor Excel</span>
            </a>
            <a href="{{ route('pokedex.exportPdf') }}" class="btn btn--subtle"
               style="background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M10 12h2a2 2 0 0 1 0 4h-2v-4z"/></svg>
                <span data-i18n="btn_export_pdf">Unduh Laporan PDF</span>
            </a>
        </div>
    </div>

    {{-- Container DataTables --}}
    <div class="table-wrap" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 16px;">
        <table id="caughtDataTable" class="dex-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left; color: #94A3B8; font-size: 0.85rem;">
                    <th style="padding: 12px;" data-i18n="th_no_index">NO INDEX</th>
                    <th style="padding: 12px;" data-i18n="th_sprite">SPRITE</th>
                    <th style="padding: 12px;" data-i18n="th_pokemon_name">NAMA POKÉMON</th>
                    <th style="padding: 12px;" data-i18n="th_type">TIPE</th>
                    <th style="padding: 12px;" data-i18n="th_generation">GENERASI</th>
                    <th style="padding: 12px;" data-i18n="th_caught_date">TANGGAL TANGKAP</th>
                    <th style="padding: 12px; text-align: center;" data-i18n="th_actions">AKSI &amp; JURNAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($caughtList ?? [] as $catch)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); color: #F1F5F9;" id="caught-row-{{ $catch->pokemon_id }}">
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
                        <td style="padding: 12px; font-size: 0.85rem; color: #94A3B8;" id="caught-date-val-{{ $catch->pokemon_id }}">
                            {{ $catch->caught_at ? $catch->caught_at->format('d M Y') : '-' }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <div style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap; justify-content: center;">
                                {{-- Tombol Edit Tanggal --}}
                                <button type="button" class="btn btn--subtle"
                                        onclick="openEditCaughtDateModal('{{ $catch->pokemon_id }}', '{{ addslashes($catch->pokemon->nama_pokemon) }}', '{{ $catch->caught_at ? $catch->caught_at->format('Y-m-d') : date('Y-m-d') }}', '{{ $catch->pokemon->sprite_url }}')"
                                        style="padding: 4px 8px; font-size: 0.76rem; border-radius: 6px; background: rgba(245, 158, 11, 0.15); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.35); cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"
                                        title="Edit Tanggal Penangkapan">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    <span data-i18n="btn_edit_date">Tanggal</span>
                                </button>
                                {{-- Tombol Hapus Koleksi --}}
                                <button type="button" class="btn btn--subtle"
                                        onclick="confirmDeleteCaught('{{ $catch->pokemon_id }}', '{{ addslashes($catch->pokemon->nama_pokemon) }}', '{{ $catch->pokemon->sprite_url }}')"
                                        style="padding: 4px 8px; font-size: 0.76rem; border-radius: 6px; background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.35); cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"
                                        title="Hapus Tangkapan dari Pokédex">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    <span data-i18n="btn_delete">Hapus</span>
                                </button>
                                {{-- Tombol Jurnal Taktik --}}
                                <button type="button" class="btn btn--subtle"
                                        onclick="if(typeof openJournalModal === 'function'){ openJournalModal('{{ $catch->pokemon_id }}', '{{ addslashes($catch->pokemon->nama_pokemon) }}', '{{ $catch->pokemon->sprite_url }}'); } else { alert('Modul Jurnal Trainer segera hadir!'); }"
                                        style="padding: 4px 8px; font-size: 0.76rem; border-radius: 6px; background: rgba(56, 189, 248, 0.15); color: #38BDF8; border: 1px solid rgba(56, 189, 248, 0.35); cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"
                                        title="Buka Catatan Jurnal Taktik">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                    <span data-i18n="btn_tactics">Taktik</span>
                                </button>
                            </div>
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

{{-- MODAL 1: EDIT TANGGAL PENANGKAPAN POKÉMON --}}
<div id="editCaughtDateModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="editCaughtDateTitle" hidden>
    <div class="pkm-modal__backdrop" onclick="closeEditCaughtDateModal()"></div>
    <div class="pkm-modal__dialog" style="max-width: 440px; background: #0f1923; color: #f1f5f9; border-radius: 14px; overflow: hidden; border: 1px solid rgba(245, 158, 11, 0.4); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(245, 158, 11, 0.2); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <div class="pkm-modal__header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(245, 158, 11, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#FBBF24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <div>
                    <h3 id="editCaughtDateTitle" style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;" data-i18n="modal_edit_caught_title">Edit Tanggal Tangkap</h3>
                    <p style="margin: 2px 0 0 0; font-size: 0.76rem; color: #94a3b8;" data-i18n="modal_edit_caught_subtitle">Ubah riwayat tanggal penangkapan Pokémon</p>
                </div>
            </div>
            <button type="button" onclick="closeEditCaughtDateModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form id="formEditCaughtDate" onsubmit="event.preventDefault(); submitEditCaughtDate();" style="padding: 20px;">
            <input type="hidden" id="editCaughtPokemonId">

            <div style="display: flex; align-items: center; gap: 14px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 14px; margin-bottom: 16px;">
                <img id="editCaughtPokemonSprite" src="" alt="Sprite" width="48" height="48" style="image-rendering: pixelated;">
                <div>
                    <h4 id="editCaughtPokemonName" style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Pokémon</h4>
                    <span style="font-size: 0.75rem; color: #38BDF8;">Informasi identitas master dikunci</span>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="editCaughtAtInput" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;" data-i18n="lbl_edit_caught_at">
                    Tanggal Penangkapan Baru
                </label>
                <input type="date" id="editCaughtAtInput" required
                       class="text-input" style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 8px; color: #ffffff; font-size: 1rem; outline: none; color-scheme: dark;">
                <small style="display: block; margin-top: 6px; font-size: 0.74rem; color: #94a3b8;" data-i18n="format_dmy_hint">Format: Tanggal - Bulan - Tahun (DD/MM/YYYY)</small>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 16px;">
                <button type="button" onclick="closeEditCaughtDateModal()"
                        style="padding: 9px 16px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; font-weight: 600; color: #94a3b8; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" id="btnSaveEditCaughtDate"
                        style="padding: 9px 20px; font-weight: 700; font-size: 0.88rem; border-radius: 8px; background: #F59E0B; color: #000; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 2: KONFIRMASI HAPUS KOLEKSI POKÉMON --}}
<div id="deleteCaughtModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="deleteCaughtTitle" hidden>
    <div class="pkm-modal__backdrop" onclick="closeDeleteCaughtModal()"></div>
    <div class="pkm-modal__dialog" style="max-width: 420px; text-align: center; padding: 28px 22px; background: #0f1923; color: #f1f5f9; border-radius: 14px; border: 1px solid rgba(239, 68, 68, 0.45); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(239, 68, 68, 0.25); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <input type="hidden" id="deleteCaughtPokemonId">

        <div style="width: 68px; height: 68px; border-radius: 50%; background: rgba(239, 68, 68, 0.12); border: 2px solid #ef4444; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
            <svg viewBox="0 0 24 24" style="width: 34px; height: 34px; color: #ef4444;" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        </div>

        <h3 id="deleteCaughtTitle" style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0;">
            Hapus Koleksi Pokémon?
        </h3>

        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin: 12px 0 16px 0; background: rgba(255, 255, 255, 0.04); border-radius: 8px; padding: 8px 12px;">
            <img id="deleteCaughtPokemonSprite" src="" alt="Sprite" width="38" height="38" style="image-rendering: pixelated;">
            <strong id="deleteCaughtPokemonName" style="color: #fff; font-size: 1rem;">Pokémon</strong>
        </div>

        <p style="font-size: 0.85rem; color: #CBD5E1; line-height: 1.5; margin: 0 0 22px 0;">
            Pokémon ini akan dihapus dari buku koleksi tangkapan Anda. Data master di Library utama tetap aman dan tidak akan terhapus.
        </p>

        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="closeDeleteCaughtModal()"
                    style="flex: 1; padding: 10px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; font-weight: 600; color: #94A3B8; cursor: pointer;">
                Batal
            </button>
            <button type="button" id="btnConfirmDeleteCaught" onclick="executeDeleteCaught()"
                    style="flex: 1; padding: 10px; background: #ef4444; border: none; border-radius: 8px; font-weight: 700; color: #fff; cursor: pointer; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.4);">
                Ya, Hapus Sekarang
            </button>
        </div>
    </div>
</div>

@push('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    if ($('#caughtDataTable tbody tr td[colspan]').length === 0) {
        $('#caughtDataTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']],
            language: {
                search: "Cari Koleksi:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ koleksi",
                infoEmpty: "Koleksi kosong",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            }
        });
    }
});

// Logic Modal Edit Tanggal Tangkap
window.openEditCaughtDateModal = function(pokemonId, pokemonName, currentDate, spriteUrl) {
    document.getElementById('editCaughtPokemonId').value = pokemonId;
    document.getElementById('editCaughtPokemonName').textContent = pokemonName;
    document.getElementById('editCaughtPokemonSprite').src = spriteUrl || '';
    document.getElementById('editCaughtAtInput').value = currentDate || new Date().toISOString().split('T')[0];
    document.getElementById('editCaughtDateModal').hidden = false;
};

window.closeEditCaughtDateModal = function() {
    document.getElementById('editCaughtDateModal').hidden = true;
};

window.submitEditCaughtDate = async function() {
    const pokemonId = document.getElementById('editCaughtPokemonId').value;
    const newDate = document.getElementById('editCaughtAtInput').value;
    const btn = document.getElementById('btnSaveEditCaughtDate');
    const origText = btn.innerHTML;

    if (!newDate) {
        if (typeof window.showCaughtFeedback === 'function') {
            window.showCaughtFeedback(false, 'Tanggal Kosong', 'Harap tentukan tanggal penangkapan yang valid.');
        } else {
            alert('Harap tentukan tanggal penangkapan yang valid.');
        }
        return;
    }

    btn.disabled = true;
    btn.innerHTML = 'Menyimpan...';

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const res = await fetch(`/pokedex/caught/${pokemonId}/date`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ caught_at: newDate })
        });

        const json = await res.json();
        if (json.success) {
            closeEditCaughtDateModal();
            // Perbarui tampilan tanggal di tabel tanpa harus reload penuh
            const cell = document.getElementById(`caught-date-val-${pokemonId}`);
            if (cell && json.caught_at_formatted) {
                cell.textContent = json.caught_at_formatted;
            }
            if (typeof window.showCaughtFeedback === 'function') {
                window.showCaughtFeedback(true, 'Tanggal Diperbarui!', json.message, true);
            } else {
                alert(json.message);
                location.reload();
            }
        } else {
            if (typeof window.showCaughtFeedback === 'function') {
                window.showCaughtFeedback(false, 'Gagal Memperbarui', json.message || 'Terjadi kesalahan sistem.');
            } else {
                alert(json.message || 'Gagal memperbarui tanggal');
            }
        }
    } catch (err) {
        if (typeof window.showCaughtFeedback === 'function') {
            window.showCaughtFeedback(false, 'Gangguan Jaringan', 'Gagal menghubungi server.');
        } else {
            alert('Gangguan koneksi saat memperbarui tanggal.');
        }
    } finally {
        btn.disabled = false;
        btn.innerHTML = origText;
    }
};

// Logic Modal Hapus Tangkapan
window.confirmDeleteCaught = function(pokemonId, pokemonName, spriteUrl) {
    document.getElementById('deleteCaughtPokemonId').value = pokemonId;
    document.getElementById('deleteCaughtPokemonName').textContent = pokemonName;
    document.getElementById('deleteCaughtPokemonSprite').src = spriteUrl || '';
    document.getElementById('deleteCaughtModal').hidden = false;
};

window.closeDeleteCaughtModal = function() {
    document.getElementById('deleteCaughtModal').hidden = true;
};

window.executeDeleteCaught = async function() {
    const pokemonId = document.getElementById('deleteCaughtPokemonId').value;
    const btn = document.getElementById('btnConfirmDeleteCaught');
    const origText = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = 'Menghapus...';

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const res = await fetch(`/pokedex/caught/${pokemonId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        });

        const json = await res.json();
        if (json.success) {
            closeDeleteCaughtModal();
            if (typeof window.showCaughtFeedback === 'function') {
                window.showCaughtFeedback(true, 'Berhasil Dihapus!', json.message, true);
            } else {
                alert(json.message);
                location.reload();
            }
        } else {
            if (typeof window.showCaughtFeedback === 'function') {
                window.showCaughtFeedback(false, 'Gagal Menghapus', json.message || 'Terjadi kesalahan sistem.');
            } else {
                alert(json.message || 'Gagal menghapus Pokémon');
            }
        }
    } catch (err) {
        if (typeof window.showCaughtFeedback === 'function') {
            window.showCaughtFeedback(false, 'Gangguan Jaringan', 'Gagal menghubungi server.');
        } else {
            alert('Gangguan koneksi saat menghapus.');
        }
    } finally {
        btn.disabled = false;
        btn.innerHTML = origText;
    }
};
</script>
@endpush
