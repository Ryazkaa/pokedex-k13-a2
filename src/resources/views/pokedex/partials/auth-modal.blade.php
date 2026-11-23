{{-- Modal Autentikasi & Switch Role Trainer (Yanuar Dwi Prasetya) --}}
<div id="authModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="authModalTitle" hidden>
    <div class="pkm-modal__backdrop" data-close-auth-modal></div>
    <div class="pkm-modal__dialog">
        <div class="pkm-modal__header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="brand-logo__icon" style="width: 28px; height: 28px; display: inline-flex;">
                    <img src="{{ asset('images/pokeball.svg') }}" alt="Pokédex" width="26" height="26">
                </span>
                <h3 id="authModalTitle" class="pkm-modal__title">Manajemen Akun Trainer</h3>
            </div>
            <button type="button" class="pkm-modal__close" data-close-auth-modal aria-label="Tutup modal">&times;</button>
        </div>

        <div class="auth-tabs">
            <button type="button" class="auth-tab active" data-tab="loginTab">Login</button>
            <button type="button" class="auth-tab" data-tab="registerTab">Daftar</button>
            <button type="button" class="auth-tab" data-tab="switchTab">⚡ Switch Dev (K13)</button>
        </div>

        <div class="pkm-modal__body">
            {{-- Tab 1: Form Login --}}
            <div id="loginTab" class="auth-pane">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="field-label" for="loginEmail">Email Trainer</label>
                        <input type="email" name="email" id="loginEmail" class="text-input" placeholder="contoh: yanuar@apps.ipb.ac.id" required>
                    </div>
                    <div class="form-group">
                        <label class="field-label" for="loginPassword">Kata Sandi</label>
                        <input type="password" name="password" id="loginPassword" class="text-input" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="action-pill action-pill--primary" style="width: 100%; justify-content: center; padding: 12px; margin-top: 8px;">Masuk ke Pokédex</button>
                </form>
            </div>

            {{-- Tab 2: Form Register --}}
            <div id="registerTab" class="auth-pane" hidden>
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="field-label" for="regName">Nama Trainer</label>
                        <input type="text" name="name" id="regName" class="text-input" placeholder="Nama Lengkap Trainer" required>
                    </div>
                    <div class="form-group">
                        <label class="field-label" for="regEmail">Email Trainer</label>
                        <input type="email" name="email" id="regEmail" class="text-input" placeholder="trainer@domain.com" required>
                    </div>
                    <div class="form-group">
                        <label class="field-label" for="regPass">Kata Sandi (min. 6 karakter)</label>
                        <input type="password" name="password" id="regPass" class="text-input" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label class="field-label" for="regPassConf">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="regPassConf" class="text-input" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="action-pill action-pill--primary" style="width: 100%; justify-content: center; padding: 12px; margin-top: 8px;">Daftar Trainer Baru</button>
                </form>
            </div>

            {{-- Tab 3: Quick Switch Developer Kelompok 13 --}}
            <div id="switchTab" class="auth-pane" hidden>
                <p style="font-size: 0.85rem; color: #94A3B8; margin-bottom: 14px;">
                    Klik nama anggota untuk beralih instan dengan role <strong style="color: var(--crimson, #ff4655);">DEVELOPER</strong>:
                </p>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('trainer.switch', 1) }}" class="switch-dev-item">
                        <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">DEV</span>
                        <strong>Yanuar Dwi Prasetya</strong>
                        <span style="margin-left: auto; font-size: 0.78rem; color: #94a3b8;">J0404251022</span>
                    </a>
                    <a href="{{ route('trainer.switch', 2) }}" class="switch-dev-item">
                        <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">DEV</span>
                        <strong>Arya Andra Diazka</strong>
                        <span style="margin-left: auto; font-size: 0.78rem; color: #94a3b8;">J0404251155</span>
                    </a>
                    <a href="{{ route('trainer.switch', 3) }}" class="switch-dev-item">
                        <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">DEV</span>
                        <strong>Madina Dwiyana Putri</strong>
                        <span style="margin-left: auto; font-size: 0.78rem; color: #94a3b8;">J0404251090</span>
                    </a>
                    <a href="{{ route('trainer.switch', 4) }}" class="switch-dev-item">
                        <span class="badge" style="background: var(--crimson, #ff4655); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px;">DEV</span>
                        <strong>Iasha Irdanti</strong>
                        <span style="margin-left: auto; font-size: 0.78rem; color: #94a3b8;">J0404251115</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.auth-tab');
    const panes = document.querySelectorAll('.auth-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.hidden = true);

            this.classList.add('active');
            const targetPane = document.getElementById(this.dataset.tab);
            if (targetPane) targetPane.hidden = false;
        });
    });

    // Close modal trigger
    document.querySelectorAll('[data-close-auth-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const m = document.getElementById('authModal');
            if (m) m.hidden = true;
        });
    });
});
</script>
