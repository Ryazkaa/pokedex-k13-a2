{{-- Modal Jurnal Taktik & Catatan Lapangan Trainer (Iasha Irdanti - Modul 4) --}}
{{-- 1. Modal Utama Jurnal Taktis (Cyber Crimson / Dark Glassmorphism) --}}
<div id="journalModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="journalModalTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-journal-modal></div>
    <div class="pkm-modal__dialog" style="max-width: 650px; background: #0f1923; color: #f1f5f9; border-radius: 14px; border: 1px solid rgba(56, 189, 248, 0.35); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(56, 189, 248, 0.18); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">

        {{-- Header Modal --}}
        <div class="pkm-modal__header" style="display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: linear-gradient(90deg, rgba(56, 189, 248, 0.12), rgba(15, 25, 35, 0.8));">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(56, 189, 248, 0.15); border: 1.5px solid rgba(56, 189, 248, 0.4); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 0 16px rgba(56, 189, 248, 0.25);">
                    <img id="journalPkmSprite" src="" alt="Sprite" width="40" height="40" style="image-rendering: pixelated; display: none; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">
                    <svg id="journalPkmFallbackIcon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <span style="display: inline-block; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.8px; color: #38BDF8; text-transform: uppercase;">MODUL 4 · TACTICAL FIELD JOURNAL</span>
                    <h3 id="journalModalTitle" style="margin: 2px 0 0 0; font-size: 1.18rem; font-weight: 700; color: #ffffff; letter-spacing: -0.01em;">Jurnal Taktis Trainer</h3>
                    <p id="journalPkmSubtitle" style="margin: 2px 0 0 0; font-size: 0.78rem; color: #94A3B8;" data-i18n="journal_modal_sub">Analisis Medan & Strategi Bertarung Pokémon</p>
                </div>
            </div>
            <button type="button" class="pkm-modal__close" data-close-journal-modal aria-label="Tutup modal" style="background: none; border: none; font-size: 1.6rem; color: #94A3B8; cursor: pointer; transition: color .15s; line-height: 1; padding: 4px;" onmouseover="this.style.color='#ff4655'" onmouseout="this.style.color='#94A3B8'">&times;</button>
        </div>

        {{-- Form Body --}}
        <form id="formJournal" style="padding: 22px 24px;">
            <input type="hidden" id="journalPokemonId">

            {{-- Row 1: Tanggal Tangkap & Lokasi Penangkapan --}}
            <div class="journal-meta-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label for="journalCaughtDate" style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#38BDF8" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span data-i18n="journal_caught_date">Tanggal Penangkapan</span>
                    </label>
                    <input type="date" id="journalCaughtDate"
                        style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.92rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.2)';"
                        onblur="this.style.borderColor='rgba(255, 255, 255, 0.14)'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label for="journalCaughtLoc" style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#ff4655" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span data-i18n="journal_caught_loc">Lokasi Penangkapan</span>
                    </label>
                    <input type="text" id="journalCaughtLoc" placeholder="Contoh: Route 102, Viridian Forest"
                        style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.92rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.2)';"
                        onblur="this.style.borderColor='rgba(255, 255, 255, 0.14)'; this.style.boxShadow='none';">
                </div>
            </div>

            {{-- Row 2: Judul Catatan --}}
            <div style="margin-bottom: 16px;">
                <label for="journalTitle" style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#fbbf24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></svg>
                    <span data-i18n="journal_title">Judul Strategi / Analisis</span>
                </label>
                <input type="text" id="journalTitle" placeholder="Contoh: Taktik Serangan Cepat Gym Air & Counter Listrik"
                    style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.92rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.2)';"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.14)'; this.style.boxShadow='none';">
            </div>

            {{-- Row 3: Editor WYSIWYG Quill.js --}}
            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#34d399" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span data-i18n="journal_tactics_notes">Catatan & Analisis Taktik (WYSIWYG)</span>
                </label>
                <div id="journalQuillEditor" style="min-height: 150px; background: #0c141f; border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 0 0 8px 8px; color: #f1f5f9;"></div>
            </div>

            {{-- Action Buttons --}}
            <div class="journal-modal-actions" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 16px;">
                <button type="button" id="btnDeleteJournal" style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 8px; color: #F87171; font-size: 0.84rem; padding: 9px 14px; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.25)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.12)'">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    <span data-i18n="btn_delete_journal">Hapus Catatan</span>
                </button>
                <div style="display: flex; gap: 10px;">
                    <button type="button" data-close-journal-modal
                        style="padding: 10px 18px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #cbd5e1; cursor: pointer; font-size: 0.88rem; font-weight: 600; transition: all 0.15s;"
                        onmouseover="this.style.background='rgba(255, 255, 255, 0.12)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'"
                        data-i18n="btn_close">
                        Tutup
                    </button>
                    <button type="submit" id="btnSaveJournal"
                        style="padding: 10px 22px; background: linear-gradient(135deg, #ff4655, #e11d48); border: none; border-radius: 8px; color: #ffffff; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 70, 85, 0.35); font-size: 0.9rem; transition: transform 0.15s, box-shadow 0.15s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(255, 70, 85, 0.5)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(255, 70, 85, 0.35)';">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span id="btnSaveJournalText" data-i18n="btn_save_journal">Simpan Jurnal Taktik</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- 2. Modal Popup Notifikasi Feedback Simpan / Hapus / Auth --}}
<div id="journalFeedbackModal" class="pkm-modal" role="dialog" aria-modal="true" hidden style="z-index: 10500;">
    <div class="pkm-modal__backdrop" onclick="closeJournalFeedbackModal()"></div>
    <div class="pkm-modal__dialog" style="max-width: 440px; background: #0f1923; color: #f1f5f9; border-radius: 14px; overflow: hidden; border: 1px solid rgba(56, 189, 248, 0.4); box-shadow: 0 25px 70px rgba(0,0,0,0.9), 0 0 35px rgba(56, 189, 248, 0.25); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); text-align: center; padding: 28px 24px;">
        
        {{-- Status Icon --}}
        <div id="feedbackIconBox" style="width: 60px; height: 60px; margin: 0 auto 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(52, 211, 153, 0.15); border: 2px solid #34d399; box-shadow: 0 0 20px rgba(52, 211, 153, 0.35);">
            {{-- Success Icon (Default) --}}
            <svg id="feedbackIconSuccess" viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{-- Lock / Alert Icon (Hidden by default) --}}
            <svg id="feedbackIconLock" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#ff4655" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>

        <h3 id="feedbackTitle" style="margin: 0 0 8px; font-size: 1.25rem; font-weight: 700; color: #ffffff;">Jurnal Taktik Berhasil Disimpan!</h3>
        <p id="feedbackMessage" style="margin: 0 0 22px; font-size: 0.88rem; color: #94a3b8; line-height: 1.5;">Strategi bertarung dan catatan lapangan telah berhasil diamankan ke dalam Pokédex pribadi Anda.</p>

        <div id="feedbackActionRow" style="display: flex; justify-content: center; gap: 10px;">
            <button type="button" id="btnFeedbackClose" onclick="closeJournalFeedbackModal()"
                style="padding: 10px 24px; background: linear-gradient(135deg, #0284c7, #0369a1); border: none; border-radius: 8px; color: #ffffff; font-weight: 700; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(2, 132, 199, 0.35);">
                Selesai
            </button>
            <button type="button" id="btnFeedbackAuth" onclick="openLoginFromFeedback()"
                style="display: none; padding: 10px 20px; background: linear-gradient(135deg, #ff4655, #e11d48); border: none; border-radius: 8px; color: #ffffff; font-weight: 700; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(255, 70, 85, 0.4);">
                Masuk / Buka Menu Login
            </button>
        </div>
    </div>
</div>

{{-- Quill Snow Dark Theme & Custom Styling --}}
<style>
#journalModal .ql-toolbar.ql-snow {
    background: #141f2e;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 8px 8px 0 0;
    padding: 8px 12px;
}
#journalModal .ql-toolbar.ql-snow .ql-stroke {
    stroke: #94a3b8;
}
#journalModal .ql-toolbar.ql-snow .ql-fill {
    fill: #94a3b8;
}
#journalModal .ql-toolbar.ql-snow .ql-picker {
    color: #94a3b8;
}
#journalModal .ql-toolbar.ql-snow button:hover .ql-stroke,
#journalModal .ql-toolbar.ql-snow button.ql-active .ql-stroke {
    stroke: #38bdf8;
}
#journalModal .ql-toolbar.ql-snow button:hover .ql-fill,
#journalModal .ql-toolbar.ql-snow button.ql-active .ql-fill {
    fill: #38bdf8;
}
#journalModal .ql-container.ql-snow {
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-top: none;
    border-radius: 0 0 8px 8px;
    background: #0c141f;
    color: #f1f5f9;
    font-size: 0.92rem;
    font-family: inherit;
}
#journalModal .ql-editor {
    min-height: 140px;
    padding: 12px 14px;
}
#journalModal .ql-editor.ql-blank::before {
    color: #64748b;
    font-style: italic;
    left: 14px;
}
#journalModal .ql-editor:focus {
    outline: none;
}
</style>

{{-- Memuat pustaka Quill.js CDN --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    let quillInstance = null;

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
        }[c]));
    }

    // Helper Modal Feedback
    window.showJournalFeedback = function(isSuccess, title, message, isAuth = false) {
        const modal = document.getElementById('journalFeedbackModal');
        const iconBox = document.getElementById('feedbackIconBox');
        const iconSuccess = document.getElementById('feedbackIconSuccess');
        const iconLock = document.getElementById('feedbackIconLock');
        const titleEl = document.getElementById('feedbackTitle');
        const msgEl = document.getElementById('feedbackMessage');
        const btnClose = document.getElementById('btnFeedbackClose');
        const btnAuth = document.getElementById('btnFeedbackAuth');

        if (!modal) return;

        titleEl.textContent = title;
        msgEl.innerHTML = message;

        if (isSuccess) {
            iconBox.style.background = 'rgba(52, 211, 153, 0.15)';
            iconBox.style.borderColor = '#34d399';
            iconBox.style.boxShadow = '0 0 20px rgba(52, 211, 153, 0.35)';
            iconSuccess.style.display = 'block';
            iconLock.style.display = 'none';
            btnClose.style.display = 'inline-block';
            btnClose.textContent = 'Selesai';
            btnAuth.style.display = 'none';
        } else {
            iconBox.style.background = 'rgba(255, 70, 85, 0.15)';
            iconBox.style.borderColor = '#ff4655';
            iconBox.style.boxShadow = '0 0 20px rgba(255, 70, 85, 0.35)';
            iconSuccess.style.display = 'none';
            iconLock.style.display = 'block';
            if (isAuth) {
                btnClose.style.display = 'inline-block';
                btnClose.textContent = 'Batal';
                btnAuth.style.display = 'inline-block';
            } else {
                btnClose.style.display = 'inline-block';
                btnClose.textContent = 'Tutup';
                btnAuth.style.display = 'none';
            }
        }

        modal.hidden = false;
    };

    window.closeJournalFeedbackModal = function() {
        const modal = document.getElementById('journalFeedbackModal');
        if (modal) modal.hidden = true;
    };

    window.openLoginFromFeedback = function() {
        closeJournalFeedbackModal();
        if (typeof openAuthModal === 'function') {
            openAuthModal('loginTab');
        }
    };

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
                const btnText = document.getElementById('btnSaveJournalText');
                const prevLabel = btnText ? btnText.textContent : 'Simpan Jurnal Taktik';

                if (btnText) btnText.textContent = 'Menyimpan...';
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
                        const json = await res.json().catch(() => ({}));
                        document.getElementById('journalModal').hidden = true;
                        showJournalFeedback(
                            false,
                            'Akses Terkunci (Perlu Login)',
                            json.message || 'Silakan masuk atau daftar akun Trainer terlebih dahulu untuk menyimpan catatan taktis ke Pokédex Anda.',
                            true
                        );
                        return;
                    }

                    const json = await res.json();
                    if (json.success) {
                        document.getElementById('journalModal').hidden = true;
                        const pkmName = json.pokemon_name || 'Pokémon';
                        showJournalFeedback(
                            true,
                            'Jurnal Taktik Berhasil Disimpan!',
                            `Strategi bertarung dan analisis lapangan untuk <strong>${escapeHtml(pkmName)}</strong> berhasil disimpan ke Pokédex pribadi Anda.`
                        );
                    } else {
                        showJournalFeedback(
                            false,
                            'Gagal Menyimpan Catatan',
                            json.message || 'Terjadi kendala saat menyimpan jurnal taktik ke database.'
                        );
                    }
                } catch (err) {
                    console.error('Error saving journal:', err);
                    showJournalFeedback(
                        false,
                        'Koneksi Terganggu',
                        'Gagal menghubungi server untuk menyimpan jurnal taktik. Silakan periksa koneksi Anda.'
                    );
                } finally {
                    if (btnText) btnText.textContent = prevLabel;
                    if (btn) btn.disabled = false;
                }
            });
        }

        // Hapus Jurnal via AJAX
        const btnDeleteJournal = document.getElementById('btnDeleteJournal');
        if (btnDeleteJournal) {
            btnDeleteJournal.addEventListener('click', async function() {
                if (!confirm('Yakin ingin menghapus catatan strategi taktis ini dari Pokédex?')) return;
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
                        document.getElementById('journalModal').hidden = true;
                        showJournalFeedback(
                            false,
                            'Sesi Berakhir',
                            'Silakan masuk akun terlebih dahulu untuk mengelola catatan.',
                            true
                        );
                        return;
                    }

                    const json = await res.json();
                    if (json.success) {
                        document.getElementById('journalModal').hidden = true;
                        showJournalFeedback(
                            true,
                            'Catatan Berhasil Dihapus',
                            json.message || 'Catatan taktis berhasil dihapus dari Pokédex.'
                        );
                    } else {
                        showJournalFeedback(false, 'Gagal Menghapus', json.message || 'Gagal menghapus catatan.');
                    }
                } catch (err) {
                    console.error('Error deleting journal:', err);
                    showJournalFeedback(false, 'Error', 'Gagal memproses penghapusan catatan.');
                }
            });
        }
    });

    // Fungsi global untuk membuka modal jurnal dari baris tabel
    window.openJournalModal = async function(pokemonId, pokemonName, spriteUrl) {
        const modal = document.getElementById('journalModal');
        if (!modal) return;

        document.getElementById('journalPokemonId').value = pokemonId;
        const titleEl = document.getElementById('journalModalTitle');
        if (titleEl) {
            titleEl.textContent = `Jurnal Taktis: ${pokemonName}`;
        }
        
        const img = document.getElementById('journalPkmSprite');
        const fallbackIcon = document.getElementById('journalPkmFallbackIcon');
        if (img) {
            img.src = spriteUrl || '';
            img.style.display = spriteUrl ? 'block' : 'none';
        }
        if (fallbackIcon) {
            fallbackIcon.style.display = spriteUrl ? 'none' : 'block';
        }

        // Reset nilai formulir
        document.getElementById('journalTitle').value = '';
        document.getElementById('journalCaughtDate').value = '';
        document.getElementById('journalCaughtLoc').value = '';
        if (quillInstance) quillInstance.root.innerHTML = '';

        // Ambil catatan yang sudah tersimpan sebelumnya
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
