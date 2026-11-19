# Pokédex Collection Tracker & Trainer Directory

Aplikasi web direktori dan pelacak koleksi Pokémon komprehensif berbasis **Laravel 11**, **PhpSpreadsheet**, **DataTables**, dan **WYSIWYG Editor**. Dirancang khusus untuk eksplorasi katalog master Pokémon (Pokemon Library) hingga 1.025 entitas (Gen I–IX), pelacakan koleksi tangkapan pemain (Pokédex Caught Tracker), pencatatan jurnal strategi trainer, serta ekspor-impor data multi-format (Excel & PDF).

Proyek ini dikembangkan oleh **Kelompok 13 (Kelas A / A2)** untuk memenuhi luaran tugas Praktikum Pemrograman Web (Pertemuan 1 s.d. 14), Sekolah Vokasi Institut Pertanian Bogor.

---

## Fitur Utama Aplikasi

* **Katalog Master Pokémon (Pokemon Library):** Eksplorasi direktori lengkap 1.025 Pokémon (Generasi I hingga IX) dengan pencarian cepat, filter multi-tipe elemen, dan filter generasi.
* **Modul Import Excel PhpSpreadsheet:** Pemasukan data katalog massal melalui berkas spreadsheet `.xlsx` dengan validasi 4 kolom wajib dan deteksi duplikasi.
* **Pelacak Koleksi Pokédex (DataTables Caught Tracker):** Tabel interaktif dinamis khusus untuk Pokémon yang telah ditangkap oleh trainer aktif, dilengkapi sorting, pagination, dan instan search.
* **Ekspor Multi-Format (PDF & Excel):** Pembuatan laporan koleksi Pokédex resmi berformat dokumen PDF (DomPDF) siap cetak dan berkas spreadsheet Excel.
* **Jurnal Catatan Taktik Trainer (WYSIWYG Editor):** Editor teks kaya untuk mendokumentasikan analisis strategi pertarungan, statistik tim, dan catatan lapangan Pokémon.
* **Manajemen Profil & Sesi Trainer:** Sistem login/registrasi trainer dengan penyimpanan sesi aktif dan visualisasi kelas trainer.
* **Antarmuka Modern Tactical Dark Glassmorphism:** Desain responsif berstandar tinggi dengan transisi halus, keyboard shortcut, dan modal statistik mendalam.

---

## Tim Pengembang (Kelompok 13 - Kelas A / A2)

| Foto / Avatar | Nama Anggota | NIM | Peran & Modul Utama | Cakupan Materi Praktikum |
|---|---|---|---|---|
| 🛡️ | **Yanuar Dwi Putra** | *[NIM]* | **Project Leader & Authentication Specialist** | **Pertemuan 5:** Sistem Autentikasi, Session Management, Proteksi Middleware, & Profil Trainer Aktif |
| ⚡ | **Arya Andra Diazka** | **J0404251155** | **Base Architecture & DevOps Integrator** | **Pertemuan 1 – 7, 11, 13:** Base MVC Architecture, UI Glassmorphism, PhpSpreadsheet Import, Git Workflow & Deployment |
| 📊 | **Madina Dwiyana Putri** | *[NIM]* | **DataTables & Multi-Format Export Specialist** | **Pertemuan 10 & 12:** DataTables Pokédex Caught List, Client-side Filtering, & Generator Ekspor PDF (DomPDF) / Excel |
| 📝 | **Iasha Irdanti** | *[NIM]* | **WYSIWYG Editor & Strategy Journal Specialist** | **Pertemuan 12:** Rich Text Editor (WYSIWYG), Catatan Taktis Pokémon, Sanitasi Konten HTML, & Modal Jurnal |

---

## Struktur Repositori

```
Pertemuan 999/
├── archives/          # Berkas arsip (.zip) rekam jejak versi rilis & changelog
│   ├── pokedex-app(v1.0).zip   # Base architecture rilis v1.0 oleh Arya
│   └── README.md               # Dokumentasi log rilis versi
├── datasets/          # 10 Berkas Master Excel (.xlsx) resmi 1.025 Pokémon (Gen I-IX)
├── design-assets/     # Wireframe, palet warna, dan aset desain visual
├── docs/              # Dokumentasi teknis & arsitektur sistem
│   └── arsitektur-sistem.md    # Spesifikasi teknis, ERD, dan diagram alur
└── src/               # Source code utama aplikasi Laravel 11
    ├── app/Http/Controllers/   # Controller logika aplikasi
    ├── database/migrations/    # Migrasi skema database
    ├── public/css/ & js/       # Styling dan logika interaktif frontend
    └── resources/views/        # Blade templates dan modular partials
```

---

## Panduan Menjalankan Proyek (Local Development)

### 1. Prasyarat Sistem
* PHP >= 8.2 (ekstensi `fileinfo`, `gd`, `zip`, `pdo_mysql` / `pdo_sqlite` aktif)
* Composer 2.x
* Git

### 2. Langkah Instalasi
1. Masuk ke direktori source code:
   ```bash
   cd src
   ```
2. Instal dependensi PHP menggunakan Composer:
   ```bash
   composer install
   ```
3. Konfigurasi berkas environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Jalankan migrasi basis data (dan seeder jika diperlukan):
   ```bash
   php artisan migrate
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka peramban dan akses alamat:
   ```
   http://127.0.0.1:8000
   ```

---

## Standar Kontribusi Git (GitLab Workflow)

1. Jangan melakukan *direct push* ke branch `main`.
2. Buat branch fitur sesuai nama dan modul masing-masing:
   * Yanuar: `feature/auth-trainer-session`
   * Arya: `feature/phpspreadsheet-library`
   * Madina: `feature/datatables-pdf-export`
   * Iasha: `feature/wysiwyg-trainer-journal`
3. Lakukan commit teratur dengan pesan yang deskriptif:
   ```bash
   git commit -m "feat(auth): implementasi session trainer dan form login"
   ```
4. Buat Merge Request (MR) ke branch `main` untuk direview bersama sebelum digabungkan.
