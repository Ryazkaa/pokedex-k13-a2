@extends('layouts.app')

@section('title', 'Pokedex')

@php
    $typeMeta = collect(config('pokedex.types'))->map(function ($meta) {
        $meta['icon'] = app()->environment('production') ? secure_asset($meta['icon']) : asset($meta['icon']);
        return $meta;
    })->all();
    $regionMeta = config('pokedex.regions');
    $total = $pokemons->count();
    $hero = $featured->first();
    $clientPayload = [
        'pokemons' => $pokemons->map->toClient()->values(),
        'featured' => $featured->pluck('nomor_index')->values(),
        'total' => $total,
        'types' => $typeMeta,
        'regions' => $regionMeta,
        'genCounts' => $pokemons->countBy('gen_roman'),
        'newIds' => $importResult['new_ids'] ?? [],
    ];
@endphp

@push('head')
    @if ($hero)
        <link rel="preload" as="image" href="{{ $hero->artwork_url }}" fetchpriority="high">
    @endif
@endpush

@section('content')
    @include('pokedex.partials.navbar')
    @include('pokedex.partials.menu-drawer')

    <main id="main" class="shell">
        @include('pokedex.partials.hero')
        @include('pokedex.partials.bento')
        @include('pokedex.partials.import-alert')
        {{-- Modul 3 (Madina): Tabel Koleksi Pokédex (DataTables) --}}
        @includeIf('pokedex.partials.caught-table')
        @include('pokedex.partials.table')
    </main>

    <footer class="site-footer shell">
        <p data-i18n="footer_team">Pokédex - Kelompok 13 - Kelas A / A2</p>
        <p data-i18n="footer_meta">Laravel {{ app()->version() }} · PhpSpreadsheet · Artwork dari PokeAPI</p>
    </footer>

    @include('pokedex.partials.showcase-modal')

    {{-- Modul 1 (Yanuar): Modal Autentikasi & Quick Switch Role Trainer --}}
    @includeIf('pokedex.partials.auth-modal')

    {{-- Modul 3 (Madina): Modal Tambah Koleksi PokéAPI --}}
    @includeIf('pokedex.partials.caught-modal')

    {{-- Modul 4 (Iasha): Modal Jurnal Taktis Trainer (WYSIWYG) --}}
    @includeIf('pokedex.partials.journal-modal')

    {{-- Modal Konfirmasi Pergantian Bahasa Interaktif (Indonesian / English) --}}
    <div id="langConfirmModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="langConfirmTitle" hidden>
        <div class="pkm-modal__backdrop" onclick="closeLangConfirmModal()"></div>
        <div class="pkm-modal__dialog" style="max-width: 420px; text-align: center; padding: 28px 22px; background: #0f1923; color: #f1f5f9; border-radius: 14px; border: 1px solid rgba(255, 70, 85, 0.4); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px rgba(255, 70, 85, 0.2); animation: pkmModalIn 0.28s cubic-bezier(0.16, 1, 0.3, 1);">
            <button type="button" onclick="closeLangConfirmModal()" style="position: absolute; right: 14px; top: 14px; background: none; border: none; font-size: 1.6rem; color: #94A3B8; cursor: pointer; line-height: 1; transition: color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94A3B8'">&times;</button>
            
            {{-- Flag Transition Animation Stage (Bendera Asal -> Panah -> Bendera Tujuan) --}}
            <div style="display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 20px;">
                <div id="langConfirmFromFlag" style="width: 44px; height: 30px; border-radius: 4px; overflow: hidden; border: 1.5px solid rgba(255,255,255,0.2); box-shadow: 0 4px 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; background: #000;"></div>
                <div style="color: #ff4655; display: flex; align-items: center;">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </div>
                <div id="langConfirmToFlag" style="width: 44px; height: 30px; border-radius: 4px; overflow: hidden; border: 2px solid #ff4655; box-shadow: 0 4px 14px rgba(255, 70, 85, 0.4); display: flex; align-items: center; justify-content: center; background: #000; animation: pulseGlow 1.5s infinite alternate;"></div>
            </div>

            <h3 id="langConfirmTitle" style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0; letter-spacing: -0.01em;">
                Ganti Bahasa Antarmuka?
            </h3>
            
            <p id="langConfirmDesc" style="font-size: 0.86rem; color: #CBD5E1; line-height: 1.6; margin: 0 0 22px 0;">
                Seluruh teks navigasi, kartu panduan, statistik, dan katalog akan disesuaikan ke dalam bahasa terpilih.
            </p>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeLangConfirmModal()"
                        class="action-pill action-pill--ghost"
                        style="flex: 1; justify-content: center; padding: 10px; font-weight: 600; font-size: 0.84rem; color: #94A3B8; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; cursor: pointer;">
                    <span id="langConfirmBtnCancel">Batal</span>
                </button>
                <button type="button" id="btnExecuteLangSwitch"
                        class="action-pill action-pill--primary"
                        style="flex: 1; justify-content: center; padding: 10px; font-weight: 700; font-size: 0.88rem; border-radius: 8px; background: var(--crimson, #ff4655); color: #fff; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(255, 70, 85, 0.4);">
                    <span id="langConfirmBtnOk">Ya, Ganti</span>
                </button>
            </div>
        </div>
    </div>

    <style>
    @keyframes pulseGlow {
        from { box-shadow: 0 0 8px rgba(255, 70, 85, 0.3); }
        to { box-shadow: 0 0 20px rgba(255, 70, 85, 0.7); }
    }
    @keyframes fastShimmer {
        0% { opacity: 0.4; filter: blur(2px); transform: scale(0.998); }
        50% { opacity: 0.8; filter: blur(0.6px); }
        100% { opacity: 1; filter: blur(0); transform: scale(1); }
    }
    @keyframes typeRevealText {
        0% { opacity: 0; transform: translateY(3px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .lang-shimmer-active {
        animation: fastShimmer 0.28s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
    .type-revealed {
        animation: typeRevealText 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    </style>

    {{-- Stage Animasi Envelope Seal saat Export ke Excel selesai dikonfirmasi --}}
    <div id="envelopeOverlay" class="env-overlay" aria-hidden="true" hidden>
        <div class="env-stage">
            <div class="env-box" id="envBox">
                {{-- Bagian belakang amplop --}}
                <div class="env-back"></div>

                {{-- Kertas / Surat Logo .XLSX yang meluncur masuk ke dalam amplop --}}
                <div class="env-letter">
                    <div class="env-letter__badge">.XLSX</div>
                    <div class="env-letter__lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <p class="env-letter__title">Pokedex Library</p>
                </div>

                {{-- Kantong depan amplop --}}
                <div class="env-pocket"></div>

                {{-- Tutup segitiga amplop (Flap) yang melipat menutup --}}
                <div class="env-flap"></div>

                {{-- Segel (Seal) dengan tanda centang di tengah amplop --}}
                <div class="env-seal">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 12.5 4 4L18 8.5" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <p class="env-caption">Mengemas &amp; Mengunduh <strong>.xlsx</strong>…</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.POKEDEX = @json($clientPayload);
    </script>
    <script src="{{ app()->environment('production') ? secure_asset('js/pokedex.js') : asset('js/pokedex.js') }}?v={{ file_exists(public_path('js/pokedex.js')) ? filemtime(public_path('js/pokedex.js')) : '1.3.1' }}" defer></script>
@endpush
