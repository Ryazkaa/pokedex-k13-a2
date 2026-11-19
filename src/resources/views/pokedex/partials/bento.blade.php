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
@endphp

<section id="explore" class="bento section" aria-label="Explore">
    {{-- Kolom 1 (Kiri): Panduan Format & Validasi Excel --}}
    <div class="bento__col bento__artworks">
        <div class="bento-head">
            <span class="bento-head__kicker">Panduan PhpSpreadsheet</span>
            <h2 class="section-title"><a href="#search">Format &amp; Aturan <span aria-hidden="true">›</span></a></h2>
        </div>

        <div class="bento-panel guide-panel">
            <article class="guide-block">
                <header class="guide-block__head">
                    <h3 class="guide-card__title">Struktur Excel</h3>
                    <span class="guide-card__badge">4 Kolom Wajib</span>
                </header>
                <div class="guide-cols">
                    <div class="guide-col-item">
                        <code>nomor_index</code>
                        <span>#0006</span>
                    </div>
                    <div class="guide-col-item">
                        <code>nama_pokemon</code>
                        <span>Charizard</span>
                    </div>
                    <div class="guide-col-item">
                        <code>tipe</code>
                        <span>Fire / Flying</span>
                    </div>
                    <div class="guide-col-item">
                        <code>generasi</code>
                        <span>Generasi I (Kanto)</span>
                    </div>
                </div>
            </article>

            <article class="guide-block">
                <header class="guide-block__head">
                    <h3 class="guide-card__title">Validasi Import</h3>
                    <span class="guide-card__badge">3 Status Cek</span>
                </header>
                <ul class="guide-card__rules">
                    <li class="rule--ok">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong>Berhasil</strong>
                            <span>4 kolom sesuai &amp; nomor index baru</span>
                        </div>
                    </li>
                    <li class="rule--dup">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong>Ditolak (Duplikat)</strong>
                            <span>Nomor index sudah ada di database</span>
                        </div>
                    </li>
                    <li class="rule--bad">
                        <span class="rule__dot" aria-hidden="true"></span>
                        <div>
                            <strong>Tidak Valid</strong>
                            <span>Ada kolom kosong atau data tidak cocok</span>
                        </div>
                    </li>
                </ul>
            </article>
        </div>
    </div>

    {{-- Kolom 2 (Tengah): Control Panel Excel & Filter --}}
    <div class="bento__col bento__control" id="dropZone">
        <div class="bento-head">
            <span class="bento-head__kicker">Kontrol Data &amp; Koleksi</span>
            <h2 class="section-title">Excel &amp; Filter</h2>
        </div>

        <div class="bento-panel control-panel">
            <div class="excel-actions">
                <form id="importForm" class="import-form" method="POST" action="{{ route('pokedex.import') }}" enctype="multipart/form-data" style="width: 100%;">
                    @csrf
                    <input type="file" id="importFile" name="file_excel" class="visually-hidden" tabindex="-1"
                           accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" aria-label="Pilih file Excel">
                    <button type="button" class="action-pill action-pill--wide" id="importTrigger" data-action="import">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 15V4m0 0L8 8m4-4 4 4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <strong>Import Master Dataset (.xlsx)</strong>
                            <small>Fitur Developer · Perbarui 1.025 data ke Library</small>
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
            </div>

            {{-- Filter Generasi (Dropdown Generasi 1 - 9) --}}
            <div class="control-group">
                <div class="control-group__head">
                    <p class="pill-label">Filter Generasi</p>
                    <button type="button" class="btn-reset-inline" id="resetGenPill" data-reset-gen hidden>
                        Reset filter ×
                    </button>
                </div>
                <div class="gen-dropdown-wrap">
                    <label class="bento-select-wrap">
                        <select id="bentoGenFilter" class="bento-select" aria-label="Pilih Generasi Pokémon">
                            <option value="">Semua Generasi (Pilih Gen 1 – 9)</option>
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
                    <p class="pill-label">Filter Tipe</p>
                    <button type="button" class="btn-reset-inline" id="resetPill" data-reset-type hidden>
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
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 16a4 4 0 0 1-.8-7.9A5.5 5.5 0 0 1 17 7a4.5 4.5 0 0 1 .5 9H7z" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
                <span>Tarik &amp; lepas file <strong>.xlsx</strong> langsung ke panel ini untuk import cepat</span>
            </p>
        </div>
    </div>

    {{-- Kolom 3 (Kanan): Statistik & Progress Koleksi Real-Time --}}
    <div class="bento__col bento__info-col" aria-live="polite">
        <div class="bento-head">
            <span class="bento-head__kicker">Statistik Database</span>
            <h2 class="section-title">Progress Koleksi</h2>
        </div>

        <div class="bento__info">
            {{-- Kartu 1: Koleksi Pokédex (Integrasi Modul Madina) --}}
            <article class="info-card">
                <div class="info-card__icon info-card__icon--stats">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 20V11m7 9V5m7 15v-6" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>
                </div>
                <div class="info-card__body">
                    <p class="info-card__kicker">Koleksi Pokédex</p>
                    <h3>N/A</h3>
                    <p>Menunggu integrasi modul Pokédex Caught Tracker (Madina Dwiyana Putri).</p>
                </div>
            </article>

            {{-- Kartu 2: Kelengkapan Pokédex (Responsif 251 atau 1025) --}}
            <article class="info-card">
                <div class="info-card__icon info-card__icon--progress">
                    <span>{{ $completionPct }}%</span>
                </div>
                <div class="info-card__body">
                    <p class="info-card__kicker">Kelengkapan Library</p>
                    @if ($maxCatalog === 1025)
                        @if ($total >= 1025)
                            <h3>Semua 9 Generasi Terdaftar (Gen I–IX)</h3>
                        @else
                            <h3>{{ $generasiList->count() }} Generasi Terdata · {{ $total }}/1025</h3>
                        @endif
                        <div class="dex-progress" role="progressbar" aria-valuenow="{{ $completionPct }}" aria-valuemin="0" aria-valuemax="100">
                            <span class="dex-progress__bar" style="width: {{ $completionPct }}%"></span>
                        </div>
                        <p>
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
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 12h18" stroke="currentColor" stroke-width="2"/></svg>
                    @endif
                </div>
                <div class="info-card__body">
                    <div class="info-card__head-row">
                        <p class="info-card__kicker">Indeks Terakhir</p>
                        <span class="info-card__jump-badge">Hal. {{ $lastPageNum }} ↗</span>
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
                                <span>{{ $latestPokemon->generasi }}</span>
                            </span>
                        </div>
                        <p class="info-card__submeta">
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
