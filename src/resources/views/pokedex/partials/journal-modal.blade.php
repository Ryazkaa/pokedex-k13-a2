{{-- Modal Jurnal Taktik & Catatan Lapangan Trainer (Iasha Irdanti) --}}
<div id="journalModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="journalModalTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-journal-modal></div>
    <div class="pkm-modal__dialog" style="max-width: 620px; background: #0F172A; color: #F1F5F9; border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); overflow: hidden;">

        {{-- Header Modal --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(30, 41, 59, 0.6);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img id="journalPkmSprite" src="" alt="" width="36" height="36" style="image-rendering: pixelated; display: none;">
                <div>
                    <h3 id="journalModalTitle" style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #F1F5F9;">Jurnal Taktis Trainer</h3>
                    <p id="journalPkmSubtitle" style="margin: 0; font-size: 0.8rem; color: #38BDF8;">Analisis Medan & Strategi Bertarung</p>
                </div>
            </div>
            <button type="button" data-close-journal-modal style="background: none; border: none; font-size: 1.5rem; color: #94A3B8; cursor: pointer;">&times;</button>
        </div>

        {{-- Form Body --}}
        <form id="formJournal" style="padding: 20px;">
            <input type="hidden" id="journalPokemonId">

            {{-- Row 1: Tanggal Tangkap & Lokasi Penangkapan --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">📅 Tanggal Tangkap</label>
                    <input type="date" id="journalCaughtDate"
                        style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">📍 Lokasi Penangkapan</label>
                    <input type="text" id="journalCaughtLoc" placeholder="contoh: Route 102, Viridian Forest"
                        style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
                </div>
            </div>

            {{-- Row 2: Judul Catatan --}}
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">🎯 Judul Strategi</label>
                <input type="text" id="journalTitle" placeholder="contoh: Taktik Serangan Cepat Gym Air"
                    style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
            </div>

            {{-- Row 3: Editor WYSIWYG Quill.js --}}
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">📝 Catatan & Analisis Taktik (WYSIWYG)</label>
                <div id="journalQuillEditor" style="min-height: 140px; background: #1E293B; border: 1px solid rgba(255,255,255,0.1); border-radius: 0 0 6px 6px; color: #F1F5F9;"></div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 14px;">
                <button type="button" id="btnDeleteJournal" style="background: none; border: none; color: #EF4444; font-size: 0.85rem; cursor: pointer; font-weight: 600;">
                    🗑 Hapus Catatan
                </button>
                <div style="display: flex; gap: 8px;">
                    <button type="button" data-close-journal-modal
                        style="padding: 8px 16px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: #F1F5F9; cursor: pointer;">
                        Tutup
                    </button>
                    <button type="submit" id="btnSaveJournal"
                        style="padding: 8px 20px; background: #E11D48; border: none; border-radius: 6px; color: #ffffff; font-weight: 600; cursor: pointer;">
                        Simpan Jurnal Taktik
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Memuat pustaka Quill.js CDN --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    let quillInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill WYSIWYG
        quillInstance = new Quill('#journalQuillEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['blockquote', 'clean']
                ]
            },
            placeholder: 'Tuliskan analisis strategi, kelemahan lawan, dan combo jurus Pokémon ini...'
        });

        // Close modal triggers
        document.querySelectorAll('[data-close-journal-modal]').forEach(b => {
            b.addEventListener('click', () => {
                document.getElementById('journalModal').hidden = true;
            });
        });

        // Simpan Jurnal via AJAX
        document.getElementById('formJournal').addEventListener('submit', async function(e) {
            e.preventDefault();
            const pkmId = document.getElementById('journalPokemonId').value;
            const btn = document.getElementById('btnSaveJournal');
            btn.textContent = 'Menyimpan...';
            btn.disabled = true;

            const payload = {
                title: document.getElementById('journalTitle').value,
                content: quillInstance.root.innerHTML,
                caught_date: document.getElementById('journalCaughtDate').value,
                caught_location: document.getElementById('journalCaughtLoc').value,
            };

            try {
                const res = await fetch(`/pokedex/notes/${pkmId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                if (json.success) {
                    alert(json.message);
                    document.getElementById('journalModal').hidden = true;
                }
            } catch (err) {
                alert('Gagal menyimpan jurnal taktik.');
            } finally {
                btn.textContent = 'Simpan Jurnal Taktik';
                btn.disabled = false;
            }
        });

        // Hapus Jurnal via AJAX
        document.getElementById('btnDeleteJournal').addEventListener('click', async function() {
            if (!confirm('Yakin ingin menghapus catatan taktis ini?')) return;
            const pkmId = document.getElementById('journalPokemonId').value;

            try {
                const res = await fetch(`/pokedex/notes/${pkmId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (json.success) {
                    alert(json.message);
                    document.getElementById('journalModal').hidden = true;
                }
            } catch (err) {
                alert('Gagal menghapus catatan.');
            }
        });
    });

    // Fungsi global untuk membuka modal jurnal dari baris tabel
    window.openJournalModal = async function(pokemonId, pokemonName, spriteUrl) {
        document.getElementById('journalPokemonId').value = pokemonId;
        document.getElementById('journalModalTitle').textContent = `Jurnal Taktik: ${pokemonName}`;
        const img = document.getElementById('journalPkmSprite');
        img.src = spriteUrl;
        img.style.display = 'block';

        // Reset editor
        document.getElementById('journalTitle').value = '';
        document.getElementById('journalCaughtDate').value = '';
        document.getElementById('journalCaughtLoc').value = '';
        if (quillInstance) quillInstance.root.innerHTML = '';

        // Ambil catatan yang sudah ada
        try {
            const res = await fetch(`/pokedex/notes/${pokemonId}`);
            const json = await res.json();
            if (json.success && json.note) {
                document.getElementById('journalTitle').value = json.note.title || '';
                document.getElementById('journalCaughtDate').value = json.note.caught_date || '';
                document.getElementById('journalCaughtLoc').value = json.note.caught_location || '';
                if (quillInstance) quillInstance.root.innerHTML = json.note.content || '';
            }
        } catch (err) {
            console.error('Gagal mengambil data catatan:', err);
        }

        document.getElementById('journalModal').hidden = false;
    };
</script>