# Arsip Rilis & Rekam Jejak Versi (Release Archives)

Repositori ini menyimpan arsip kompresi (`.zip`) dari setiap pencapaian *milestone* dan checkpoint versi aplikasi **Pokédex Collection Tracker & Trainer Directory** sebagai bukti rekam jejak pengembangan perangkat lunak (versioning timeline).

---

## Daftar Berkas Arsip

| Berkas Arsip | Versi | Tanggal | Kontributor Utama | Cakupan Modul & Deskripsi |
|---|---|---|---|---|
| `pokedex-app(v1.0).zip` | `v1.0.0` | 19 November 2026 | **Arya Andra Diazka (J0404251155)** | **Base Architecture & Foundation**: HTML, CSS, JavaScript, PHP, Laravel MVC, CRUD, & PokéAPI Integration |
| *Checkpoints Tim (v1.1 - v1.4)* | `v1.x.x` | *Ongoing* | **Kelompok 13** | Integrasi modular: Session/Auth, PhpSpreadsheet, DataTables + PDF, & WYSIWYG |

---

## Detail Rilis Versi 1.0 (`v1.0.0`)

Versi 1.0 merupakan pondasi utama (*core base application*) yang dirancang, diarsiteki, dan dibangun secara mandiri oleh **Arya Andra Diazka** sebelum dibagi menjadi 4 modul penugasan kelompok. 

Pada versi ini, seluruh capaian materi kuliah dan praktikum dasar dari Pertemuan 1 hingga Pertemuan 7/8 telah terimplementasi secara penuh dan kokoh:

### 1. Fondasi Frontend Modern (Pertemuan 1 – 4)
* **HTML5 Semantik:** Struktur halaman berstandar W3C dengan aksesibilitas tinggi (`<main>`, `<section>`, `<nav>`, `<dialog>`, ARIA attributes).
* **CSS3 Custom Architecture (Modern Tactical Dark Glassmorphism):**
  * Desain UI bertema Pokémon Tactical Glassmorphism dengan palet merah-hitam cybernetic.
  * Sistem grid responsif, CSS variables, backdrop blur, fluid typography, dan efek visual state interaktif.
* **JavaScript Modern (ES6+):**
  * Manipulasi DOM interaktif tanpa ketergantungan library luar (vanilla JS).
  * Filter pencarian instan nama & nomor index, sorting dinamis (Index, Nama, Tipe, Generasi).
  * Modal showcase Pokémon dengan transisi smooth dan keyboard shortcuts (tekan `/` untuk search).

### 2. Arsitektur Framework & Backend (Pertemuan 4 – 6)
* **PHP 8.2+ & Laravel Framework:**
  * Pengkabelan routing terstruktur (`routes/web.php`).
  * Implementasi pola **Model-View-Controller (MVC)** yang bersih dan terpisah (*separation of concerns*).
  * Templating engine Blade modular (`layouts/app.blade.php`, `partials/navbar.blade.php`, `partials/hero.blade.php`, `partials/table.blade.php`, `partials/modal.blade.php`).

### 3. Modul CRUD & Integrasi API (Pertemuan 6 – 7)
* **Operasi CRUD (Create, Read, Update, Delete):**
  * Operasi pembacaan katalog direktori Pokémon dengan performa tinggi.
  * Mekanisme manipulasi status tangkapan (*caught*) dan penandaan favorit (*favorite*).
* **Integrasi API Eksternal (PokéAPI) & Internal API:**
  * Sinkronisasi data detail Pokémon, artwork resmi beresolusi tinggi, tipe elemen, dan statistik dasar.
  * Penyediaan endpoint internal JSON untuk kebutuhan data reaktif pada frontend.

---

## Roadmap Versi Selanjutnya (Modul Penugasan Kelompok 13)

Arsip versi berikutnya didokumentasikan berdasarkan penyelesaian modul oleh anggota tim:

* **Versi 1.1 (`v1.1.0`) — Modul Autentikasi & Multi-Trainer Role (Yanuar Dwi Putra)**
  * Sistem login/registrasi trainer, session handling, dan profil trainer aktif (Pertemuan 5).
* **Versi 1.2 (`v1.2.0`) — Modul Master Library & PhpSpreadsheet (Arya Andra Diazka)**
  * Import master data 1.025 Pokémon lintas Generasi I–IX via spreadsheet Excel `.xlsx` (Pertemuan 11).
* **Versi 1.3 (`v1.3.0`) — Modul DataTables & Cetak Laporan PDF (Madina Dwiyana Putri)**
  * Tabel Pokédex caught list dengan DataTables interaktif dan ekspor PDF DomPDF (Pertemuan 10 & 12).
* **Versi 1.4 (`v1.4.0`) — Modul WYSIWYG Jurnal Taktik Trainer (Iasha Irdanti)**
  * Editor teks kaya untuk catatan analisis dan strategi Pokémon (Pertemuan 12).
* **Versi 2.0 (`v2.0.0`) — Final Production Release (Kelompok 13)**
  * Konsolidasi final, deployment hosting, dan rilis repositori publik (Pertemuan 13 & 14).

---

## Petunjuk Ekstraksi Arsip Versi 1.0

Jika ingin meninjau kembali *clean code* versi awal sebelum penambahan modul tim:

1. Ekstrak berkas `pokedex-app(v1.0).zip` ke direktori lokal:
   ```bash
   unzip pokedex-app\(v1.0\).zip -d pokedex-base-v1/
   ```
2. Salin environment file dan instal dependensi composer:
   ```bash
   cd pokedex-base-v1
   composer install
   cp .env.example .env
   php artisan key:generate
   ```
3. Jalankan server pengujian:
   ```bash
   php artisan serve
   ```
