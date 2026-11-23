<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi Koleksi Pokédex - Kelompok 13</title>
    <style>
        @page { size: A4 portrait; margin: 20mm 15mm 20mm 15mm; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.4; font-size: 10pt; }
        .header { border-bottom: 2px solid #e11d48; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { margin: 0 0 4px 0; font-size: 18pt; color: #0f172a; }
        .header p { margin: 0; color: #64748b; font-size: 9pt; }
        .meta-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 18px; }
        .meta-table { width: 100%; border-collapse: collapse; }
        .meta-table td { padding: 3px 0; font-size: 9pt; }
        .meta-label { color: #64748b; font-weight: bold; width: 140px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background: #0f172a; color: #ffffff; padding: 7px 10px; font-size: 8.5pt; text-align: left; }
        .data-table td { padding: 6px 10px; font-size: 8.5pt; border-bottom: 1px solid #e2e8f0; }
        .data-table tr:nth-child(even) { background: #f8fafc; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 8pt; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>POKÉDEX TRAINER COLLECTION REPORT</h1>
        <p>Dokumen Resmi Pelaporan Koleksi Tangkapan Pokémon · Kelompok 13 (Kelas A / A2)</p>
    </div>

    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nama Trainer</td>
                <td>: <strong>{{ $trainer->name }}</strong> ({{ $trainer->role ?? 'Trainer' }})</td>
            </tr>
            <tr>
                <td class="meta-label">Kelas Trainer</td>
                <td>: {{ $trainer->trainer_class ?? 'Pokemon Trainer' }}</td>
            </tr>
            <tr>
                <td class="meta-label">Total Terkoleksi</td>
                <td>: <strong>{{ $total_caught }} Pokémon</strong></td>
            </tr>
            <tr>
                <td class="meta-label">Waktu Unduh</td>
                <td>: {{ $generated_at }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">NO</th>
                <th style="width: 80px;">INDEX</th>
                <th>NAMA POKÉMON</th>
                <th>TIPE ELEMEN</th>
                <th>GENERASI</th>
                <th>TANGGAL TANGKAP</th>
                <th>LOKASI PENANGKAPAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($catches as $idx => $c)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $c->pokemon->nomor_index }}</td>
                    <td><strong>{{ $c->pokemon->nama_pokemon }}</strong></td>
                    <td>{{ $c->pokemon->tipe }}</td>
                    <td>{{ $c->pokemon->generasi }}</td>
                    <td>{{ $c->caught_at ? $c->caught_at->format('d/m/Y') : '-' }}</td>
                    <td>{{ $c->location ?? 'Kanto Route' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #94a3b8;">
                        Belum ada koleksi Pokémon yang terdata.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Pokédex Collection Tracker · Kelompok 13 Pemrograman Web Sekolah Vokasi IPB
    </div>
</body>
</html>