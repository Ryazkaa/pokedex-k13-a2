@extends('layouts.app')

@section('title', 'Pokedex')

@php
    $typeMeta = collect(config('pokedex.types'))->map(function ($meta) {
        $meta['icon'] = asset($meta['icon']);
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
        @include('pokedex.partials.table')
    </main>

    <footer class="site-footer shell">
        <p>Pokédex - Kelompok 13 - Kelas A / A2</p>
        <p>Laravel {{ app()->version() }} · PhpSpreadsheet · Artwork dari PokeAPI</p>
    </footer>

    @include('pokedex.partials.showcase-modal')

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
    <script src="{{ asset('js/pokedex.js') }}?v={{ filemtime(public_path('js/pokedex.js')) }}" defer></script>
@endpush
