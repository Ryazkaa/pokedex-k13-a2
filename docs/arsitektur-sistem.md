# Dokumen Arsitektur Sistem: Pokédex Collection Tracker & Trainer Directory

**Versi Dokumen:** 1.1.0  
**Tanggal Rilis:** 20 November 2026  
**Pengembang:** Kelompok 13 — Kelas Praktikum Pemrograman Web A / A2  
* Arya Andra Diazka (J0404251155) — *Lead Architect & DevOps*
* Yanuar Dwi Putra (J0404251139) — *Security & Authentication Engineer*
* Madina Dwiyana Putri (J0404251097) — *Database & Collection DataTables Engineer*
* Iasha Irdanti (J0404251053) — *UI/UX & Interactive Journal Engineer*

---

## 1. Ikhtisar Arsitektur Perangkat Lunak

Aplikasi **Pokédex Collection Tracker & Trainer Directory** mengadopsi pola desain arsitektur **Model-View-Controller (MVC)** monolitik modern berbasis **Laravel 11 (PHP 8.2+)**. Sistem ini memadukan keandalan basis data relasional **MySQL 8.0+**, estetika antarmuka modern **Dark Futuristic Bento Glassmorphism**, serta ekosistem pustaka pihak ketiga berstandar industri.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                             CLIENT LAYER (BROWSER)                          │
│   Vanilla JS (ES6+) • DataTables • Quill.js WYSIWYG • Bento UI Glassmorphism│
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ HTTP / REST AJAX
┌──────────────────────────────────────▼──────────────────────────────────────┐
│                            LARAVEL 11 MVC BACKEND                           │
│  ┌───────────────────────┐ ┌──────────────────────┐ ┌────────────────────┐  │
│  │     ROUTING & MW      │ │     CONTROLLERS      │ │      SERVICES      │  │
│  │ • EnsureDeveloper     │ │ • AuthController     │ │ • PhpSpreadsheet   │  │
│  │ • Auth Middleware     │ │ • PokemonLibraryCtrl │ │ • Barryvdh DomPDF  │  │
│  │ • Guest Middleware    │ │ • PokedexCatchCtrl   │ │ • PokéAPI Client   │  │
│  │                       │ │ • TrainerJournalCtrl │ │ • HTML Purifier    │  │
│  └───────────────────────┘ └──────────────────────┘ └────────────────────┘  │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Eloquent ORM
┌──────────────────────────────────────▼──────────────────────────────────────┐
│                              DATABASE (MYSQL 8.0)                           │
│  • users (role: developer/trainer)    • trainer_catches (caught tracking)   │
│  • pokemon (1025 master records)      • trainer_notes (WYSIWYG tactics)     │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Pemisahan Konsep Inti (Core Concept Distinction v1.1)

Untuk mencegah kerancuan data dan memenuhi persyaratan proyek perkuliahan secara elegan, aplikasi memisahkan sistem menjadi dua domain utama:

### 2.1. Pokemon Library (Master Catalog 1.025 Entri)
* **Karakteristik:** Bertindak sebagai ensiklopedia referensi resmi seluruh 1.025 Pokémon (Generasi I hingga Generasi IX / Paldea).
* **Hak Akses Trainer:** *Read-Only*. Trainer umum hanya dapat mencari, menyaring tipe elemen, memilih generasi 1–9, dan melihat detail profil Pokémon.
* **Hak Akses Developer:** Akun dengan role `developer` (Yanuar, Arya, Madina, Iasha) memiliki otorisasi untuk melakukan **Import Master Dataset (.xlsx)** melalui pustaka `PhpSpreadsheet` guna memperbarui katalog master atau menambahkan entitas baru (misal Pokémon #1026+ di masa depan).
* **Kebijakan Ekspor:** Tombol ekspor pada halaman Library ditiadakan karena fitur ekspor ditujukan khusus untuk mendokumentasikan progres koleksi tangkapan pribadi pada halaman Pokédex.

### 2.2. Pokédex (Trainer Caught Tracker & Interactive Collection)
* **Karakteristik:** Direktori tangkapan aktif (*caught collection*) milik akun trainer yang sedang login.
* **Fitur Utama:**
  1. **Modal "+ Tambah Koleksi" (Integrasi PokéAPI):** Trainer dapat menambahkan Pokémon yang berhasil ditangkap dengan memasukkan nomor indeks, menekan tombol **"Ambil PokéAPI"** (data nama, tipe utama, tipe sekunder, generasi, dan preview sprite terisi otomatis), lalu menyimpan ke koleksi pribadi.
  2. **Tabel Interaktif DataTables:** Menampilkan daftar Pokémon yang telah dikoleksi dengan fitur pencarian kilat, pagination dinamis, multi-column sorting, dan tombol aksi cepat.
  3. **Ekspor Multi-Format:** Mendukung ekspor koleksi ke **Excel (.xlsx)** dan cetak dokumen resmi **PDF berstandar A4 (DomPDF)**.
  4. **Jurnal Taktik & Catatan Lapangan (WYSIWYG):** Setiap Pokémon dalam koleksi dapat dilengkapi dengan informasi tanggal tangkap, lokasi penangkapan (misal *Route 102*, *Viridian Forest*), serta analisis strategi bertarung menggunakan teks berformat kaya (Quill.js WYSIWYG).

---

## 3. Sistem Peran Pengguna (Role-Based Access Control)

Sistem membedakan dua tingkatan hak akses:

| Properti | Role: `developer` | Role: `trainer` |
|---|---|---|
| **Daftar Akun** | Yanuar Dwi Putra, Arya Andra Diazka, Madina Dwiyana Putri, Iasha Irdanti | Pengguna umum yang mendaftar melalui formulir registrasi |
| **Identitas Visual** | Lencana merah menyala (*badge*) bertuliskan `DEVELOPER` pada navbar | Lencana hijau/biru bertuliskan `TRAINER` pada navbar |
| **Akses Pokemon Library** | Melihat katalog master + Otoritas penuh **Import Excel (.xlsx)** dan menambah master #1026+ | Melihat katalog master (*Read-Only*) |
| **Akses Pokédex Koleksi** | Memiliki koleksi pribadi, dapat mencatat tangkapan, dan mengekspor data | Mengelola koleksi pribadi, mencatat tangkapan, dan mengekspor data |
| **Perlindungan Rute** | Dilindungi oleh middleware `EnsureDeveloper` | Dilindungi oleh autentikasi sesi umum |

---

## 4. Skema Basis Data Relasional (Database Schema)

```
┌───────────────────────────┐         ┌───────────────────────────┐
│           users           │         │          pokemon          │
├───────────────────────────┤         ├───────────────────────────┤
│ id (PK, unsignedBigInt)   │         │ id (PK, unsignedBigInt)   │
│ name (varchar 255)        │         │ nomor_index (varchar 20)  │
│ email (varchar 255, unique│         │ nama_pokemon (varchar 100)│
│ password (varchar 255)    │         │ tipe (varchar 100)        │
│ role (enum: dev, trainer) │         │ generasi (varchar 50)     │
│ trainer_class (varchar 50)│         │ sprite_url (varchar 255)  │
│ avatar_badge (varchar 100)│         │ created_at / updated_at   │
│ created_at / updated_at   │         └─────────────┬─────────────┘
└─────────────┬─────────────┘                       │
              │ 1                                   │ 1
              │                                     │
              ├─────────────────┐                   │
              │ N               │ N                 │ N
┌─────────────▼─────────────┐   ┌───────────────────▼─────────────┐
│      trainer_catches      │   │          trainer_notes          │
├───────────────────────────┤   ├─────────────────────────────────┤
│ id (PK, unsignedBigInt)   │   │ id (PK, unsignedBigInt)         │
│ user_id (FK -> users.id)  │   │ user_id (FK -> users.id)        │
│ pokemon_id (FK -> pkm.id) │   │ pokemon_id (FK -> pokemon.id)   │
│ caught_at (datetime/date) │   │ title (varchar 255)             │
│ location (varchar 150)    │   │ content (longtext - WYSIWYG)    │
│ is_favorite (boolean)     │   │ caught_date (date, nullable)    │
│ created_at / updated_at   │   │ caught_location (varchar 150)   │
└───────────────────────────┘   │ created_at / updated_at         │
                                └─────────────────────────────────┘
```

---

## 5. Pembagian Modul & Spesifikasi Tanggung Jawab Anggota

### Modul 1: Autentikasi, Manajemen Sesi, & Hak Akses Developer (Yanuar Dwi Putra)
* **Tanggung Jawab:**
  * Menambah kolom `role`, `trainer_class`, dan `avatar_badge` pada tabel `users`.
  * Membangun `app/Http/Middleware/EnsureDeveloper.php` untuk mengunci endpoint mutasi master library.
  * Mengimplementasikan `app/Http/Controllers/AuthController.php` (login, register, switch-account cepat untuk 4 developer, logout).
  * Menyediakan tampilan UI partial `auth-modal.blade.php` dan indikator status pengguna pada `navbar.blade.php`.

### Modul 2: Master Pokemon Library, Excel Import, & Cloud DevOps (Arya Andra Diazka)
* **Tanggung Jawab:**
  * Mengelola katalog master 1.025 Pokémon pada `app/Http/Controllers/PokemonLibraryController.php`.
  * Menangani validasi berkas spreadsheet 4 kolom wajib (`nomor_index`, `nama_pokemon`, `tipe`, `generasi`) via `PhpSpreadsheet`.
  * Merancang antarmuka Bento Grid (`bento.blade.php`) dengan Dropdown Filter Generasi 1–9 (`#bentoGenFilter`) dan kartu statistik *Kelengkapan Library*.
  * Mengatur arsitektur repositori Git, branching strategy, continuous integration (CI/CD), serta deployment server produksi.

### Modul 3: Pokédex Caught Tracker, DataTables, & Ekspor PDF/Excel (Madina Dwiyana Putri)
* **Tanggung Jawab:**
  * Merancang tabel `trainer_catches` dan model Eloquent `TrainerCatch.php`.
  * Mengembangkan kontroler `app/Http/Controllers/PokedexCatchController.php`.
  * Membangun modal **"+ Tambah Koleksi"** (`caught-modal.blade.php`) lengkap dengan tombol interaktif **"Ambil PokéAPI"** yang mengisi form secara instan via asynchronous fetch.
  * Membangun tabel koleksi berbasis **DataTables** dengan tombol *Ekspor Excel* dan *Unduh Laporan PDF* via `barryvdh/laravel-dompdf`.

### Modul 4: Jurnal Taktik & Catatan Lapangan Trainer (Iasha Irdanti)
* **Tanggung Jawab:**
  * Merancang tabel `trainer_notes` dan model `TrainerNote.php`.
  * Mengembangkan kontroler `app/Http/Controllers/TrainerJournalController.php` dengan pembersih XSS / HTML sanitizer.
  * Membangun modal interaktif Jurnal Taktik (`journal-modal.blade.php`) dengan field *Tanggal Tangkap*, *Lokasi Tangkap*, serta editor teks kaya **Quill.js WYSIWYG**.
  * Menghubungkan jurnal taktis langsung dengan entri koleksi Pokémon trainer.
