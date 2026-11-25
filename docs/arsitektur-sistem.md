# Dokumen Arsitektur Sistem: Pokédex Collection Tracker & Trainer Directory

**Versi Dokumen:** 1.5.1 (Cloud Hosting Railway, PokéAPI Name Autocomplete & Proteksi Duplikat First Caught)
**Status Rilis:** Rilis Produksi v1.5.1 (Live Cloud Hosting Railway, Smart PokéAPI Combobox & Duplicate Catch Guard)
**Tanggal Rilis:** 25 November 2026
**Live URL:** `https://pokedex-k13-a2-production.up.railway.app/pokedex`
**Pengembang:** Kelompok 13 — Kelas Praktikum Pemrograman Web A / A2  
* Arya Andra Diazka (J0404251155) — *Lead Architect & DevOps*
* Yanuar Dwi Prasetya (J0404251022) — *Security & Authentication Engineer*
* Madina Dwiyana Putri (J0404251090) — *Database & Collection DataTables Engineer*
* Iasha Irdanti (J0404251115) — *UI/UX & Interactive Journal Engineer*

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

## 2. Pemisahan Konsep Inti (Core Concept Distinction v1.2)

Untuk mencegah kerancuan data dan memenuhi persyaratan proyek perkuliahan secara elegan, aplikasi memisahkan sistem menjadi dua domain utama:

### 2.1. Pokemon Library (Master Catalog 1.025 Entri)
* **Karakteristik:** Bertindak sebagai ensiklopedia referensi resmi seluruh 1.025 Pokémon (Generasi I hingga Generasi IX / Paldea).
* **Hak Akses Trainer:** *Read-Only*. Trainer umum hanya dapat mencari, menyaring tipe elemen, memilih generasi 1–9, dan melihat detail profil Pokémon.
* **Hak Akses Developer:** Akun dengan role `developer` (Yanuar, Arya, Madina, Iasha) memiliki otorisasi untuk melakukan **Import Master Dataset (.xlsx)** melalui pustaka `PhpSpreadsheet` guna memperbarui katalog master atau menambahkan entitas baru (misal Pokémon #1026+ di masa depan).
* **Kebijakan Ekspor:** Tombol ekspor pada halaman Library ditiadakan karena fitur ekspor ditujukan khusus untuk mendokumentasikan progres koleksi tangkapan pribadi pada halaman Pokédex.

### 2.2. Pokédex (Trainer Caught Tracker & Interactive Collection)
* **Karakteristik:** Direktori tangkapan aktif (*caught collection*) milik akun trainer yang sedang login.
* **Fitur Utama:**
  1. **Modal "+ Tambah Koleksi" (Integrasi PokéAPI v2):** Trainer dapat menambahkan Pokémon yang berhasil ditangkap dengan memasukkan nomor indeks, menekan tombol **"⚡ Ambil PokéAPI"** (data nama, tipe utama, tipe sekunder, generasi, dan preview sprite terisi otomatis), lalu menyimpan ke koleksi pribadi.
  2. **Tabel Interaktif DataTables:** Menampilkan daftar Pokémon yang telah dikoleksi dengan fitur pencarian kilat, pagination dinamis, multi-column sorting, dan tombol aksi cepat.
  3. **Ekspor Multi-Format:** Mendukung ekspor koleksi ke **Excel (.xlsx)** via PhpSpreadsheet dan cetak dokumen resmi **PDF berstandar A4** via Barryvdh DomPDF.
  4. **Proteksi Akses Tamu (Centered Auth Popup):** Ketika pengguna belum login mencoba menambah koleksi, sistem memunculkan popup beranimasi di tengah layar berikon gembok merah berdenyut, yang jika ditutup langsung membuka modal Login/Daftar/DevKit.
  5. **Jurnal Taktik & Catatan Lapangan (WYSIWYG):** Setiap Pokémon dalam koleksi dapat dilengkapi dengan informasi tanggal tangkap, lokasi penangkapan (misal *Route 102*, *Viridian Forest*), serta analisis strategi bertarung menggunakan teks berformat kaya (Quill.js WYSIWYG).

---

## 3. Sistem Peran Pengguna (Role-Based Access Control)

Sistem membedakan dua tingkatan hak akses:

| Properti | Role: `developer` | Role: `trainer` |
|---|---|---|
| **Daftar Akun** | Yanuar Dwi Prasetya, Arya Andra Diazka, Madina Dwiyana Putri, Iasha Irdanti | Pengguna umum yang mendaftar melalui formulir registrasi |
| **Identitas Visual** | Lencana merah menyala (*badge*) bertuliskan `DEV` pada navbar | Lencana hijau bertuliskan `TRAINER` pada navbar |
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
│ created_at / updated_at   │   │ created_at / updated_at         │
└───────────────────────────┘   └─────────────────────────────────┘
```

---

## 5. Pembagian Modul & Spesifikasi Tanggung Jawab Anggota

### Modul 1: Autentikasi, Manajemen Sesi, & Hak Akses Developer (Yanuar Dwi Prasetya)
* **Status Integrasi:** ✅ **SELESAI & TERINTEGRASI (Commit `45f9e19` / v1.1.0 & v1.1.1)**
* **Tanggung Jawab & Realisasi:**
  * Menambah kolom `role`, `trainer_class`, dan `avatar_badge` pada tabel `users` (`2026_11_22_225257_add_role_and_trainer_fields_to_users_table.php`).
  * Membangun `app/Http/Middleware/EnsureDeveloper.php` untuk mengunci endpoint mutasi master library.
  * Mengimplementasikan `app/Http/Controllers/AuthController.php` (login, register, switch-account cepat untuk 4 developer, logout).
  * Menyediakan tampilan UI partial `auth-modal.blade.php` dan indikator status pengguna pada `navbar.blade.php`.
  * Modal popup peringatan akses terkunci (`#devLockModal`) beranimasi di tengah layar.

### Modul 2: Master Pokemon Library, Excel Import, & Cloud DevOps (Arya Andra Diazka)
* **Status Integrasi:** ✅ **SELESAI & TERINTEGRASI (v1.0.1 / v1.1.1 / v1.2.1 / v1.2.2 / v1.2.3 / v1.2.4)**
* **Tanggung Jawab:**
  * Mengelola katalog master 1.025 Pokémon pada `app/Http/Controllers/PokemonLibraryController.php`.
  * Menangani validasi berkas spreadsheet 4 kolom wajib (`nomor_index`, `nama_pokemon`, `tipe`, `generasi`) via `PhpSpreadsheet`.
  * Merancang antarmuka Bento Grid (`bento.blade.php`) dengan Dropdown Filter Generasi 1–9 (`#bentoGenFilter`) dan kartu statistik *Kelengkapan Library*.
  * Mengatur arsitektur repositori Git, branching strategy, continuous integration (CI/CD), serta deployment server produksi.
  * Membantu penyelesaian bugfix dan polishing rilis `v1.2.1` bersama Madina.
  * Melakukan perombakan identitas brand visual (Official Pokéball SVG Vector) pada rilis `v1.2.2`.
  * **Penyempurnaan Rilis v1.2.3:**
    * Mengimplementasikan sistem kamus multi-bahasa sisi klien (`localStorage`) dengan tombol pengalih bilingual (`🌐 ID` / `EN`) di bilah navigasi dan menu drawer.
    * Menyelaraskan seluruh judul navigasi dan bagian ke dalam Bahasa Indonesia baku (`Beranda`, `Eksplorasi`, `Koleksi`, `Pustaka`) serta memperbaiki urutan pil navbar agar sesuai urutan tata letak komponen.
    * Mengubah banner sticky alert sesi in-page menjadi modal popup animasi di tengah layar (`#sessionNotificationModal`).
    * Merestrukturisasi menu drawer: menghilangkan fitur usang Excel/filter cepat dan menyajikan panel kontrol akun trainer serta switcher bahasa.
  * **Penyempurnaan Rilis v1.2.4:**
    * Eliminasi seluruh emoji bawaan sistem menjadi ikon vektor SVG inline murni yang tajam.
    * Penerapan bendera vektor SVG resmi (Indonesia Merah-Putih & UK Union Jack) untuk pengalih bahasa.
    * Pembuatan modal konfirmasi pergantian bahasa interaktif (`#langConfirmModal`).
    * Implementasi efek animasi transisi cyber scanline shimmer (`.lang-shimmer-active`) dan type-reveal pada pergantian bahasa.
    * Penerjemahan komprehensif ke seluruh kartu panduan, status validasi, dan kontrol data.
    * **Lokalisasi Menyeluruh (Deep Translation):**
      * Seluruh 20 Fun Facts dunia Pokémon di `config/pokedex.php` dilengkapi versi Bahasa Inggris (`title_en`, `desc_en`, `topic_en`, `category_en`, `source_en`) sehingga preview slide, kartu pop-up, tombol `(read more...)` / `Close`, dan petunjuk keyboard berganti dinamis.
      * Kolom struktur panduan Excel Bento Grid (`index_number`, `pokemon_name`, `type`, `generation`), deskripsi status koleksi trainer, dan status entri indeks terakhir (`Entry #1025 · All 1,025 Pokémon Registered!`).
      * Kolom nilai Generasi pada baris tabel Master Library & Caught Tracker (`Generation I (Kanto)` s.d. `Generation IX (Paldea)`) serta opsi dropdown filter generasi.
      * Showcase Modal: subheader generasi (`#0001 · Generation I (Kanto)`), integrasi *asynchronous English flavor text fetching* dari PokéAPI (dengan in-memory cache) + fallback deskripsi bahasa Inggris, label sprites, footer navigasi (`Use ← → to navigate · Esc to close`), dan identitas kelompok (`Pokédex - Group 13 - Class A / A2`).

### Modul 3: Pokédex Caught Tracker, DataTables, & Ekspor PDF/Excel (Madina Dwiyana Putri)
* **Status Integrasi:** ✅ **SELESAI & TERINTEGRASI (Merge Request !3 / v1.2.0, v1.2.1, v1.2.3 & v1.2.4)**
* **Tanggung Jawab & Realisasi:**
  * Merancang tabel `trainer_catches` dan model Eloquent `TrainerCatch.php`.
  * Mengembangkan kontroler `app/Http/Controllers/PokedexCatchController.php` untuk penyimpanan, penghapusan, favorit, pembaruan tanggal, dan ekspor.
  * Membangun modal **"+ Tambah Koleksi"** (`caught-modal.blade.php`) lengkap dengan tombol interaktif **"⚡ Ambil PokéAPI"** yang mengisi form secara instan via asynchronous fetch.
  * Membangun tabel koleksi berbasis **DataTables** dengan tombol *Ekspor Excel* dan *Unduh Laporan PDF* via `barryvdh/laravel-dompdf`.
  * **Penyempurnaan Bugfix v1.2.1 (Bersama Arya):**
    * Pemasangan paket `barryvdh/laravel-dompdf` (v3.1.2) di vendor.
    * Resolusi missing column `location` via migrasi `2026_11_23_000001_ensure_location_in_trainer_catches_table.php`.
    * Redesain modal Tambah Koleksi menjadi Crimson Dark Glassmorphism dengan animasi dan hologram preview.
    * Pembuatan modal popup peringatan autentikasi di tengah layar yang otomatis membuka menu akun saat ditutup.
  * **Penyempurnaan Manajemen Koleksi v1.2.3:**
    * Input tanggal penangkapan kustom (`caught_at`) dengan tanggal hari ini sebagai default, tersimpan ke basis data MySQL.
    * Penambahan aksi **✏️ Tanggal** pada tabel koleksi dengan modal edit tanggal (`#editCaughtDateModal`) dan endpoint `POST /pokedex/caught/{pokemonId}/date` (`updateDate`).
    * Penambahan aksi **🗑️ Hapus** dengan modal konfirmasi peringatan cyber merah (`#deleteCaughtModal`) dan endpoint `DELETE /pokedex/caught/{pokemonId}` (`destroy`).
    * Mengatasi bug tampilan tamu pada Kartu 1 Bento Grid: tamu melihat status "Belum Masuk Akun" dengan tautan masuk, sedangkan trainer terautentikasi melihat rasio tangkapan ("X dari 1.025"), lencana persentase emerald (`%`), dan bar kemajuan visual.
  * **Penyempurnaan Refinement v1.2.4:**
    * Perbaikan label format tanggal penangkapan menjadi format baku `Tanggal - Bulan - Tahun (DD/MM/YYYY)`.
    * Penggantian ikon emoji aksi tabel (`✏️`, `🗑️`, `📝`) dan toolbar (`📊`, `📄`) menjadi vektor SVG presisi.

### Modul 4: Jurnal Taktik & Catatan Lapangan Trainer (Iasha Irdanti)
* **Status Integrasi:** ✅ **SELESAI & TERINTEGRASI (Merge Request !4 / Commit 806a3aa, d80031c & v1.3.1)**
* **Tanggung Jawab & Realisasi:**
  * Merancang skema tabel `trainer_notes` (`2026_11_20_000003_create_trainer_notes_table.php` & `2026_11_24_000001_ensure_fields_in_trainer_notes_table.php`) dan model Eloquent `App\Models\TrainerNote.php` dengan relasi `belongsTo` ke `User` dan `Pokemon`.
  * Mengembangkan kontroler `app/Http/Controllers/TrainerJournalController.php` dengan validasi request, isolasi data catatan per akun, dan sanitasi HTML Anti-XSS (`strip_tags` whitelist).
  * Membangun modal interaktif Jurnal Taktik (`journal-modal.blade.php`) dengan field *Tanggal Tangkap*, *Lokasi Penangkapan*, *Judul Strategi*, serta editor teks kaya **Quill.js WYSIWYG**.
  * **Penyempurnaan Bugfix & Visual v1.3.1 (Bersama Arya):**
    * Resolusi fatal SQL exception `Unknown column 'caught_date'` via migrasi pelengkap skema basis data.
    * Harmonisasi visual total: eliminasi seluruh emoji bawaan sistem menjadi ikon vektor SVG inline murni, serta penyesuaian CSS tema gelap Crimson Cyber Glassmorphism.
    * Pembuatan modal popup feedback di tengah layar (`#journalFeedbackModal`) menggantikan browser alert untuk notifikasi simpan berhasil maupun peringatan belum login.
    * Menghubungkan jurnal taktis langsung dengan entri koleksi Pokémon trainer pada tombol aksi tabel DataTables serta integrasi kamus multi-bahasa (ID/EN).

---

## 6. Arsitektur Cloud Deployment (Railway Production v1.4.0)

* **Platform & Runtime:** Railway Cloud dengan kontainer Railpack (PHP 8.2+ & Node.js) serta layanan basis data **MySQL 8.0** cloud persisten.
* **Ekstensi PHP Wajib:** `ext-gd` dan `ext-zip` dideklarasikan di `composer.json` dan `composer.lock` untuk menunjang `PhpSpreadsheet` & `Barryvdh DomPDF`.
* **Terminasi SSL & Reverse Proxy:**
  * `bootstrap/app.php` mengonfigurasi `$middleware->trustProxies(at: '*')`.
  * `app/Providers/AppServiceProvider.php` memaksa skema `URL::forceScheme('https')` pada environment `production`.
  * `layouts/app.blade.php` menggunakan `secure_asset()` dan CSP `upgrade-insecure-requests`.
* **Stabilitas Build `config:cache`:** `config/app.php` dilengkapi sanitasi `app.url` untuk mencegah galat `Invalid URI` saat inisialisasi konfigurasi produksi di CLI.

---

## 7. Arsitektur UI Responsif Multi-Perangkat (v1.4.1 & v1.4.2)

Untuk menjamin kenyamanan akses di perangkat seluler (*smartphone* `320px–480px`), tablet (`768px–1199px`), maupun desktop, stylesheet `public/css/pokedex.css` dan komponen Blade menerapkan strategi responsif tanpa mengubah logika bisnis aplikasi:

1. **Adaptasi Topbar & Navigasi Mobile (`<= 767px`, `<= 479px`, `<= 439px`):**
   * Merampingkan jarak dan ukuran `.brand-logo`, tombol bahasa `.topbar-lang-btn`, serta pil akun `.topbar-auth-pill` (`.topbar-auth-name` disembunyikan di `< 480px` sambil mempertahankan badge role, tombol switch, dan logout; detail nama/email lengkap tersedia di Menu Drawer).
   * Pada lebar `< 440px`, tombol menu (`#menuBtn`) beralih ke mode ikon hamburger kompak (`38px`) dengan `aria-label="Menu"` sehingga tidak terpotong di sisi kanan layar.
2. **Hero Stack Slides Adaptif & Kontras Tinggi (`<= 899px`, `<= 479px`):**
   * Menghilangkan kunci tinggi statis `364px` menjadi `height: auto` dengan padding bawah `72px–76px` agar tombol kontrol `< >` tidak menimpa paragraf deskripsi dan kartu tidak meluber menabrak seksi Bento Grid.
   * Menetapkan `flex-wrap: wrap` pada `.hero__eyebrow`, mengisolasi slide bertumpuk non-aktif (`position: absolute; inset: 0; height: 100%;`), dan mengarahkan gradien diagonal crimson ke bagian atas belakang artwork agar seluruh teks hero tetap kontras di atas dasar gelap.
3. **Bento Filter Grid, Caught Toolbar & Pemisahan Kartu Tabel (`<= 767px`, `<= 600px`, `<= 479px`):**
   * Menata 19 tombol `.filter-pills` menjadi grid seragam 3 kolom pada `<= 479px` (2 kolom pada `< 360px`) serta menyusun `.caught-toolbar` dalam grid simetris 1+2 (`<= 540px`).
   * Tabel pustaka master menggunakan selektor khusus `.dex-table--master` untuk tata letak kartu 5-kolom, sementara `.select-field` diperluas `100%` sejak `<= 600px`.
   * Tabel koleksi trainer (`#caughtDataTable` / `.caught-table`) menggunakan grid kartu 7-kolom tersendiri (*Sprite, Name, Index, Type, Gen, Date, Actions*) lengkap dengan penataan ulang kontrol DataTables (`.dataTables_length`, `.dataTables_filter`, `.dataTables_paginate`) agar tersusun vertikal rapi tanpa tumpang tindih.
4. **Scrollable Dialogs & Modals (`100dvh`) serta Auth Tabs 1-Baris:**
   * `dialog.showcase` (dengan `.showcase__stage` terkompaksi `height: 190px` & `.gallery__grid` 2 kolom), `dialog.fact-modal`, dan seluruh `.pkm-modal__dialog` dikonfigurasi dengan batas tinggi `calc(100dvh - 24px)` dan `overflow-y: auto` (`overscroll-behavior: contain`), sedangkan `.auth-tabs` tetap muat 1 baris penuh di `<= 540px`.

---

## 8. Pencarian PokéAPI via Nama, Animated Autocomplete & Modal Scroll Safeguard (v1.5.0)

* **Animated Name Autocomplete Combobox (`#apiDexName`, `#apiDexNameList`):** Menggunakan pola aksesibel WAI-ARIA `role="combobox"` (`aria-autocomplete="list"`, `aria-expanded`, `aria-activedescendant`, `role="listbox"`) dengan animasi muncul halus (`@keyframes caughtSuggestIn`, menghormati `prefers-reduced-motion`). Saran difilter berdasarkan awalan nama (*prefix*) lalu kecocokan (*substring*) dan diurutkan menaik (*ascending*) menurut nomor index (`#0025 Pikachu` di atas `#0731 Pikipek`), dilengkapi sinkronisasi fallback katalog `https://pokeapi.co/api/v2/pokemon?limit=1025`.
* **Dual-Mode PokéAPI Lookup (Index & Name):** Tombol `#btnFetchPokeApi` ditempatkan di bawah input *Nama Pokémon* dan secara otomatis mengambil data via nomor indeks maupun slug nama (`normalizePokeApiSlug`) dari `https://pokeapi.co/api/v2/pokemon/{identifier}` untuk mengisi nomor index (`#apiDexIndex`), nama, tipe, generasi, sprite, serta hologram preview.
* **Modal Scroll & Button Alignment Fix:** Menghapus inline `overflow: hidden` pada `.pkm-modal__dialog` (`caught-modal.blade.php`, `journal-modal.blade.php`, `caught-table.blade.php`) dan menetapkan `.pkm-modal__actions .action-pill { width: auto; }` di `pokedex.css` agar seluruh modal dapat digulir vertikal penuh di zoom 100% dan layar ponsel.
* **Proteksi Duplikat Tangkapan & Info First Caught (`v1.5.1`):** `PokedexCatchController::store()` mengecek `TrainerCatch` yang sudah ada untuk `(user_id, pokemon_id)` sebelum menyimpan agar tanggal tangkapan awal tidak tertimpa, mengembalikan HTTP `409` (`already_caught: true`, `first_caught_at`), dan menampilkannya lewat varian peringatan amber `#f59e0b` pada `#caughtFeedbackModal` (`Sudah Pernah Ditangkap!`).

