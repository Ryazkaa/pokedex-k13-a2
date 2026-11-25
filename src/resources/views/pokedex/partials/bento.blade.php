{{-- Bento Grid: Panduan Excel | Control Panel Excel & Filter | Statistik & Progress Koleksi --}}
@php
    $kantoCount = $pokemons->where('gen_roman', 'I')->count();
    $johtoCount = $pokemons->where('gen_roman', 'II')->count();
    $maxCatalog = $total > 251 ? 1025 : 251;
    $completionPct = $maxCatalog > 0 ? min(100, (int) round(($total / $maxCatalog) * 100)) : 0;
    $remainingSlot = max(0, $maxCatalog - $total);
    $latestPokemon = $pokemons->sortByDesc('number')->first();
    $lastPageNum = max(1, (int) ceil($total / 20));
    $nextIndexNum = ($latestPokemon?->number ?? $total) + 1;
    $nextIndexStr = $nextIndexNum <= $maxCatalog ? ('#' . str_pad((string) $nextIndexNum, 4, '0', STR_PAD_LEFT)) : 'Lengkap';
    $isDev = Auth::check() && method_exists(Auth::user(), 'isDeveloper') && Auth::user()->isDeveloper();
@endphp

<section id="explore" class="bento section" aria-label="Explore">
    {{-- Kolom 1 (Kiri): Panduan Format & Validasi Excel --}}
    <div class="bento__col bento__artworks">
        <div class="bento-head">
            <span class="bento-head__kicker" data-i18n="guide_kicker">Panduan PhpSpreadsheet</span>
            <h2 class="section-title"><a href="#search"><span data-i18n="guide_title">Format &amp; Aturan</span> <span aria-hidden="true">›</span></a></h2>
        </div>

        <div class="bento-panel guide-panel">
            <article class="guide-block">
                <header class="guide-block__head">
                    <h3 class="guide-card__title" data-i18n="guide_struct_title">Struktur Excel</h3>
                    <span class="guide-card__badge" data-i18n="guide_struct_badge">4 Kolom Wajib</span>
                </header>
                <div class="guide-cols">
                    <div class="guide-col-item">
                        <code data-i18n="guide_col_idx">nomor_index</code>
                        <span>#0006</span>
                    </div>
                    <div class="guide-col-item">
                        <code data-i18n="guide_col_name">nama_pokemon</code>
                        <span>Charizard</span>
                    </div>
                    <div class="guide-col-item">
                        <code data-i18n="guide_col_type">tipe</code>
                        <span>Fire / Flying</span>
                    </div>
                    <div class="guide-col-item">
                        <code data-i18n="guide_col_gen">generasi</code>
                        <span data-i18n="guide_col_gen_val">Generasi I (Kanto)</span>
                    </div>
                </div>
            </article>

            <article class="guide-block">
                <header class="guide-block__head">
                    <h3 class="guide-card__title" data-i18n="guide_val_title">Validasi Import</h3>
                    <span class="guide-card__badge" data-i18n="guide_val_badge">3 Status Cek</span>
                </header>
                <ul class="guide-card__rules">
                    <li class="rule--ok">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong data-i18n="rule_success_title">Berhasil</strong>
                            <span data-i18n="rule_success_desc">4 kolom sesuai &amp; nomor index baru</span>
                        </div>
                    </li>
                    <li class="rule--dup">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong data-i18n="rule_dup_title">Ditolak (Duplikat)</strong>
                            <span data-i18n="rule_dup_desc">Nomor index sudah ada di database</span>
                        </div>
                    </li>
                    <li class="rule--bad">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong data-i18n="rule_invalid_title">Tidak Valid</strong>
                            <span data-i18n="rule_invalid_desc">Ada kolom kosong atau data tidak cocok</span>
                        </div>
                    </li>
                </ul>
            </article>
        </div>
    </div>

    {{-- Kolom 2 (Tengah): Control Panel Excel & Filter --}}
    <div class="bento__col bento__control" @if($isDev) id="dropZone" @endif>
        <div class="bento-head">
            <span class="bento-head__kicker" data-i18n="control_kicker">Kontrol Data &amp; Koleksi</span>
            <h2 class="section-title" data-i18n="control_title">Excel &amp; Filter</h2>
        </div>

        <div class="bento-panel control-panel">
            <div class="excel-actions" style="grid-template-columns: 1fr; width: 100%;">
                @if ($isDev)
                    <form id="importForm" class="import-form" method="POST" action="{{ route('pokedex.import') }}" enctype="multipart/form-data" style="width: 100%;">
                        @csrf
                        <input type="file" id="importFile" name="file_excel" class="visually-hidden" tabindex="-1"
                               accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" aria-label="Pilih file Excel">
                        <button type="button" class="action-pill action-pill--wide import-trigger-btn" id="importTrigger" data-action="import"
                                style="width: 100%; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 14px;">
                            <svg viewBox="0 0 24 24" aria-hidden="true" style="width: 24px; height: 24px; flex-shrink: 0;"><path d="M12 15V4m0 0L8 8m4-4 4 4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <div class="import-trigger-body" style="flex: 1; text-align: left; min-width: 0;">
                                <div class="import-trigger-head" style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 3px;">
                                    <strong style="font-size: 0.95rem; color: #FFFFFF; font-weight: 700;">Import Pokemon untuk Database</strong>
                                    <span class="import-trigger-badge" style="background: rgba(225, 29, 72, 0.22); color: #F43F5E; border: 1px solid rgba(225, 29, 72, 0.45); font-size: 0.68rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase; white-space: nowrap;">Fitur Developer</span>
                                </div>
                                <small style="color: #94A3B8; font-size: 0.78rem;">Khusus Developer · Perbarui atau tambahkan semua Pokémon terbaru ke Library (.xlsx)</small>
                            </div>
                        </button>

                        {{-- Panel Konfirmasi Import (Hold to Import -> Checklist) --}}
                        <div class="import-chip" id="importChip" hidden>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h7l5 5v13H7z M14 3v5h5" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            <span id="importName">file.xlsx</span>
                            <button type="button" id="importCancel" aria-label="Batalkan file">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>
                            </button>
                        </div>
                        <button type="button" class="action-pill action-pill--upload hold-btn" id="importSubmit" hidden>
                            <svg class="hold-btn__perimeter" viewBox="0 0 400 56" preserveAspectRatio="none" aria-hidden="true">
                                <rect x="2" y="2" width="396" height="52" rx="13" ry="13" pathLength="100"/>
                            </svg>
                            <span class="hold-btn__ring-wrap" aria-hidden="true">
                                <svg class="hold-btn__ring" viewBox="0 0 36 36">
                                    <circle class="hold-btn__track" cx="18" cy="18" r="15" pathLength="100"/>
                                    <circle class="hold-btn__fill" cx="18" cy="18" r="15" pathLength="100"/>
                                </svg>
                                <svg class="hold-btn__icon hold-btn__icon--idle" viewBox="0 0 24 24"><path d="M12 15V4m0 0L8 8m4-4 4 4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg class="hold-btn__icon hold-btn__icon--check" viewBox="0 0 24 24"><path d="m5 12.5 4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <span class="hold-btn__text" data-label>Hold to Import</span>
                        </button>
                    </form>
                @else
                    {{-- Tampilan Terkunci Khusus Developer untuk Pengguna Tamu / Trainer --}}
                    <button type="button" class="action-pill action-pill--wide is-locked import-trigger-btn" onclick="openDevLockModal()"
                            style="width: 100%; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 14px; background: rgba(15, 23, 42, 0.7); border: 1px dashed rgba(255, 70, 85, 0.4); cursor: pointer; transition: all .2s;"
                            title="Terkunci: Khusus 4 Akun Developer Kelompok 13">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(255, 70, 85, 0.12); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(255, 70, 85, 0.25);">
                            <svg viewBox="0 0 24 24" aria-hidden="true" style="width: 20px; height: 20px; color: #ff4655;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                        </div>
                        <div class="import-trigger-body" style="flex: 1; text-align: left; min-width: 0;">
                            <div class="import-trigger-head" style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 3px;">
                                <strong style="font-size: 0.95rem; color: #E2E8F0; font-weight: 700;" data-i18n="control_import_btn">Import Pokemon untuk Database</strong>
                                <span class="import-trigger-badge" style="background: rgba(255, 70, 85, 0.15); color: #F43F5E; border: 1px solid rgba(255, 70, 85, 0.35); font-size: 0.68rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    <span data-i18n="badge_locked_dev">Terkunci (Dev Only)</span>
                                </span>
                            </div>
                            <small style="color: #94A3B8; font-size: 0.78rem;" data-i18n="control_import_sub_guest">Khusus 4 Akun Developer (Kelompok 13) · Klik untuk info &amp; login</small>
                        </div>
                    </button>

                    {{-- Modal Popup Animasi di Tengah: Akses Terkunci --}}
                    <div id="devLockModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="devLockTitle" hidden>
                        <div class="pkm-modal__backdrop" onclick="closeDevLockModal()"></div>
                        <div class="pkm-modal__dialog" style="max-width: 440px; text-align: center; padding: 32px 26px; border: 1px solid rgba(255, 70, 85, 0.45); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(255, 70, 85, 0.25);">
                            <button type="button" onclick="closeDevLockModal()" style="position: absolute; right: 14px; top: 14px; background: none; border: none; font-size: 1.6rem; color: #94A3B8; cursor: pointer; line-height: 1; transition: color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94A3B8'">&times;</button>
                            
                            {{-- Logo Lingkaran Beranimasi Merah Berdenyut dengan Simbol X --}}
                            <div class="lock-icon-pulse" style="width: 76px; height: 76px; border-radius: 50%; background: rgba(255, 70, 85, 0.12); border: 2.5px solid #ff4655; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                <svg viewBox="0 0 24 24" style="width: 38px; height: 38px;" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" stroke="#ff4655" stroke-width="2"/>
                                    <line x1="15" y1="9" x2="9" y2="15" stroke="#ff4655" stroke-width="2.5"/>
                                    <line x1="9" y1="9" x2="15" y2="15" stroke="#ff4655" stroke-width="2.5"/>
                                </svg>
                            </div>

                            <h3 id="devLockTitle" style="font-size: 1.3rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0; letter-spacing: -0.01em;" data-i18n="dev_lock_title">
                                Akses Fitur Terkunci
                            </h3>
                            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 70, 85, 0.16); color: #F43F5E; border: 1px solid rgba(255, 70, 85, 0.35); font-size: 0.72rem; font-weight: 800; padding: 3px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 18px;">
                                <span data-i18n="dev_lock_badge">Khusus Developer Kelompok 13</span>
                            </div>

                            <p style="font-size: 0.88rem; color: #CBD5E1; line-height: 1.6; margin: 0 0 24px 0;" id="devLockDesc" data-auth="{{ Auth::check() ? '1' : '0' }}" data-name="{{ Auth::check() ? Auth::user()->name : '' }}">
                                @if (!Auth::check())
                                    Fitur <strong>Import Master Dataset (.xlsx)</strong> dilindungi dan hanya dapat diakses oleh <strong>4 Akun Developer</strong> (Yanuar, Arya, Madina, Iasha) untuk menjaga integritas database katalog 1.025 Pokémon.<br><br>
                                    Silakan beralih ke akun Developer melalui menu di bawah:
                                @else
                                    Anda saat ini masuk sebagai <strong>{{ Auth::user()->name }}</strong> dengan status <strong>TRAINER</strong>.<br><br>
                                    Pengguna umum berstatus Trainer hanya memiliki izin melihat katalog Pokémon (<em>Read-Only</em>). Otoritas import master data dibatasi khusus untuk 4 Developer Kelompok 13.
                                @endif
                            </p>

                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <button type="button" onclick="switchToDevFromLockModal()"
                                        class="action-pill action-pill--primary"
                                        style="width: 100%; justify-content: center; padding: 12px; font-weight: 700; font-size: 0.88rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                    <span data-i18n="btn_open_dev_switch">Buka Switch Developer (K13)</span>
                                </button>
                                <button type="button" onclick="closeDevLockModal()"
                                        class="action-pill action-pill--ghost"
                                        style="width: 100%; justify-content: center; padding: 10px; font-weight: 600; font-size: 0.84rem; color: #94A3B8; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;"
                                        data-i18n="btn_close">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openDevLockModal() {
                            const modal = document.getElementById('devLockModal');
                            if (modal) modal.hidden = false;
                        }
                        function closeDevLockModal() {
                            const modal = document.getElementById('devLockModal');
                            if (modal) modal.hidden = true;
                        }
                        function switchToDevFromLockModal() {
                            closeDevLockModal();
                            const authModal = document.getElementById('authModal');
                            if (authModal) {
                                authModal.hidden = false;
                                document.querySelector('[data-tab="switchTab"]')?.click();
                            }
                        }
                    </script>
                @endif
            </div>

            {{-- Filter Generasi (Dropdown Generasi 1 - 9) --}}
            <div class="control-group">
                <div class="control-group__head">
                    <p class="pill-label" data-i18n="pill_gen_filter">Filter Generasi</p>
                    <button type="button" class="btn-reset-inline" id="resetGenPill" data-reset-gen hidden data-i18n="btn_reset_filter">
                        Reset filter ×
                    </button>
                </div>
                <div class="gen-dropdown-wrap">
                    <label class="bento-select-wrap">
                        <select id="bentoGenFilter" class="bento-select" aria-label="Pilih Generasi Pokémon">
                            <option value="" data-i18n="opt_all_generations">Semua Generasi (Pilih Gen 1 – 9)</option>
                            <option value="Generasi I (Kanto)">Gen 1 · Kanto (#0001 – #0151)</option>
                            <option value="Generasi II (Johto)">Gen 2 · Johto (#0152 – #0251)</option>
                            <option value="Generasi III (Hoenn)">Gen 3 · Hoenn (#0252 – #0386)</option>
                            <option value="Generasi IV (Sinnoh)">Gen 4 · Sinnoh (#0387 – #0493)</option>
                            <option value="Generasi V (Unova)">Gen 5 · Unova (#0494 – #0649)</option>
                            <option value="Generasi VI (Kalos)">Gen 6 · Kalos (#0650 – #0721)</option>
                            <option value="Generasi VII (Alola)">Gen 7 · Alola (#0722 – #0809)</option>
                            <option value="Generasi VIII (Galar)">Gen 8 · Galar (#0810 – #0905)</option>
                            <option value="Generasi IX (Paldea)">Gen 9 · Paldea (#0906 – #1025)</option>
                        </select>
                        <span class="bento-select__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Filter Tipe Elemen (18 tipe standar + 1 tipe khusus Stellar = 19 tipe + logo resmi) --}}
            <div class="control-group">
                <div class="control-group__head">
                    <p class="pill-label" data-i18n="pill_type_filter">Filter Tipe</p>
                    <button type="button" class="btn-reset-inline" id="resetPill" data-reset-type hidden data-i18n="btn_reset_filter">
                        Reset filter ×
                    </button>
                </div>
                <div class="filter-pills">
                    @foreach ($typeMeta as $typeKey => $meta)
                        <button type="button"
                                class="chip chip--type"
                                data-filter-type="{{ $meta['label'] }}"
                                aria-pressed="false"
                                style="--tc: {{ $meta['color'] }}">
                            <img src="{{ asset($meta['icon']) }}" alt="" class="chip__icon" width="18" height="18" loading="lazy">
                            <span>{{ $meta['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <p class="drop-hint">
                @if ($isDev)
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 16a4 4 0 0 1-.8-7.9A5.5 5.5 0 0 1 17 7a4.5 4.5 0 0 1 .5 9H7z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
                    <span data-i18n="drop_hint_dev">Tarik &amp; lepas file <strong>.xlsx</strong> langsung ke panel ini untuk import cepat</span>
                @else
                    <svg viewBox="0 0 24 24" aria-hidden="true" style="color: #ff4655; width: 16px; height: 16px; flex-shrink: 0;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                    <span style="color: #94A3B8;" data-i18n="drop_hint_guest">Mode Read-Only · Fitur Import Spreadsheet khusus akun Developer</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Kolom 3 (Kanan): Statistik & Progress Koleksi Real-Time --}}
    <div class="bento__col bento__info-col" aria-live="polite">
        <div class="bento-head">
            <span class="bento-head__kicker" data-i18n="stats_kicker">Statistik Database</span>
            <h2 class="section-title" data-i18n="stats_title">Progress Koleksi</h2>
        </div>

        <div class="bento__info">
            {{-- Kartu 1: Koleksi Pokédex (Integrasi Modul Madina Dwiyana Putri) --}}
            @php
                $userCatchesCount = Auth::check() ? \App\Models\TrainerCatch::where('user_id', Auth::id())->count() : 0;
                $caughtPct = $userCatchesCount > 0 ? min(100, round(($userCatchesCount / 1025) * 100, 1)) : 0;
            @endphp
            <article class="info-card">
                @if (Auth::check())
                    <div class="info-card__icon info-card__icon--progress" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);">
                        <span>{{ $caughtPct }}%</span>
                    </div>
                    <div class="info-card__body">
                        <p class="info-card__kicker" data-i18n="card_caught_kicker">Koleksi Pokédex</p>
                        <h3 id="caughtStatusCount">{{ $userCatchesCount }} dari 1.025 Pokémon</h3>
                        <p id="caughtStatusDesc">{{ $userCatchesCount > 0 ? "Total Pokémon yang berhasil Anda tangkap & tercatat di Pokédex pribadi." : "Belum ada tangkapan. Tambahkan koleksi pertama Anda!" }}</p>
                        <div style="height: 4px; background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden; margin-top: 8px;">
                            <div style="height: 100%; width: {{ max(1, $caughtPct) }}%; background: #10b981; border-radius: 999px; transition: width 0.4s ease;"></div>
                        </div>
                    </div>
                @else
                    <div class="info-card__icon info-card__icon--stats" style="background: rgba(255, 70, 85, 0.12); border: 1px solid rgba(255, 70, 85, 0.25); color: #ff4655;">
                        <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            <circle cx="12" cy="16" r="1.5" fill="#ff4655"/>
                        </svg>
                    </div>
                    <div class="info-card__body">
                        <p class="info-card__kicker" data-i18n="card_caught_kicker">Koleksi Pokédex</p>
                        <h3 style="color: #f1f5f9;" data-i18n="guest_caught_title">Belum Masuk Akun</h3>
                        <p style="color: #94A3B8;" data-i18n="guest_caught_desc">
                            Silakan <a href="javascript:void(0)" onclick="openAuthModal('loginTab')" style="color: var(--crimson, #ff4655); font-weight: 700; text-decoration: underline;">Masuk</a> atau <a href="javascript:void(0)" onclick="openAuthModal('registerTab')" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">Daftar</a> untuk mulai melacak progres koleksi Pokémon Anda.
                        </p>
                    </div>
                @endif
            </article>

            {{-- Kartu 2: Kelengkapan Pokédex (Responsif 251 atau 1025) --}}
            <article class="info-card">
                <div class="info-card__icon info-card__icon--progress">
                    <span>{{ $completionPct }}%</span>
                </div>
                <div class="info-card__body">
                    <p class="info-card__kicker" data-i18n="card_lib_kicker">Kelengkapan Library</p>
                    @if ($maxCatalog === 1025)
                        @if ($total >= 1025)
                            <h3 data-i18n="card_lib_title">Semua 9 Generasi Terdaftar (Gen I–IX)</h3>
                        @else
                            <h3>{{ $generasiList->count() }} Generasi Terdata · {{ $total }}/1025</h3>
                        @endif
                        <div class="dex-progress" role="progressbar" aria-valuenow="{{ $completionPct }}" aria-valuemin="0" aria-valuemax="100">
                            <span class="dex-progress__bar" style="width: {{ $completionPct }}%"></span>
                        </div>
                        <p data-i18n="card_lib_desc">
                            @if ($remainingSlot > 0)
                                Tersisa <strong>{{ $remainingSlot }} Pokémon</strong> dari total 1.025 Pokémon siap di-import via <strong>.xlsx</strong>.
                            @else
                                Seluruh <strong>1.025 Pokémon</strong> (Gen I–IX) telah lengkap terdaftar!
                            @endif
                        </p>
                    @else
                        <h3>Kanto {{ $kantoCount }}/151 · Johto {{ $johtoCount }}/100</h3>
                        <div class="dex-progress" role="progressbar" aria-valuenow="{{ $completionPct }}" aria-valuemin="0" aria-valuemax="100">
                            <span class="dex-progress__bar" style="width: {{ $completionPct }}%"></span>
                        </div>
                        <p>
                            @if ($remainingSlot > 0)
                                Tersisa <strong>{{ $remainingSlot }} slot Gen II</strong> (#{{ str_pad((string) ($total + 1), 4, '0', STR_PAD_LEFT) }}–#0251) siap di-import via <strong>.xlsx</strong>.
                            @else
                                Seluruh <strong>251 Pokémon</strong> Generasi I &amp; II telah lengkap terdaftar!
                            @endif
                        </p>
                    @endif
                </div>
            </article>

            {{-- Kartu 3: Indeks Terakhir (Klik untuk langsung loncat ke tabel halaman terakhir) --}}
            <article class="info-card info-card--interactive"
                     id="lastIndexCard"
                     data-jump-last-page="{{ $latestPokemon?->nomor_index }}"
                     role="button"
                     tabindex="0"
                     title="Klik untuk langsung menuju halaman terakhir tabel ({{ $latestPokemon?->nomor_index }} {{ $latestPokemon?->nama_pokemon }})">
                <div class="info-card__icon info-card__icon--top">
                    @if ($latestPokemon)
                        <img src="{{ $latestPokemon->sprite_url }}" alt="{{ $latestPokemon->nama_pokemon }}" width="48" height="48" loading="lazy">
                    @else
                        <img src="{{ asset('images/pokeball.svg') }}" alt="Pokéball" width="36" height="36">
                    @endif
                </div>
                <div class="info-card__body">
                    <div class="info-card__head-row">
                        <p class="info-card__kicker" data-i18n="card_last_kicker">Indeks Terakhir</p>
                        <span class="info-card__jump-badge" data-i18n="card_last_jump">Hal. {{ $lastPageNum }} ↗</span>
                    </div>
                    @if ($latestPokemon)
                        <h3>{{ $latestPokemon->nomor_index }} · {{ $latestPokemon->nama_pokemon }}</h3>
                        <div class="top-type-row">
                            @foreach ($latestPokemon->type_list as $tName)
                                @php $tMeta = $typeMeta[strtolower($tName)] ?? null; @endphp
                                <span class="top-type-pill">
                                    @if ($tMeta)
                                        <img src="{{ asset($tMeta['icon']) }}" alt="" width="14" height="14" loading="lazy">
                                    @endif
                                    <strong>{{ $tName }}</strong>
                                </span>
                            @endforeach
                            <span class="top-type-pill">
                                <span class="top-last-gen">{{ $latestPokemon->generasi }}</span>
                            </span>
                        </div>
                        <p class="info-card__submeta" id="lastIndexSubmeta" data-total="{{ $total }}" data-max="{{ $maxCatalog }}" data-next="{{ $nextIndexStr }}">
                            @if ($nextIndexNum <= $maxCatalog)
                                Entri ke-<strong>{{ $total }}</strong> · Target import berikutnya: <strong>{{ $nextIndexStr }}</strong>
                            @else
                                Entri ke-<strong>{{ $total }}</strong> · <strong>Seluruh {{ $maxCatalog }} Pokémon Terdaftar!</strong>
                            @endif
                        </p>
                    @else
                        <h3>Belum Ada Data</h3>
                        <p>Silakan import file .xlsx untuk menambahkan Pokémon.</p>
                    @endif
                </div>
            </article>
        </div>
    </div>
</section>
