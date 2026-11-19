{{-- Bento Grid: Panduan Excel | Control Panel Excel & Filter | Statistik & Progress Koleksi --}}
@php
    $kantoCount = $pokemons->where('gen_roman', 'I')->count();
    $johtoCount = $pokemons->where('gen_roman', 'II')->count();
    $maxCatalog = 251;
    $completionPct = $maxCatalog > 0 ? min(100, (int) round(($total / $maxCatalog) * 100)) : 0;
    $remainingSlot = max(0, $maxCatalog - $total);
    $latestPokemon = $pokemons->sortByDesc('number')->first();
    $lastPageNum = max(1, (int) ceil($total / 20));
    $nextIndexNum = ($latestPokemon?->number ?? $total) + 1;
    $nextIndexStr = '#' . str_pad((string) $nextIndexNum, 4, '0', STR_PAD_LEFT);
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
                <a href="{{ route('pokedex.export') }}" class="action-pill" id="exportTrigger" data-export-trigger>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11m0 0-4-4m4 4 4-4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <div>
                        <strong>Export ke Excel</strong>
                        <small>Unduh .xlsx + timestamp</small>
                    </div>
                </a>

                <form id="importForm" class="import-form" method="POST" action="{{ route('pokedex.import') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="importFile" name="file_excel" class="visually-hidden" tabindex="-1"
                           accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" aria-label="Pilih file Excel">
                    <button type="button" class="action-pill" id="importTrigger" data-action="import">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 15V4m0 0L8 8m4-4 4 4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <strong>Import Excel</strong>
                            <small>Pilih / tarik file .xlsx</small>
                        </div>
                    </button>

                    {{-- Panel Konfirmasi Export (Hold to Confirm -> Envelope Seal) --}}
                    <div class="import-chip" id="exportChip" hidden>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h7l5 5v13H7z M14 3v5h5" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                        <span id="exportName">Pokedex_Library_{{ now('Asia/Jakarta')->format('Y-m-d') }}.xlsx ({{ $total }} Pokémon)</span>
                        <button type="button" id="exportCancel" aria-label="Batalkan export">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>
                        </button>
                    </div>
                    <button type="button" class="action-pill action-pill--upload hold-btn" id="exportHoldBtn" data-export-url="{{ route('pokedex.export') }}" hidden>
                        <svg class="hold-btn__perimeter" viewBox="0 0 400 56" preserveAspectRatio="none" aria-hidden="true">
                            <rect x="2" y="2" width="396" height="52" rx="13" ry="13" pathLength="100"/>
                        </svg>
                        <span class="hold-btn__ring-wrap" aria-hidden="true">
                            <svg class="hold-btn__ring" viewBox="0 0 36 36">
                                <circle class="hold-btn__track" cx="18" cy="18" r="15" pathLength="100"/>
                                <circle class="hold-btn__fill" cx="18" cy="18" r="15" pathLength="100"/>
                            </svg>
                            <svg class="hold-btn__icon hold-btn__icon--idle" viewBox="0 0 24 24"><path d="M12 4v11m0 0-4-4m4 4 4-4M5 20h14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <svg class="hold-btn__icon hold-btn__icon--check" viewBox="0 0 24 24"><path d="m5 12.5 4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <span class="hold-btn__text" data-label>Hold to Confirm Export</span>
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

            {{-- Filter Generasi (Gen 1 dan Gen 2) --}}
            <div class="control-group">
                <div class="control-group__head">
                    <p class="pill-label">Filter Generasi</p>
                    <button type="button" class="btn-reset-inline" id="resetGenPill" data-reset-gen hidden>
                        Reset filter ×
                    </button>
                </div>
                <div class="gen-shortcuts" aria-label="Filter Generasi">
                    <button type="button" class="gen-card" data-filter-gen="Generasi I (Kanto)" aria-pressed="false">
                        <span class="gen-card__num">I</span>
                        <span class="gen-card__body">
                            <strong>Gen 1 · Kanto</strong>
                            <small>#0001 – #0151</small>
                        </span>
                    </button>

                    <button type="button" class="gen-card" data-filter-gen="Generasi II (Johto)" aria-pressed="false">
                        <span class="gen-card__num">II</span>
                        <span class="gen-card__body">
                            <strong>Gen 2 · Johto</strong>
                            <small>#0152 – #0251</small>
                        </span>
                    </button>
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
            {{-- Kartu 1: Ringkasan Koleksi (dipertahankan) --}}
            <article class="info-card">
                <div class="info-card__icon info-card__icon--stats">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 20V11m7 9V5m7 15v-6" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>
                </div>
                <div class="info-card__body">
                    <p class="info-card__kicker">Ringkasan Koleksi</p>
                    <h3>{{ $total }} Pokémon</h3>
                    <p>{{ count($typeMeta) }} tipe elemen (18 standar + Stellar) dari {{ $generasiList->count() }} generasi berbeda.</p>
                </div>
            </article>

            {{-- Kartu 2: Kelengkapan Kanto & Johto (#0001 - #0251) --}}
            <article class="info-card">
                <div class="info-card__icon info-card__icon--progress">
                    <span>{{ $completionPct }}%</span>
                </div>
                <div class="info-card__body">
                    <p class="info-card__kicker">Kelengkapan Pokédex ({{ $total }} / {{ $maxCatalog }})</p>
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
                            Entri ke-<strong>{{ $total }}</strong> · Target import berikutnya: <strong>{{ $nextIndexStr }}</strong>
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
