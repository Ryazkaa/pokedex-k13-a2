{{-- Top Navigation Bar (sticky) --}}
<header class="topbar" id="topbar">
    <div class="topbar__inner shell">
        <div class="topbar__left">
            <a href="#home" class="brand-logo" aria-label="Pokedex — kembali ke atas">
                <span class="brand-logo__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M2.5 12h7m5 0h7" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3 11.5a9 9 0 0 1 18 0" fill="currentColor" opacity=".35"/></svg>
                </span>
                <span class="brand-logo__text">Pokédex</span>
            </a>
        </div>

        <nav class="nav-links" id="navLinks" aria-label="Navigasi utama">
            <span class="nav-pill" id="navPill" aria-hidden="true"></span>
            <a href="#home" class="is-current">Home</a>
            <a href="#explore">Explore</a>
            <a href="#search" data-focus-search>Library</a>
        </nav>

        <div class="topbar__right">
            <details class="trainer" id="identityDropdown">
                <summary class="pill pill--crimson">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8.5" r="3.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M5.5 19.5a6.5 6.5 0 0 1 13 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Made By</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="pill__chev"><path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </summary>
                <div class="trainer__menu fold-list" aria-label="Identitas Mahasiswa">
                    <div class="fold-row" style="--fold-i: 0">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label">Nama Lengkap</span>
                            <strong class="identity-item__val">Arya Andra Diazka</strong>
                        </div>
                    </div>
                    <div class="fold-row" style="--fold-i: 1">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label">NIM</span>
                            <strong class="identity-item__val identity-item__val--mono">J0404251155</strong>
                        </div>
                    </div>
                    <div class="fold-row" style="--fold-i: 2">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label">Kelas Praktikum</span>
                            <strong class="identity-item__val">Kelas A / A2</strong>
                        </div>
                    </div>
                </div>
            </details>

            <button type="button" class="pill pill--dark" id="menuBtn" aria-controls="drawer" aria-expanded="false">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                <span>Menu</span>
            </button>
        </div>
    </div>
</header>
