{{-- Notifikasi hasil import & pesan lain --}}
<div class="alerts" id="alerts">
    @if ($importResult)
        <section class="alert alert--result" role="status" aria-live="polite">
            <div class="alert__head">
                <p class="alert__title">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 5 5 9-10" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Proses import selesai
                    @if (! empty($importResult['file']))
                        <span class="alert__file">— {{ $importResult['file'] }}</span>
                    @endif
                </p>
                <button type="button" class="alert__close" data-dismiss-alert aria-label="Tutup notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </button>
            </div>
            <div class="stat-tiles">
                <div class="stat-tile stat-tile--ok"><strong>{{ $importResult['berhasil'] ?? 0 }}</strong><span>Data berhasil</span></div>
                <div class="stat-tile stat-tile--dup"><strong>{{ $importResult['duplikat'] ?? 0 }}</strong><span>Data ditolak (duplikat)</span></div>
                <div class="stat-tile stat-tile--bad"><strong>{{ $importResult['tidak_valid'] ?? 0 }}</strong><span>Data tidak valid</span></div>
            </div>
        </section>
    @endif

    @if ($errors->any())
        <section class="alert alert--error" role="alert">
            <div class="alert__head">
                <p class="alert__title">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8v5m0 3.5v.01M10.3 3.9 2.4 18a2 2 0 0 0 1.7 3h15.8a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Import gagal
                </p>
                <button type="button" class="alert__close" data-dismiss-alert aria-label="Tutup notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </button>
            </div>
            <ul class="alert__list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    @if (session('notice'))
        <section class="alert alert--info" role="status">
            <div class="alert__head">
                <p class="alert__title">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v6m0-9.5v.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                    {{ session('notice') }}
                </p>
                <button type="button" class="alert__close" data-dismiss-alert aria-label="Tutup notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                </button>
            </div>
        </section>
    @endif
</div>
