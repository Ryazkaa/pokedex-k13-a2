{{-- Modal Tambah Koleksi Pokédex via PokéAPI (Madina Dwiyana Putri) --}}
<div id="addCaughtModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="addCaughtTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-caught-modal></div>
    <div class="pkm-modal__dialog" style="max-width: 520px; background: #ffffff; color: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        
        {{-- Header Modal --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid #e2e8f0;">
            <h3 id="addCaughtTitle" style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #0f172a;">Tambah Koleksi</h3>
            <button type="button" data-close-caught-modal style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        {{-- Form Body --}}
        <form id="formAddCaught" style="padding: 20px 24px;">
            @csrf
            {{-- Field 1: Nomor Index + Tombol Ambil PokéAPI --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
                    Nomor Index (isi nomor lalu klik Ambil PokéAPI jika ingin otomatis)
                </label>
                <div style="display: flex; gap: 8px;">
                    <input type="number" id="apiDexIndex" name="nomor_index" placeholder="Contoh: 51" required
                           style="flex: 1; padding: 10px 14px; border: 1.5px solid #2563eb; border-radius: 8px; font-size: 0.95rem; outline: none;">
                    <button type="button" id="btnFetchPokeApi"
                            style="padding: 10px 18px; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 8px; font-weight: 600; color: #0f172a; cursor: pointer; transition: all 0.2s;">
                        Ambil PokéAPI
                    </button>
                </div>
            </div>

            {{-- Field 2: Nama Pokémon --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Pokémon</label>
                <input type="text" id="apiDexName" name="nama_pokemon" placeholder="Contoh: Diglett" required
                       style="width: 100%; box-sizing: border-box; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
            </div>

            {{-- Field 3: Tipe 1 & Tipe 2 --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Tipe 1 (Utama)</label>
                    <select id="apiDexType1" name="tipe_1" required
                            style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background: #fff;">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Normal">Normal</option><option value="Fire">Fire</option><option value="Water">Water</option>
                        <option value="Grass">Grass</option><option value="Electric">Electric</option><option value="Ice">Ice</option>
                        <option value="Fighting">Fighting</option><option value="Poison">Poison</option><option value="Ground">Ground</option>
                        <option value="Flying">Flying</option><option value="Psychic">Psychic</option><option value="Bug">Bug</option>
                        <option value="Rock">Rock</option><option value="Ghost">Ghost</option><option value="Dragon">Dragon</option>
                        <option value="Steel">Steel</option><option value="Fairy">Fairy</option><option value="Stellar">Stellar</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Tipe 2 (Opsional)</label>
                    <select id="apiDexType2" name="tipe_2"
                            style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background: #fff;">
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
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Generasi</label>
                <select id="apiDexGen" name="generasi" required
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background: #fff;">
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

            {{-- Field 5: URL Sprite --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
                    URL Sprite (Opsional, otomatis dari PokéAPI jika kosong)
                </label>
                <input type="url" id="apiDexSprite" name="sprite_url"
                       placeholder="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/..."
                       style="width: 100%; box-sizing: border-box; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; color: #64748b;">
            </div>

            {{-- Box Preview Sprite Pokémon --}}
            <div style="border: 1.5px dashed #cbd5e1; border-radius: 8px; padding: 14px; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 24px; background: #f8fafc;">
                <img id="apiDexPreviewImg" src="" alt="Preview" style="width: 48px; height: 48px; image-rendering: pixelated; display: none;">
                <span id="apiDexPreviewText" style="color: #64748b; font-size: 0.9rem;">Preview Sprite Pokémon</span>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" data-close-caught-modal
                        style="padding: 10px 20px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-weight: 600; color: #0f172a; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" id="btnSubmitCaught"
                        style="padding: 10px 22px; background: #2563eb; border: none; border-radius: 8px; font-weight: 600; color: #ffffff; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.4);">
                    Simpan Koleksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnFetch = document.getElementById('btnFetchPokeApi');
    const inputIndex = document.getElementById('apiDexIndex');
    const inputName = document.getElementById('apiDexName');
    const selType1 = document.getElementById('apiDexType1');
    const selType2 = document.getElementById('apiDexType2');
    const selGen = document.getElementById('apiDexGen');
    const inputSprite = document.getElementById('apiDexSprite');
    const previewImg = document.getElementById('apiDexPreviewImg');
    const previewTxt = document.getElementById('apiDexPreviewText');
    const form = document.getElementById('formAddCaught');

    // Auto-fetch data dari PokéAPI v2
    btnFetch.addEventListener('click', async function() {
        const id = inputIndex.value.trim();
        if (!id) {
            alert('Silakan masukkan nomor index Pokémon terlebih dahulu.');
            return;
        }

        btnFetch.textContent = 'Mengambil...';
        btnFetch.disabled = true;

        try {
            const res = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
            if (!res.ok) throw new Error('Pokémon tidak ditemukan di PokéAPI.');
            const data = await res.json();

            // Isi nama
            inputName.value = data.name.charAt(0).toUpperCase() + data.name.slice(1);

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

            // Preview
            previewImg.src = spriteUrl;
            previewImg.style.display = 'block';
            previewTxt.textContent = `${inputName.value} (#${num})`;

        } catch (err) {
            alert(err.message);
        } finally {
            btnFetch.textContent = 'Ambil PokéAPI';
            btnFetch.disabled = false;
        }
    });

    // Submit form via AJAX
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitCaught');
        btn.textContent = 'Menyimpan...';
        btn.disabled = true;

        const formData = new FormData(form);

        try {
            const res = await fetch("{{ route('pokedex.catch.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const json = await res.json();
            if (json.success) {
                alert(json.message);
                document.getElementById('addCaughtModal').hidden = true;
                location.reload();
            } else {
                alert(json.message || 'Gagal menyimpan Pokémon ke koleksi.');
            }
        } catch (err) {
            alert('Terjadi kesalahan jaringan.');
        } finally {
            btn.textContent = 'Simpan Koleksi';
            btn.disabled = false;
        }
    });

    // Close handler
    document.querySelectorAll('[data-close-caught-modal]').forEach(b => {
        b.addEventListener('click', () => {
            document.getElementById('addCaughtModal').hidden = true;
        });
    });
});
</script>