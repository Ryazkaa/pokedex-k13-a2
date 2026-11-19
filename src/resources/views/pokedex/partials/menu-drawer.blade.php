{{-- Side Drawer menu: Drawer springs in from the right as the page dims, Rows stagger in --}}
<dialog id="drawer" class="drawer" closedby="any" aria-label="Menu navigasi">
    <div class="drawer__sheet">
        <div class="drawer__head drawer-stagger" style="--row-i: 0">
            <p class="drawer__brand"><span>Pokédex</span></p>
            <button type="button" class="icon-btn icon-btn--ghost" data-close-dialog aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
            </button>
        </div>

        <p class="drawer__label drawer-stagger" style="--row-i: 1">Navigasi</p>
        <nav class="drawer__nav" aria-label="Navigasi menu">
            <a href="#home" class="drawer-stagger" style="--row-i: 2" data-close-dialog>Home <small>Fun Facts Pokémon</small></a>
            <a href="#explore" class="drawer-stagger" style="--row-i: 3" data-close-dialog>Explore <small>Excel &amp; Filter Cepat</small></a>
            <a href="#search" class="drawer-stagger" style="--row-i: 4" data-close-dialog data-focus-search>Library <small>Tabel Data Pokédex</small></a>
        </nav>

        <p class="drawer__label drawer-stagger" style="--row-i: 5">Excel</p>
        <div class="drawer__actions">
            <a href="{{ route('pokedex.export') }}" class="action-pill drawer-stagger" style="--row-i: 6" data-export-trigger data-close-dialog>Export ke Excel</a>
            <button type="button" class="action-pill drawer-stagger" style="--row-i: 7" data-action="import" data-close-dialog>Import Excel</button>
        </div>

        <p class="drawer__label drawer-stagger" style="--row-i: 8">Filter cepat</p>
        <div class="filter-pills drawer-stagger" style="--row-i: 9">
            @foreach ($generasiList as $gen)
                @php $roman = preg_match('/(?:generasi|gen)\.?\s*([ivx]+)/i', $gen, $m) ? strtoupper($m[1]) : $gen; @endphp
                <button type="button" class="chip" data-filter-gen="{{ $gen }}" data-close-dialog>Gen {{ $roman }}</button>
            @endforeach
        </div>

        <p class="drawer__foot drawer-stagger" style="--row-i: 10">{{ $total }} Pokémon tercatat</p>
    </div>
</dialog>
