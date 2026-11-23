{{-- Top Navigation Bar (sticky) --}}
<header class="topbar" id="topbar">
    <div class="topbar__inner shell">
        <div class="topbar__left">
            <a href="#home" class="brand-logo" aria-label="Pokédex — kembali ke atas">
                <span class="brand-logo__icon" aria-hidden="true">
                    <img src="{{ asset('images/pokeball.svg') }}" alt="Pokédex" width="36" height="36">
                </span>
                <span class="brand-logo__text">Pokédex</span>
            </a>
        </div>

        <nav class="nav-links" id="navLinks" aria-label="Navigasi utama">
            <span class="nav-pill" id="navPill" aria-hidden="true"></span>
            <a href="#home" class="is-current">Home</a>
            <a href="#explore">Explore</a>
            <a href="#search" data-focus-search>Library</a>
            <a href="#pokedex-caught" id="navCaughtLink">Koleksi</a>
        </nav>

        <div class="topbar__right">
            {{-- Status Akun Trainer / Quick Switch (Modul 1: Yanuar Dwi Prasetya) --}}
            @if (Auth::check())
                <div class="pill pill--dark" style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0; padding: 0.5rem 0.9rem;">
                    @if (method_exists(Auth::user(), 'isDeveloper') && Auth::user()->isDeveloper())
                        <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px; flex-shrink: 0;">DEV</span>
                    @else
                        <span class="badge" style="background: #10b981; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px; flex-shrink: 0;">TRAINER</span>
                    @endif
                    <span style="font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; display: inline-block; max-width: 160px; overflow: hidden; text-overflow: ellipsis; vertical-align: middle;" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                    <button type="button" onclick="document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null" style="background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0 4px; font-size: 0.85rem; line-height: 1; flex-shrink: 0;" title="Ganti / Kelola Akun">⇄</button>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0; flex-shrink: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #ff4655; cursor: pointer; font-size: 0.75rem; font-weight: 600; padding: 0 4px; line-height: 1;" title="Keluar">Logout</button>
                    </form>
                </div>
            @else
                <button type="button" class="pill pill--dark" onclick="document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null" style="cursor: pointer; white-space: nowrap;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                    <span>Masuk</span>
                </button>
            @endif

            <details class="trainer" id="identityDropdown">
                <summary class="pill pill--crimson">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8.5" r="3.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M5.5 19.5a6.5 6.5 0 0 1 13 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Made By</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="pill__chev"><path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </summary>
                <div class="trainer__menu fold-list" aria-label="Identitas Kelompok">
                    <div class="fold-row" style="--fold-i: 0">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label">Kelompok</span>
                            <strong class="identity-item__val">Kelompok 13</strong>
                        </div>
                    </div>
                    <div class="fold-row" style="--fold-i: 1">
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
