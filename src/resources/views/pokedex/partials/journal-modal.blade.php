{{-- Modal Jurnal Taktik & Catatan Lapangan Trainer (Iasha Irdanti - Modul 4) --}}
<div id="journalModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="journalModalTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-journal-modal></div>
    <div class="pkm-modal__dialog" style="max-width: 640px; background: #0F172A; color: #F1F5F9; border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75); overflow: hidden;">

        {{-- Header Modal --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(30, 41, 59, 0.65);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img id="journalPkmSprite" src="" alt="" width="40" height="40" style="image-rendering: pixelated; display: none; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));">
                <div>
                    <h3 id="journalModalTitle" style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #F1F5F9; display: flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#38BDF8" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        <span id="journalModalTitleText" data-i18n="journal_modal_title">Jurnal Taktis Trainer</span>
                    </h3>
                    <p id="journalPkmSubtitle" style="margin: 2px 0 0; font-size: 0.8rem; color: #38BDF8;" data-i18n="journal_modal_sub">Analisis Medan & Strategi Bertarung</p>
                </div>
            </div>
            <button type="button" data-close-journal-modal style="background: none; border: none; font-size: 1.5rem; color: #94A3B8; cursor: pointer; line-height: 1; padding: 4px;" title="Tutup">&times;</button>
        </div>

        {{-- Form Body --}}
        <form id="formJournal" style="padding: 20px;">
            <input type="hidden" id="journalPokemonId">

            {{-- Row 1: Tanggal Tangkap & Lokasi Penangkapan --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span data-i18n="journal_caught_date">Tanggal Tangkap</span>
                    </label>
                    <input type="date" id="journalCaughtDate"
                        style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span data-i18n="journal_caught_loc">Lokasi Penangkapan</span>
                    </label>
                    <input type="text" id="journalCaughtLoc" placeholder="contoh: Route 102, Viridian Forest"
                        style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
                </div>
            </div>

            {{-- Row 2: Judul Catatan --}}
            <div style="margin-bottom: 14px;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    <span data-i18n="journal_title">Judul Strategi</span>
                </label>
                <input type="text" id="journalTitle" placeholder="contoh: Taktik Serangan Cepat Gym Air"
                    style="width: 100%; box-sizing: border-box; padding: 8px 12px; background: #1E293B; border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: #F1F5F9; font-size: 0.9rem;">
            </div>

            {{-- Row 3: Editor WYSIWYG Quill.js --}}
            <div style="margin-bottom: 18px;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    <span data-i18n="journal_tactics_notes">Catatan & Analisis Taktik (WYSIWYG)</span>
                </label>
                <div id="journalQuillEditor" style="min-height: 140px; background: #1E293B; border: 1px solid rgba(255,255,255,0.12); border-radius: 0 0 6px 6px; color: #F1F5F9;"></div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 14px;">
                <button type="button" id="btnDeleteJournal" style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; color: #F87171; font-size: 0.85rem; padding: 8px 14px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    <span data-i18n="btn_delete_journal">Hapus Catatan</span>
                </button>
                <div style="display: flex; gap: 8px;">
                    <button type="button" data-close-journal-modal
                        style="padding: 8px 16px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: #F1F5F9; cursor: pointer; font-size: 0.9rem;"
                        data-i18n="btn_close">
                        Tutup
                    </button>
                    <button type="submit" id="btnSaveJournal"
                        style="padding: 8px 20px; background: #E11D48; border: none; border-radius: 6px; color: #ffffff; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(225, 29, 72, 0.4); font-size: 0.9rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span data-i18n="btn_save_journal">Simpan Jurnal Taktik</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Quill Snow Dark Theme & Custom Styling --}}
<style>
#journalModal .ql-toolbar.ql-snow {
    background: #1E293B;
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 6px 6px 0 0;
    padding: 6px 8px;
}
#journalModal .ql-toolbar.ql-snow .ql-stroke {
    stroke: #94A3B8;
}
#journalModal .ql-toolbar.ql-snow .ql-fill {
    fill: #94A3B8;
}
#journalModal .ql-toolbar.ql-snow .ql-picker {
    color: #94A3B8;
}
#journalModal .ql-toolbar.ql-snow button:hover .ql-stroke,
#journalModal .ql-toolbar.ql-snow button.ql-active .ql-stroke {
    stroke: #38BDF8;
}
#journalModal .ql-toolbar.ql-snow button:hover .ql-fill,
#journalModal .ql-toolbar.ql-snow button.ql-active .ql-fill {
    fill: #38BDF8;
}
#journalModal .ql-container.ql-snow {
    border: 1px solid rgba(255,255,255,0.12);
    border-top: none;
    border-radius: 0 0 6px 6px;
    background: #1E293B;
    color: #F1F5F9;
    font-size: 0.9rem;
    font-family: inherit;
}
#journalModal .ql-editor.ql-blank::before {
    color: #64748B;
    font-style: italic;
}
</style>

{{-- Memuat pustaka Quill.js CDN --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    let quillInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill WYSIWYG
        const editorContainer = document.getElementById('journalQuillEditor');
        if (editorContainer) {
            quillInstance = new Quill(editorContainer, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['blockquote', 'clean']
                    ]
                },
                placeholder: 'Tuliskan analisis strategi, kelemahan lawan, dan combo jurus Pokémon ini...'
            });
        }

        // Close modal triggers
        document.querySelectorAll('[data-close-journal-modal]').forEach(b => {
            b.addEventListener('click', () => {
                const modal = document.getElementById('journalModal');
                if (modal) modal.hidden = true;
            });
        });

        // Simpan Jurnal via AJAX
        const formJournal = document.getElementById('formJournal');
        if (formJournal) {
            formJournal.addEventListener('submit', async function(e) {
                e.preventDefault();
                const pkmId = document.getElementById('journalPokemonId').value;
                const btn = document.getElementById('btnSaveJournal');
                const btnSpan = btn ? btn.querySelector('span') : null;
                const prevText = btnSpan ? btnSpan.textContent : 'Simpan Jurnal Taktik';
                if (btnSpan) btnSpan.textContent = 'Menyimpan...';
                if (btn) btn.disabled = true;

                const payload = {
                    title: document.getElementById('journalTitle').value,
                    content: quillInstance ? quillInstance.root.innerHTML : '',
                    caught_date: document.getElementById('journalCaughtDate').value,
                    caught_location: document.getElementById('journalCaughtLoc').value,
                };

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                try {
                    const res = await fetch(`/pokedex/notes/${pkmId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    if (res.status === 401) {
                        alert('Silakan login terlebih dahulu untuk menyimpan catatan jurnal taktik.');
                        document.getElementById('journalModal').hidden = true;
                        if (typeof openAuthModal === 'function') {
                            openAuthModal('loginTab');
                        }
                        return;
                    }

                    const json = await res.json();
                    if (json.success) {
                        alert(json.message || 'Jurnal taktik berhasil disimpan!');
                        document.getElementById('journalModal').hidden = true;
                    } else {
                        alert(json.message || 'Gagal menyimpan jurnal.');
                    }
                } catch (err) {
                    console.error('Error saving journal:', err);
                    alert('Gagal menyimpan jurnal taktik.');
                } finally {
                    if (btnSpan) btnSpan.textContent = prevText;
                    if (btn) btn.disabled = false;
                }
            });
        }

        // Hapus Jurnal via AJAX
        const btnDeleteJournal = document.getElementById('btnDeleteJournal');
        if (btnDeleteJournal) {
            btnDeleteJournal.addEventListener('click', async function() {
                if (!confirm('Yakin ingin menghapus catatan taktis ini?')) return;
                const pkmId = document.getElementById('journalPokemonId').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                try {
                    const res = await fetch(`/pokedex/notes/${pkmId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    if (res.status === 401) {
                        alert('Silakan login terlebih dahulu.');
                        document.getElementById('journalModal').hidden = true;
                        if (typeof openAuthModal === 'function') openAuthModal('loginTab');
                        return;
                    }

                    const json = await res.json();
                    if (json.success) {
                        alert(json.message || 'Catatan jurnal berhasil dihapus.');
                        document.getElementById('journalModal').hidden = true;
                    } else {
                        alert(json.message || 'Gagal menghapus catatan.');
                    }
                } catch (err) {
                    console.error('Error deleting journal:', err);
                    alert('Gagal menghapus catatan.');
                }
            });
        }
    });

    // Fungsi global untuk membuka modal jurnal dari baris tabel
    window.openJournalModal = async function(pokemonId, pokemonName, spriteUrl) {
        const modal = document.getElementById('journalModal');
        if (!modal) return;

        document.getElementById('journalPokemonId').value = pokemonId;
        const titleText = document.getElementById('journalModalTitleText');
        if (titleText) {
            titleText.textContent = `Jurnal Taktik: ${pokemonName}`;
        }
        const img = document.getElementById('journalPkmSprite');
        if (img) {
            img.src = spriteUrl || '';
            img.style.display = spriteUrl ? 'block' : 'none';
        }

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

        modal.hidden = false;
    };
</script>
