{{-- Tabel Pokédex (dark glassmorphism) --}}
<section id="search" class="pokedex section" aria-labelledby="pokedexTitle">
    <div class="pokedex__head">
        <div>
            <p class="section-kicker">Pokemon Library</p>
            <h2 id="pokedexTitle" class="section-title section-title--lg">Data Pokemon</h2>
        </div>
        <p class="pokedex__count" aria-live="polite">Menampilkan <strong id="resultCount">{{ $total }}</strong> dari {{ $total }} Pokémon</p>
    </div>

    <div class="toolbar" role="search">
        <label class="search-field">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2.2"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
            <span class="visually-hidden">Cari Pokémon</span>
            <input type="search" id="searchInput" placeholder="Cari nama atau nomor index…" autocomplete="off" enterkeyhint="search">
            <kbd aria-hidden="true">/</kbd>
        </label>
        <label class="select-field">
            <span class="visually-hidden">Filter tipe</span>
            <select id="typeFilter">
                <option value="">Semua tipe ({{ count($typeMeta) }})</option>
                @foreach ($typeMeta as $typeKey => $meta)
                    @php $tLabel = $meta['label']; @endphp
                    <option value="{{ $tLabel }}">{{ $tLabel }} ({{ $tipeCounts[$tLabel] ?? 0 }})</option>
                @endforeach
            </select>
        </label>
        <label class="select-field">
            <span class="visually-hidden">Filter generasi</span>
            <select id="genFilter">
                <option value="">Semua generasi (Gen I – IX)</option>
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
        </label>
    </div>

    <div class="table-wrap glass">
        <table class="dex-table">
            <thead>
                <tr>
                    <th scope="col" aria-sort="ascending"><button type="button" data-sort="num">Nomor Index <span class="sort-ind" aria-hidden="true"></span></button></th>
                    <th scope="col" aria-sort="none"><button type="button" data-sort="name">Nama Pokémon <span class="sort-ind" aria-hidden="true"></span></button></th>
                    <th scope="col" aria-sort="none"><button type="button" data-sort="tipe">Tipe <span class="sort-ind" aria-hidden="true"></span></button></th>
                    <th scope="col" aria-sort="none"><button type="button" data-sort="gen">Generasi <span class="sort-ind" aria-hidden="true"></span></button></th>
                    <th scope="col" class="col-arrow"><span class="visually-hidden">Aksi</span></th>
                </tr>
            </thead>
            <tbody id="dexBody">
                @foreach ($pokemons as $p)
                    <tr class="dex-row" data-no="{{ $p->nomor_index }}" data-num="{{ $p->number }}"
                        data-name="{{ strtolower($p->nama_pokemon) }}" data-tipe="{{ strtolower($p->tipe) }}"
                        data-types="{{ strtolower(implode('|', $p->type_list)) }}" data-gen="{{ $p->generasi }}" data-gen-num="{{ $p->gen_number }}">
                        <td data-label="Nomor Index">
                            <span class="dex-no">
                                <img src="{{ $p->sprite_url }}" alt="" loading="lazy" width="48" height="48">
                                {{ $p->nomor_index }}
                            </span>
                        </td>
                        <td data-label="Nama Pokémon">
                            <button type="button" class="row-link" data-open-pokemon="{{ $p->nomor_index }}">{{ $p->nama_pokemon }}</button>
                        </td>
                        <td data-label="Tipe">@include('pokedex.partials.type-badges', ['types' => $p->type_list, 'iconOnly' => true])</td>
                        <td data-label="Generasi" class="dex-gen">{{ $p->generasi }}</td>
                        <td class="col-arrow" aria-hidden="true">
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Empty state: database kosong --}}
        <div class="table-empty" id="emptyState" @if ($total > 0) hidden @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M2.5 12h7m5 0h7" stroke="currentColor" stroke-width="1.4"/><circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>
            <p><strong>Belum ada Pokémon.</strong> Import file .xlsx untuk memulai.</p>
            <button type="button" class="action-pill action-pill--primary" data-action="import">Import Excel</button>
        </div>

        {{-- Tidak ada hasil pencarian --}}
        <div class="table-empty" id="noResult" hidden>
            <p>Tidak ada Pokémon yang cocok dengan <strong id="noResultQuery"></strong>.</p>
            <button type="button" class="action-pill action-pill--ghost" data-reset-filters>Reset filter</button>
        </div>
    </div>

    <nav class="pager" id="pager" aria-label="Halaman tabel"></nav>
</section>
