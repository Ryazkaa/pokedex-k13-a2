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
            <a href="#home" class="is-current" data-i18n="nav_home">Beranda</a>
            <a href="#explore" data-i18n="nav_explore">Eksplorasi</a>
            <a href="#pokedex-caught" id="navCaughtLink" data-i18n="nav_caught">Koleksi</a>
            <a href="#search" data-focus-search data-i18n="nav_library">Pustaka</a>
        </nav>

        <div class="topbar__right">
            {{-- Tombol Switch Bahasa ID / EN --}}
            <button type="button" class="pill pill--dark topbar-lang-btn" id="langToggleBtn" title="Ganti Bahasa (Indonesia / English)" style="cursor: pointer; padding: 0.5rem 0.85rem; font-weight: 700; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
                <span id="langFlagContainer" style="display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 12px; border-radius: 2px; overflow: hidden; line-height: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.25);">
                    <svg viewBox="0 0 24 16" width="18" height="12" aria-hidden="true"><rect width="24" height="8" fill="#E70011"/><rect y="8" width="24" height="8" fill="#FFFFFF"/></svg>
                </span>
                <span id="langCurrentText">ID</span>
            </button>
            {{-- Status Akun Trainer / Quick Switch (Modul 1: Yanuar Dwi Prasetya) --}}
            @if (Auth::check())
                <div class="pill pill--dark topbar-auth-pill" style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0; padding: 0.5rem 0.9rem;">
                    @if (method_exists(Auth::user(), 'isDeveloper') && Auth::user()->isDeveloper())
                        <span class="badge topbar-auth-badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px; flex-shrink: 0;">DEV</span>
                    @else
                        <span class="badge topbar-auth-badge" style="background: #10b981; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px; flex-shrink: 0;">TRAINER</span>
                    @endif
                    <span class="topbar-auth-name" style="font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; display: inline-block; max-width: 160px; overflow: hidden; text-overflow: ellipsis; vertical-align: middle;" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                    <button type="button" class="topbar-auth-switch" onclick="document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null" style="background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0 4px; font-size: 0.85rem; line-height: 1; flex-shrink: 0; display: inline-flex; align-items: center;" title="Ganti / Kelola Akun" aria-label="Ganti atau kelola akun">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m16 3 4 4-4 4"/><path d="M20 7H4"/><path d="m8 21-4-4 4-4"/><path d="M4 17h16"/></svg>
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0; flex-shrink: 0;">
                        @csrf
                        <button type="submit" class="topbar-auth-logout" style="background: none; border: none; color: #ff4655; cursor: pointer; font-size: 0.75rem; font-weight: 600; padding: 0 4px; line-height: 1;" title="Keluar">Logout</button>
                    </form>
                </div>
            @else
                <button type="button" class="pill pill--dark topbar-login-btn" onclick="document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null" style="cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                    <span data-i18n="btn_login">Masuk</span>
                </button>
            @endif

            <details class="trainer" id="identityDropdown">
                <summary class="pill pill--crimson">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8.5" r="3.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M5.5 19.5a6.5 6.5 0 0 1 13 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span data-i18n="top_made_by">Made By</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="pill__chev"><path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </summary>
                <div class="trainer__menu fold-list" aria-label="Identitas Kelompok">
                    <div class="fold-row" style="--fold-i: 0">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label" data-i18n="id_group_lbl">Kelompok</span>
                            <strong class="identity-item__val" data-i18n="id_group_val">Kelompok 13</strong>
                        </div>
                    </div>
                    <div class="fold-row" style="--fold-i: 1">
                        <div class="fold-row__inner identity-item">
                            <span class="identity-item__label" data-i18n="id_class_lbl">Kelas Praktikum</span>
                            <strong class="identity-item__val" data-i18n="id_class_val">Kelas A / A2</strong>
                        </div>
                    </div>
                </div>
            </details>

            <button type="button" class="pill pill--dark topbar-menu-btn" id="menuBtn" aria-controls="drawer" aria-expanded="false" aria-label="Menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                <span class="topbar-menu-label">Menu</span>
            </button>
        </div>
    </div>
</header>
