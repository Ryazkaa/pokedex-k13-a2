{{-- Showcase Modal: tampilan detail kontras tinggi (diisi oleh pokedex.js) --}}
<dialog id="showcase" class="showcase" closedby="any" aria-labelledby="scName">
    <div class="showcase__inner">
        <header class="showcase__top">
            <p class="showcase__brand"><span data-i18n="sc_brand">Pokédex</span></p>
            <div class="showcase__nav">
                <button type="button" class="sc-btn" id="scPrev" aria-label="Pokémon sebelumnya" title="Sebelumnya (←)">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="sc-btn" id="scNext" aria-label="Pokémon berikutnya" title="Berikutnya (→)">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="sc-btn sc-btn--close" data-close-dialog aria-label="Tutup (Esc)" autofocus>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </button>
            </div>
        </header>

        <div class="showcase__body">
            <div class="showcase__index">
                <span class="showcase__line" aria-hidden="true"></span>
                <p><span class="showcase__no" id="scNo">#0000</span><sup>/ <span id="scTotal">{{ $total }}</span></sup></p>
            </div>

            <div class="showcase__stage">
                <span class="showcase__watermark" id="scWatermark" aria-hidden="true">000</span>
                <img id="scArt" src="data:," alt="" width="475" height="475">
            </div>

            <div class="showcase__info">
                <span class="showcase__dots" aria-hidden="true">●●●</span>
                <p class="showcase__eyebrow" id="scEyebrow">Generasi</p>
                <h2 class="showcase__name" id="scName">POKÉMON</h2>
                <div id="scTypes"></div>
                <p class="showcase__lore" id="scLore"></p>

                <div class="gallery">
                    <p class="gallery__label"><span data-i18n="sc_sprites_label">Sprites</span> <span aria-hidden="true">▾</span></p>
                    <div class="gallery__grid" id="scGallery"></div>
                </div>
            </div>
        </div>

        <footer class="showcase__foot">
            <span data-i18n="sc_nav_hint">Gunakan ← → untuk berpindah · Esc untuk menutup</span>
            <span data-i18n="footer_team">Pokédex - Kelompok 13 - Kelas A / A2</span>
        </footer>
    </div>
</dialog>
