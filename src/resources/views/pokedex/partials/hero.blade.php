{{-- Hero Banner: 20 Fun Facts dalam format Stack Slides (A stacked deck: the top card slides away, the next steps up) --}}
@php
    $funFacts = collect(config('pokedex.fun_facts', []))->shuffle()->values();
@endphp

<section id="home" class="hero section" aria-roledescription="carousel" aria-label="Fun Facts Dunia Pokémon">
    <div class="hero__deck" id="heroDeck">
        @foreach ($funFacts as $i => $fact)
            @php
                $artUrl = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/' . $fact['art_num'] . '.png';
                $previewText = \Illuminate\Support\Str::limit($fact['desc'], 148, '');
            @endphp
            <article class="hero__slide {{ $i === 0 ? 'is-active' : '' }}"
                     data-slot="{{ $i }}"
                     data-depth="{{ min($i, 4) }}"
                     data-fact-topic="{{ $fact['topic'] }}"
                     data-fact-topic-id="{{ $fact['topic'] }}"
                     data-fact-topic-en="{{ $fact['topic_en'] ?? $fact['topic'] }}"
                     data-fact-title="{{ $fact['title'] }}"
                     data-fact-title-id="{{ $fact['title'] }}"
                     data-fact-title-en="{{ $fact['title_en'] ?? $fact['title'] }}"
                     data-fact-desc="{{ $fact['desc'] }}"
                     data-fact-desc-id="{{ $fact['desc'] }}"
                     data-fact-desc-en="{{ $fact['desc_en'] ?? $fact['desc'] }}"
                     data-fact-category="{{ $fact['category'] }}"
                     data-fact-category-id="{{ $fact['category'] }}"
                     data-fact-category-en="{{ $fact['category_en'] ?? $fact['category'] }}"
                     data-fact-source="{{ $fact['source'] }}"
                     data-fact-source-id="{{ $fact['source'] }}"
                     data-fact-source-en="{{ $fact['source_en'] ?? $fact['source'] }}"
                     data-fact-art="{{ $artUrl }}"
                     data-fact-name="{{ $fact['art_name'] }}"
                     data-fact-no="#{{ str_pad((string) $fact['art_num'], 4, '0', STR_PAD_LEFT) }}"
                     aria-roledescription="slide"
                     aria-label="Fun Fact {{ $i + 1 }} dari {{ $funFacts->count() }}"
                     @if ($i !== 0) inert @endif>
                <div class="hero__card-bg" aria-hidden="true"></div>
                <div class="hero__text">
                    <p class="hero__eyebrow"><span data-i18n="hero_eyebrow_prefix">Fun Fact</span> · <span class="hero-topic-text">{{ $fact['topic'] }}</span></p>
                    <h2 class="hero__title hero__title--fact hero-title-text">{{ $fact['title'] }}</h2>
                    <p class="hero__lore">
                        <span class="hero-desc-preview">{{ $previewText }}…</span>
                        <button type="button"
                                class="hero__readmore"
                                data-open-fact="{{ $i }}"
                                aria-label="Baca selengkapnya tentang {{ $fact['title'] }}">
                            <span data-i18n="hero_readmore">(selengkapnya...)</span>
                        </button>
                    </p>
                    <div class="hero__meta">
                        <span class="fact-tag hero-cat-text">{{ $fact['category'] }}</span>
                        <span class="hero__gen hero-src-text">{{ $fact['source'] }}</span>
                    </div>
                </div>
                <img class="hero__art"
                     src="{{ $artUrl }}"
                     alt="{{ $fact['art_name'] }}"
                     width="440" height="440"
                     @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
            </article>
        @endforeach

        @if ($funFacts->count() > 1)
            <div class="hero__controls">
                <div class="hero__nav-btns" role="group" aria-label="Navigasi Fun Fact">
                    <button type="button" class="hero__deck-btn" id="heroPrev" aria-label="Fun Fact sebelumnya" title="Sebelumnya">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="hero__deck-btn" id="heroNext" aria-label="Fun Fact berikutnya" title="Berikutnya">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- Floating Card Popup untuk Fun Fact Lengkap (Animasi: A floating card springs down; its content arrives in a cascade) --}}
    <dialog id="factModal" class="fact-modal" closedby="any" aria-labelledby="factModalTitle">
        <div class="fact-modal__card">
            <div class="fact-modal__banner fact-cascade" style="--cascade-i: 0">
                <div class="fact-modal__banner-meta">
                    <p class="fact-modal__eyebrow" id="factModalTopic">Fun Fact</p>
                    <span class="fact-modal__poke-pill" id="factModalPoke">#0001</span>
                </div>
                <button type="button" class="fact-modal__close" data-close-dialog aria-label="Tutup Fun Fact">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                </button>
                <img class="fact-modal__art" id="factModalArt" src="" alt="" width="150" height="150">
            </div>

            <div class="fact-modal__body">
                <div class="fact-modal__tags fact-cascade" style="--cascade-i: 1">
                    <span class="fact-tag" id="factModalCategory">Kategori</span>
                    <span class="hero__gen" id="factModalSource">Sumber</span>
                </div>

                <h3 class="fact-modal__title fact-cascade" id="factModalTitle" style="--cascade-i: 2">Judul Fun Fact</h3>

                <p class="fact-modal__desc fact-cascade" id="factModalDesc" style="--cascade-i: 3"></p>

                <div class="fact-modal__foot fact-cascade" style="--cascade-i: 4">
                    <span class="fact-modal__hint" data-i18n="fact_modal_hint">Tekan <kbd>Esc</kbd> atau klik di luar kartu untuk menutup</span>
                    <button type="button" class="fact-modal__btn" data-close-dialog data-i18n="btn_close">Tutup</button>
                </div>
            </div>
        </div>
    </dialog>
</section>
