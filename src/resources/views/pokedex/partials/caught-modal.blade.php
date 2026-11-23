{{-- Modal Tambah Koleksi Pokédex via PokéAPI (Madina Dwiyana Putri & Arya Andra Diazka) --}}
{{-- 1. Modal Form Tambah Koleksi Pokédex (Crimson Dark Glassmorphism) --}}
<div id="addCaughtModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="addCaughtTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-caught-modal></div>
    <div class="pkm-modal__dialog" style="max-width: 520px; background: #0f1923; color: #f1f5f9; border-radius: 14px; overflow: hidden; border: 1px solid rgba(255, 70, 85, 0.35); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(255, 70, 85, 0.2); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        {{-- Header Modal --}}
        <div class="pkm-modal__header" style="display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(255, 70, 85, 0.06);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('images/pokeball.svg') }}" alt="Pokédex" width="34" height="34" style="filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));">
                </div>
                <div>
                    <h3 id="addCaughtTitle" style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; letter-spacing: -0.01em;">Tambah Koleksi Pokédex</h3>
                    <p style="margin: 2px 0 0 0; font-size: 0.76rem; color: #94a3b8;">Integrasi PokéAPI v2 · Simpan ke Pelacak Koleksi Trainer</p>
                </div>
            </div>
            <button type="button" class="pkm-modal__close" data-close-caught-modal aria-label="Tutup modal" style="background: none; border: none; font-size: 1.6rem; color: #94a3b8; cursor: pointer; transition: color .15s;" onmouseover="this.style.color='#ff4655'" onmouseout="this.style.color='#94a3b8'">&times;</button>
        </div>

        {{-- Form Body --}}
        <form id="formAddCaught" style="padding: 22px 24px;">
            @csrf
            {{-- Field 1: Nomor Index + Tombol Ambil PokéAPI --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="field-label" for="apiDexIndex" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    Nomor Index Pokémon (Manual atau Otomatis PokéAPI)
                </label>
                <div style="display: flex; gap: 8px;">
                    <input type="number" id="apiDexIndex" name="nomor_index" placeholder="Contoh: 25 atau 150" required min="1" max="1025"
                           class="text-input" style="flex: 1; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.95rem; font-family: monospace; font-weight: 700; outline: none;">
                    <button type="button" id="btnFetchPokeApi"
                            style="padding: 10px 18px; background: rgba(255, 70, 85, 0.15); border: 1px solid rgba(255, 70, 85, 0.4); border-radius: 8px; font-weight: 700; font-size: 0.85rem; color: #ff4655; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; white-space: nowrap;">
                        <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: currentColor;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        <span>Ambil PokéAPI</span>
                    </button>
                </div>
            </div>

            {{-- Field 2: Nama Pokémon --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="field-label" for="apiDexName" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nama Pokémon</label>
                <input type="text" id="apiDexName" name="nama_pokemon" placeholder="Contoh: Pikachu" required
                       class="text-input" style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none;">
            </div>

            {{-- Field 3: Tipe 1 & Tipe 2 --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="field-label" for="apiDexType1" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Tipe 1 (Utama)</label>
                    <select id="apiDexType1" name="tipe_1" required
                            class="text-input" style="width: 100%; padding: 10px 12px; background: #151f2b; border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.9rem; outline: none; cursor: pointer;">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Normal">Normal</option><option value="Fire">Fire</option><option value="Water">Water</option>
                        <option value="Grass">Grass</option><option value="Electric">Electric</option><option value="Ice">Ice</option>
                        <option value="Fighting">Fighting</option><option value="Poison">Poison</option><option value="Ground">Ground</option>
                        <option value="Flying">Flying</option><option value="Psychic">Psychic</option><option value="Bug">Bug</option>
                        <option value="Rock">Rock</option><option value="Ghost">Ghost</option><option value="Dragon">Dragon</option>
                        <option value="Steel">Steel</option><option value="Fairy">Fairy</option><option value="Stellar">Stellar</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="field-label" for="apiDexType2" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Tipe 2 (Opsional)</label>
                    <select id="apiDexType2" name="tipe_2"
                            class="text-input" style="width: 100%; padding: 10px 12px; background: #151f2b; border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.9rem; outline: none; cursor: pointer;">
                        <option value="">-- Tidak Ada --</option>
                        <option value="Normal">Normal</option><option value="Fire">Fire</option><option value="Water">Water</option>
                        <option value="Grass">Grass</option><option value="Electric">Electric</option><option value="Ice">Ice</option>
                        <option value="Fighting">Fighting</option><option value="Poison">Poison</option><option value="Ground">Ground</option>
                        <option value="Flying">Flying</option><option value="Psychic">Psychic</option><option value="Bug">Bug</option>
                        <option value="Rock">Rock</option><option value="Ghost">Ghost</option><option value="Dragon">Dragon</option>
                        <option value="Steel">Steel</option><option value="Fairy">Fairy</option><option value="Stellar">Stellar</option>
                    </select>
                </div>
            </div>

            {{-- Field 4: Generasi --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="field-label" for="apiDexGen" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Wilayah Generasi</label>
                <select id="apiDexGen" name="generasi" required
                        class="text-input" style="width: 100%; padding: 10px 12px; background: #151f2b; border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 8px; color: #ffffff; font-size: 0.9rem; outline: none; cursor: pointer;">
                    <option value="Generasi I (Kanto)">Generasi I (Kanto)</option>
                    <option value="Generasi II (Johto)">Generasi II (Johto)</option>
                    <option value="Generasi III (Hoenn)">Generasi III (Hoenn)</option>
                    <option value="Generasi IV (Sinnoh)">Generasi IV (Sinnoh)</option>
                    <option value="Generasi V (Unova)">Generasi V (Unova)</option>
                    <option value="Generasi VI (Kalos)">Generasi VI (Kalos)</option>
                    <option value="Generasi VII (Alola)">Generasi VII (Alola)</option>
                    <option value="Generasi VIII (Galar)">Generasi VIII (Galar)</option>
                    <option value="Generasi IX (Paldea)">Generasi IX (Paldea)</option>
                </select>
            </div>

            {{-- Field 5: URL Sprite (Otomatis) --}}
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="field-label" for="apiDexSprite" style="display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    URL Sprite (Otomatis terisi dari PokéAPI)
                </label>
                <input type="url" id="apiDexSprite" name="sprite_url"
                       placeholder="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/..."
                       class="text-input" style="width: 100%; box-sizing: border-box; padding: 10px 14px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; font-size: 0.82rem; color: #94a3b8; outline: none;">
            </div>

            {{-- Box Hologram Preview Sprite Pokémon --}}
            <div id="apiDexPreviewBox" style="border: 1.5px dashed rgba(255, 70, 85, 0.35); border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 16px; margin-bottom: 22px; background: radial-gradient(circle at center, rgba(255, 70, 85, 0.08) 0%, rgba(15, 25, 35, 0.6) 100%); transition: all 0.3s;">
                <div style="width: 58px; height: 58px; border-radius: 10px; background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img id="apiDexPreviewImg" src="" alt="Preview" style="width: 52px; height: 52px; image-rendering: pixelated; display: none; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.6));">
                    <img id="apiDexPlaceholderIcon" src="{{ asset('images/pokeball.svg') }}" alt="Pokéball" style="width: 34px; height: 34px; opacity: 0.65; filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.5));">
                </div>
                <div style="flex: 1; text-align: left;">
                    <div id="apiDexPreviewTitle" style="font-size: 0.92rem; font-weight: 700; color: #ffffff; margin-bottom: 2px;">Preview Sprite Pokémon</div>
                    <div id="apiDexPreviewSub" style="font-size: 0.78rem; color: #94a3b8;">Ketik nomor index di atas lalu klik &ldquo;Ambil PokéAPI&rdquo;</div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 16px;">
                <button type="button" data-close-caught-modal
                        style="padding: 10px 18px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; font-weight: 600; color: #94a3b8; cursor: pointer; transition: all .15s;"
                        onmouseover="this.style.color='#fff'; this.style.borderColor='rgba(255,255,255,0.2)';"
                        onmouseout="this.style.color='#94a3b8'; this.style.borderColor='rgba(255,255,255,0.1)';">
                    Batal
                </button>
                <button type="submit" id="btnSubmitCaught"
                        class="action-pill action-pill--primary"
                        style="padding: 10px 24px; font-weight: 700; font-size: 0.9rem; border-radius: 8px; background: var(--crimson, #ff4655); box-shadow: 0 4px 14px rgba(255, 70, 85, 0.35); cursor: pointer; border: none; color: #fff;">
                    Simpan Koleksi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 2. Modal Popup Peringatan Autentikasi di Tengah (Guest / Unauthenticated) --}}
<div id="caughtAuthPromptModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="caughtAuthPromptTitle" hidden>
    <div class="pkm-modal__backdrop" onclick="closeCaughtAuthPromptModal(true)"></div>
    <div class="pkm-modal__dialog" style="max-width: 440px; text-align: center; padding: 32px 26px; border: 1px solid rgba(255, 70, 85, 0.45); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(255, 70, 85, 0.25); animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <button type="button" onclick="closeCaughtAuthPromptModal(true)" style="position: absolute; right: 14px; top: 14px; background: none; border: none; font-size: 1.6rem; color: #94A3B8; cursor: pointer; line-height: 1; transition: color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94A3B8'">&times;</button>
        
        {{-- Logo Lingkaran Berdenyut Crimson dengan Ikon Gembok / Padlock --}}
        <div class="lock-icon-pulse" style="width: 76px; height: 76px; border-radius: 50%; background: rgba(255, 70, 85, 0.12); border: 2.5px solid #ff4655; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <svg viewBox="0 0 24 24" style="width: 38px; height: 38px; color: #ff4655;" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                <circle cx="12" cy="16" r="1.5" fill="#ff4655"/>
            </svg>
        </div>

        <h3 id="caughtAuthPromptTitle" style="font-size: 1.3rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0; letter-spacing: -0.01em;">
            Akses Koleksi Terkunci
        </h3>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 70, 85, 0.16); color: #F43F5E; border: 1px solid rgba(255, 70, 85, 0.35); font-size: 0.72rem; font-weight: 800; padding: 3px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 18px;">
            <span>Autentikasi Diperlukan</span>
        </div>

        <p style="font-size: 0.88rem; color: #CBD5E1; line-height: 1.6; margin: 0 0 24px 0;">
            Fitur <strong>Tambah Koleksi Pokémon</strong> dan pelacakan Pokédex pribadi memerlukan akun Trainer aktif.<br><br>
            Silakan masuk, daftar akun baru, atau gunakan akun <strong>Developer Kelompok 13</strong> untuk mulai mencatat koleksi tangkapan Pokémon Anda.
        </p>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button type="button" onclick="closeCaughtAuthPromptModal(true)"
                    class="action-pill action-pill--primary"
                    style="width: 100%; justify-content: center; padding: 12px; font-weight: 700; font-size: 0.9rem; border-radius: 8px; background: var(--crimson, #ff4655); box-shadow: 0 4px 14px rgba(255, 70, 85, 0.4); border: none; color: #fff; cursor: pointer;">
                <span style="margin-right: 6px;">⚡</span> Masuk / Buka Menu Akun
            </button>
            <button type="button" onclick="closeCaughtAuthPromptModal(true)"
                    class="action-pill action-pill--ghost"
                    style="width: 100%; justify-content: center; padding: 10px; font-weight: 600; font-size: 0.84rem; color: #94A3B8; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- 3. Feedback Alert Modal (Pemberitahuan Berhasil / Gagal Simpan) --}}
<div id="caughtFeedbackModal" class="pkm-modal" role="dialog" aria-modal="true" hidden>
    <div class="pkm-modal__backdrop" onclick="document.getElementById('caughtFeedbackModal').hidden = true"></div>
    <div class="pkm-modal__dialog" style="max-width: 400px; text-align: center; padding: 28px 22px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.12); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8); animation: pkmModalIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);">
        <div id="caughtFeedbackIcon" style="width: 60px; height: 60px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;"></div>
        <h4 id="caughtFeedbackTitle" style="font-size: 1.15rem; font-weight: 700; margin: 0 0 6px 0;"></h4>
        <p id="caughtFeedbackMessage" style="font-size: 0.88rem; color: #94A3B8; margin: 0 0 20px 0; line-height: 1.5;"></p>
        <button type="button" id="btnCaughtFeedbackOk" class="action-pill action-pill--primary" style="width: 100%; justify-content: center; padding: 10px; font-weight: 700; border-radius: 8px; border: none; cursor: pointer;">
            OK, Lanjutkan
        </button>
    </div>
</div>

<script>
// Fungsi Global untuk Membuka Modal Tambah Koleksi (Autentikasi Checked)
window.openAddCaughtModal = function() {
    @auth
        const modal = document.getElementById('addCaughtModal');
        if (modal) modal.hidden = false;
    @else
        window.openCaughtAuthPromptModal();
    @endauth
};

// Fungsi Global untuk Membuka Prompt Autentikasi di Tengah
window.openCaughtAuthPromptModal = function() {
    const promptModal = document.getElementById('caughtAuthPromptModal');
    if (promptModal) promptModal.hidden = false;
};

// Fungsi Menutup Prompt Autentikasi dan Membuka Menu Akun (Login, Daftar, DevKit)
window.closeCaughtAuthPromptModal = function(openAuth = true) {
    const promptModal = document.getElementById('caughtAuthPromptModal');
    if (promptModal) promptModal.hidden = true;
    if (openAuth) {
        const authModal = document.getElementById('authModal');
        if (authModal) authModal.hidden = false;
    }
};

// Notifikasi Feedback Custom Pengganti alert()
window.showCaughtFeedback = function(isSuccess, title, message, reloadOnClose = false) {
    const modal = document.getElementById('caughtFeedbackModal');
    const icon = document.getElementById('caughtFeedbackIcon');
    const titleEl = document.getElementById('caughtFeedbackTitle');
    const msgEl = document.getElementById('caughtFeedbackMessage');
    const okBtn = document.getElementById('btnCaughtFeedbackOk');

    if (!modal) return;

    if (isSuccess) {
        icon.style.background = 'rgba(16, 185, 129, 0.15)';
        icon.style.border = '2px solid #10b981';
        icon.innerHTML = '<svg viewBox="0 0 24 24" style="width: 32px; height: 32px; color: #10b981;" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';
        titleEl.style.color = '#10b981';
        okBtn.style.background = '#10b981';
    } else {
        icon.style.background = 'rgba(239, 68, 68, 0.15)';
        icon.style.border = '2px solid #ef4444';
        icon.innerHTML = '<svg viewBox="0 0 24 24" style="width: 32px; height: 32px; color: #ef4444;" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
        titleEl.style.color = '#ef4444';
        okBtn.style.background = '#ef4444';
    }

    titleEl.textContent = title;
    msgEl.innerHTML = message;
    modal.hidden = false;

    okBtn.onclick = function() {
        modal.hidden = true;
        if (reloadOnClose) location.reload();
    };
};

document.addEventListener('DOMContentLoaded', function() {
    const btnFetch = document.getElementById('btnFetchPokeApi');
    const inputIndex = document.getElementById('apiDexIndex');
    const inputName = document.getElementById('apiDexName');
    const selType1 = document.getElementById('apiDexType1');
    const selType2 = document.getElementById('apiDexType2');
    const selGen = document.getElementById('apiDexGen');
    const inputSprite = document.getElementById('apiDexSprite');
    const previewImg = document.getElementById('apiDexPreviewImg');
    const placeholderIcon = document.getElementById('apiDexPlaceholderIcon');
    const previewTitle = document.getElementById('apiDexPreviewTitle');
    const previewSub = document.getElementById('apiDexPreviewSub');
    const previewBox = document.getElementById('apiDexPreviewBox');
    const form = document.getElementById('formAddCaught');

    // Auto-fetch data dari PokéAPI v2
    if (btnFetch) {
        btnFetch.addEventListener('click', async function() {
            const id = inputIndex.value.trim();
            if (!id) {
                window.showCaughtFeedback(false, 'Indeks Kosong', 'Silakan masukkan nomor index Pokémon (1 - 1025) terlebih dahulu.');
                return;
            }

            btnFetch.innerHTML = '<svg class="spinner" viewBox="0 0 24 24" style="width: 14px; height: 14px; animation: spin 1s linear infinite;" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-linecap="round"/></svg> <span>Mengambil...</span>';
            btnFetch.disabled = true;

            try {
                const res = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
                if (!res.ok) throw new Error('Pokémon dengan index #' + id + ' tidak ditemukan di PokéAPI.');
                const data = await res.json();

                // Isi nama
                const formattedName = data.name.charAt(0).toUpperCase() + data.name.slice(1);
                inputName.value = formattedName;

                // Isi tipe
                if (data.types[0]) selType1.value = data.types[0].type.name.charAt(0).toUpperCase() + data.types[0].type.name.slice(1);
                if (data.types[1]) selType2.value = data.types[1].type.name.charAt(0).toUpperCase() + data.types[1].type.name.slice(1);
                else selType2.value = '';

                // Tentukan Generasi
                const num = parseInt(id);
                if (num <= 151) selGen.value = 'Generasi I (Kanto)';
                else if (num <= 251) selGen.value = 'Generasi II (Johto)';
                else if (num <= 386) selGen.value = 'Generasi III (Hoenn)';
                else if (num <= 493) selGen.value = 'Generasi IV (Sinnoh)';
                else if (num <= 649) selGen.value = 'Generasi V (Unova)';
                else if (num <= 721) selGen.value = 'Generasi VI (Kalos)';
                else if (num <= 809) selGen.value = 'Generasi VII (Alola)';
                else if (num <= 905) selGen.value = 'Generasi VIII (Galar)';
                else selGen.value = 'Generasi IX (Paldea)';

                // Sprite URL
                const spriteUrl = data.sprites?.front_default || `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${num}.png`;
                inputSprite.value = spriteUrl;

                // Update Preview Hologram
                previewImg.src = spriteUrl;
                previewImg.style.display = 'block';
                if (placeholderIcon) placeholderIcon.style.display = 'none';
                previewTitle.textContent = `${formattedName} (#${String(num).padStart(4, '0')})`;
                const typeInfo = selType2.value ? `${selType1.value} / ${selType2.value}` : selType1.value;
                previewSub.textContent = `${typeInfo} · ${selGen.value}`;
                previewBox.style.borderColor = '#ff4655';
                previewBox.style.background = 'radial-gradient(circle at center, rgba(255, 70, 85, 0.18) 0%, rgba(15, 25, 35, 0.8) 100%)';

            } catch (err) {
                window.showCaughtFeedback(false, 'Gagal Mengambil PokéAPI', err.message);
            } finally {
                btnFetch.innerHTML = '<svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: currentColor;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> <span>Ambil PokéAPI</span>';
                btnFetch.disabled = false;
            }
        });
    }

    // Submit form via AJAX
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitCaught');
            const originalText = btn.innerHTML;
            btn.textContent = 'Menyimpan...';
            btn.disabled = true;

            const formData = new FormData(form);

            try {
                const res = await fetch("{{ route('pokedex.catch.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (res.status === 401) {
                    document.getElementById('addCaughtModal').hidden = true;
                    window.openCaughtAuthPromptModal();
                    return;
                }

                const json = await res.json();
                if (json.success) {
                    document.getElementById('addCaughtModal').hidden = true;
                    window.showCaughtFeedback(true, 'Koleksi Tersimpan!', json.message, true);
                } else {
                    window.showCaughtFeedback(false, 'Gagal Menyimpan', json.message || 'Terjadi kesalahan sistem.');
                }
            } catch (err) {
                window.showCaughtFeedback(false, 'Gangguan Jaringan', 'Gagal menghubungi server Pokédex.');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    // Close handler
    document.querySelectorAll('[data-close-caught-modal]').forEach(b => {
        b.addEventListener('click', () => {
            const m = document.getElementById('addCaughtModal');
            if (m) m.hidden = true;
        });
    });
});
</script>
<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
