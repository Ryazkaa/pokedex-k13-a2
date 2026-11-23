{{-- Modal Popup Notifikasi & Alert Beranimasi di Tengah Layar --}}
@php
    $hasAlert = $importResult || $errors->any() || session('notice') || session('success');
    $isAuthError = false;
    if ($errors->any()) {
        foreach ($errors->all() as $err) {
            if (stripos($err, 'kata sandi') !== false || stripos($err, 'email') !== false || stripos($err, 'login') !== false || stripos($err, 'auth') !== false) {
                $isAuthError = true;
                break;
            }
        }
    }
@endphp

@if ($hasAlert)
<div id="sessionNotificationModal" class="pkm-modal" role="dialog" aria-modal="true" aria-labelledby="sessionAlertTitle">
    <div class="pkm-modal__backdrop" onclick="closeSessionNotificationModal()"></div>
    <div class="pkm-modal__dialog" style="max-width: 460px; text-align: center; padding: 32px 26px; border-radius: 14px; border: 1px solid {{ $errors->any() ? 'rgba(255, 70, 85, 0.45)' : 'rgba(16, 185, 129, 0.45)' }}; box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 35px {{ $errors->any() ? 'rgba(255, 70, 85, 0.25)' : 'rgba(16, 185, 129, 0.25)' }}; animation: pkmModalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <button type="button" onclick="closeSessionNotificationModal()" style="position: absolute; right: 14px; top: 14px; background: none; border: none; font-size: 1.6rem; color: #94A3B8; cursor: pointer; line-height: 1; transition: color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94A3B8'">&times;</button>

        {{-- Ikon Bulat Berdenyut --}}
        @if ($errors->any())
            <div class="lock-icon-pulse" style="width: 72px; height: 72px; border-radius: 50%; background: rgba(255, 70, 85, 0.12); border: 2.5px solid #ff4655; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px;">
                <svg viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #ff4655;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h3 id="sessionAlertTitle" style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0;">
                {{ $isAuthError ? 'Gagal Masuk Akun' : 'Pemberitahuan Sistem' }}
            </h3>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 70, 85, 0.16); color: #F43F5E; border: 1px solid rgba(255, 70, 85, 0.35); font-size: 0.72rem; font-weight: 800; padding: 3px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 16px;">
                <span>{{ $isAuthError ? 'Autentikasi Diperlukan' : 'Periksa Kembali Input' }}</span>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0 0 24px 0; text-align: left; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 12px 16px;">
                @foreach ($errors->all() as $error)
                    <li style="font-size: 0.88rem; color: #CBD5E1; line-height: 1.5; display: flex; align-items: flex-start; gap: 8px; margin-bottom: 4px;">
                        <span style="color: #ff4655; font-weight: bold;">•</span>
                        <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @if ($isAuthError)
                    <button type="button" onclick="closeSessionNotificationModal(true)"
                            class="action-pill action-pill--primary"
                            style="width: 100%; justify-content: center; padding: 12px; font-weight: 700; font-size: 0.9rem; border-radius: 8px; background: var(--crimson, #ff4655); box-shadow: 0 4px 14px rgba(255, 70, 85, 0.4); border: none; color: #fff; cursor: pointer;">
                        <span style="margin-right: 6px;">⚡</span> Buka Menu Login / Daftar
                    </button>
                @endif
                <button type="button" onclick="closeSessionNotificationModal()"
                        class="action-pill action-pill--ghost"
                        style="width: 100%; justify-content: center; padding: 10px; font-weight: 600; font-size: 0.84rem; color: #94A3B8; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; cursor: pointer;">
                    Tutup
                </button>
            </div>

        @elseif ($importResult)
            <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); border: 2.5px solid #10b981; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px;">
                <svg viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #10b981;" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
            <h3 id="sessionAlertTitle" style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin: 0 0 6px 0;">
                Proses Import Selesai
            </h3>
            @if (!empty($importResult['file']))
                <p style="font-size: 0.8rem; color: #94A3B8; margin: 0 0 16px 0;">Berkas: {{ $importResult['file'] }}</p>
            @endif
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 22px;">
                <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; padding: 10px;">
                    <strong style="display: block; font-size: 1.2rem; color: #34d399;">{{ $importResult['berhasil'] ?? 0 }}</strong>
                    <span style="font-size: 0.72rem; color: #94A3B8;">Berhasil</span>
                </div>
                <div style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 10px;">
                    <strong style="display: block; font-size: 1.2rem; color: #fbbf24;">{{ $importResult['duplikat'] ?? 0 }}</strong>
                    <span style="font-size: 0.72rem; color: #94A3B8;">Duplikat</span>
                </div>
                <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 10px;">
                    <strong style="display: block; font-size: 1.2rem; color: #f87171;">{{ $importResult['tidak_valid'] ?? 0 }}</strong>
                    <span style="font-size: 0.72rem; color: #94A3B8;">Tidak Valid</span>
                </div>
            </div>
            <button type="button" onclick="closeSessionNotificationModal()"
                    class="action-pill action-pill--primary"
                    style="width: 100%; justify-content: center; padding: 11px; font-weight: 700; font-size: 0.88rem; border-radius: 8px; background: #10b981; border: none; color: #fff; cursor: pointer;">
                OK, Mengerti
            </button>

        @elseif (session('notice') || session('success'))
            <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(56, 189, 248, 0.15); border: 2.5px solid #38bdf8; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px;">
                <svg viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #38bdf8;" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
            </div>
            <h3 id="sessionAlertTitle" style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin: 0 0 8px 0;">
                Pemberitahuan
            </h3>
            <p style="font-size: 0.9rem; color: #CBD5E1; line-height: 1.5; margin: 0 0 22px 0;">
                {{ session('notice') ?? session('success') }}
            </p>
            <button type="button" onclick="closeSessionNotificationModal()"
                    class="action-pill action-pill--primary"
                    style="width: 100%; justify-content: center; padding: 11px; font-weight: 700; font-size: 0.88rem; border-radius: 8px; background: var(--crimson, #ff4655); border: none; color: #fff; cursor: pointer;">
                OK, Lanjutkan
            </button>
        @endif
    </div>
</div>

<script>
window.closeSessionNotificationModal = function(openAuth = false) {
    const modal = document.getElementById('sessionNotificationModal');
    if (modal) modal.hidden = true;
    if (openAuth && typeof window.openAuthModal === 'function') {
        window.openAuthModal('loginTab');
    }
};
</script>
@endif
