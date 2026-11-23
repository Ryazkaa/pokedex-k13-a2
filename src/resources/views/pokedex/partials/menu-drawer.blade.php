{{-- Side Drawer menu: Drawer springs in from the right as the page dims, Rows stagger in --}}
<dialog id="drawer" class="drawer" closedby="any" aria-label="Menu navigasi">
    <div class="drawer__sheet">
        <div class="drawer__head drawer-stagger" style="--row-i: 0">
            <p class="drawer__brand">
                <img src="{{ asset('images/pokeball.svg') }}" alt="Pokédex" width="24" height="24" style="vertical-align: middle; margin-right: 6px;">
                <span>Pokédex</span>
            </p>
            <button type="button" class="icon-btn icon-btn--ghost" data-close-dialog aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
            </button>
        </div>

        <p class="drawer__label drawer-stagger" style="--row-i: 1" data-i18n="drawer_label_nav">Navigasi</p>
        <nav class="drawer__nav" aria-label="Navigasi menu">
            <a href="#home" class="drawer-stagger" style="--row-i: 2" data-close-dialog>
                <span data-i18n="nav_home">Beranda</span>
                <small data-i18n="nav_home_sub">Fun Facts Pokémon</small>
            </a>
            <a href="#explore" class="drawer-stagger" style="--row-i: 3" data-close-dialog>
                <span data-i18n="nav_explore">Eksplorasi</span>
                <small data-i18n="nav_explore_sub">Kontrol Data &amp; Statistik</small>
            </a>
            <a href="#pokedex-caught" class="drawer-stagger" style="--row-i: 4" data-close-dialog>
                <span data-i18n="nav_caught">Koleksi</span>
                <small data-i18n="nav_caught_sub">Pokédex Caught Tracker</small>
            </a>
            <a href="#search" class="drawer-stagger" style="--row-i: 5" data-close-dialog data-focus-search>
                <span data-i18n="nav_library">Pustaka</span>
                <small data-i18n="nav_library_sub">Tabel Data Pokédex</small>
            </a>
        </nav>

        <p class="drawer__label drawer-stagger" style="--row-i: 6" data-i18n="drawer_label_account">Akun Trainer</p>
        <div class="drawer__actions drawer-stagger" style="--row-i: 7; display: flex; flex-direction: column; gap: 8px;">
            @if (Auth::check())
                <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                            @if (method_exists(Auth::user(), 'isDeveloper') && Auth::user()->isDeveloper())
                                <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">DEV</span>
                            @else
                                <span class="badge" style="background: #10b981; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">TRAINER</span>
                            @endif
                            <strong style="font-size: 0.88rem; color: #f8fafc;">{{ Auth::user()->name }}</strong>
                        </div>
                        <small style="color: #94a3b8; font-size: 0.75rem;">{{ Auth::user()->email }}</small>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="action-pill" style="flex: 1; text-align: center; justify-content: center; display: inline-flex; align-items: center; gap: 6px;" onclick="const d=document.getElementById('drawer'); if(d) d.close(); document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m16 3 4 4-4 4"/><path d="M20 7H4"/><path d="m8 21-4-4 4-4"/><path d="M4 17h16"/></svg>
                        <span data-i18n="btn_switch_acc">Ganti Akun</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="submit" class="action-pill" style="width: 100%; text-align: center; justify-content: center; color: #ff4655; border-color: rgba(255, 70, 85, 0.4); display: inline-flex; align-items: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            <span data-i18n="btn_logout">Keluar</span>
                        </button>
                    </form>
                </div>
            @else
                <button type="button" class="action-pill" style="width: 100%; text-align: center; justify-content: center; background: rgba(255, 70, 85, 0.15); border-color: #ff4655; color: #fff; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;" onclick="const d=document.getElementById('drawer'); if(d) d.close(); document.getElementById('authModal') ? document.getElementById('authModal').hidden = false : null">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                    <span data-i18n="btn_login_or_register">Masuk / Daftar Akun</span>
                </button>
            @endif
        </div>

        <p class="drawer__label drawer-stagger" style="--row-i: 8" data-i18n="drawer_label_lang">Bahasa / Language</p>
        <div class="drawer__actions drawer-stagger" style="--row-i: 9; display: flex; gap: 8px;">
            <button type="button" class="chip lang-choice-btn" data-lang="id" style="flex: 1; justify-content: center; padding: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 24 16" width="18" height="12" style="border-radius: 2px; overflow: hidden; border: 1px solid rgba(255,255,255,0.25);" aria-hidden="true"><rect width="24" height="8" fill="#E70011"/><rect y="8" width="24" height="8" fill="#FFFFFF"/></svg>
                <span>Indonesia</span>
            </button>
            <button type="button" class="chip lang-choice-btn" data-lang="en" style="flex: 1; justify-content: center; padding: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 60 30" width="18" height="12" style="border-radius: 2px; overflow: hidden; border: 1px solid rgba(255,255,255,0.25);" aria-hidden="true"><clipPath id="uk-clip-dr"><rect width="60" height="30"/></clipPath><g clip-path="url(#uk-clip-dr)"><rect width="60" height="30" fill="#012169"/><path d="M0 0 L60 30 M60 0 L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0 L60 30 M60 0 L0 30" stroke="#C8102E" stroke-width="2"/><path d="M30 0 v30 M0 15 h60" stroke="#fff" stroke-width="10"/><path d="M30 0 v30 M0 15 h60" stroke="#C8102E" stroke-width="6"/></g></svg>
                <span>English</span>
            </button>
        </div>

        <p class="drawer__foot drawer-stagger" style="--row-i: 10">
            <span id="drawerTotalText">{{ $total }} Pokémon tercatat di Pustaka</span>
        </p>
    </div>
</dialog>
