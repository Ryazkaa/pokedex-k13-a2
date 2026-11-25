# BAHAN MENTAH SLIDE PRESENTASI: POKÉDEX WEB APP (KELOMPOK 13)
**Mata Kuliah:** Praktikum Pemrograman Web (Kelas A / A2) — Sekolah Vokasi IPB University  
**Target Output:** Bahan Mentah Slide Presentasi (13 Slide Inti) Siap Generate ke Gemini / Claude / PPT Generator  
**Dokumentasi Teknis & Codebase:** Laravel 11 MVC, MySQL 8.0, PhpSpreadsheet, Barryvdh DomPDF, PokéAPI v2, DataTables, Quill.js WYSIWYG, Railway Cloud  

---

## DAFTAR ISI SLIDE
- **Slide 1:** Cover & Identitas Proyek Kelompok 13
- **Slide 2:** Latar Belakang, Visi Produk, & Ruang Lingkup Sistem Pokédex
- **Slide 3:** Arsitektur Sistem & Tech Stack Terpasang (Frontend, Backend, Database, Cloud)
- **Slide 4:** Matriks Resmi Pemetaan Fitur vs Silabus Mata Kuliah Pemweb (P1 – P16)
- **Slide 5:** Bedah Fitur 1 — Praktikum P1 (HTML, CSS, dan JS) : Antarmuka Modern Bento Grid, Dark Glassmorphism, 18 Badges SVG & Interaktivitas DOM
- **Slide 6:** Bedah Fitur 2 — Praktikum P2 (PHP), P3 (Instalasi Laravel), & P4 (Basic Laravel) : Master 1.025 Pokémon, Routing Terstruktur & Blade Templating
- **Slide 7:** Bedah Fitur 3 — Praktikum P5 (Basic Laravel : Session dan Authentication) : Autentikasi Pengguna, RBAC Developer vs Trainer, & Quick Switcher
- **Slide 8:** Bedah Fitur 4 — Praktikum P6 (CRUD) & P7 (API) : Siklus Penuh CRUD Koleksi Tangkapan & Integrasi Asinkronus PokéAPI v2
- **Slide 9:** Bedah Fitur 5 — Praktikum P9 (Pengolahan Grafik) & P12 (DataTables dan WYSIWYG) : Visualisasi Statistik, Tabel Interaktif & Jurnal Taktis
- **Slide 10:** Bedah Fitur 6 — Praktikum P10 (Pengolahan File PDF) : Dokumen Laporan Rekap Koleksi Berstandar Cetak A4 via Barryvdh DomPDF
- **Slide 11:** Bedah Fitur 7 — Praktikum P11 (Pengolahan File Excel) : Ekspor Koleksi (.xlsx) & Impor Master Dataset Validasi 3 Status via PhpSpreadsheet
- **Slide 12:** Bedah Fitur 8 — Praktikum P13 (Repo Git dan Hosting) : Multi-Remote Git, Cloud Hosting Railway, SSL Reverse Proxy HTTPS & Container
- **Slide 13:** Kesimpulan, Evaluasi Capaian 100% Silabus, & Sesi Diskusi (Q&A / Demo Live) — Praktikum P14 & P15 (Presentasi)

---

### SLIDE 1: COVER & IDENTITAS PROYEK
* **Judul Slide:** Pokédex Collection Tracker & Trainer Directory
* **Subjudul:** Aplikasi Ensiklopedia Master 1.025 Pokémon, Pelacak Koleksi Tangkapan Personal, & Jurnal Taktis Berbasis Laravel 11 MVC

#### Konten Slide (Bullet Points):
* **Proyek Akhir Praktikum Pemrograman Web:** Kelompok 13 — Kelas A / A2 (Sekolah Vokasi IPB University).
* **Tim Pengembang (4 Developer):**
  - **Arya Andra Diazka (J0404251155)** — *Lead Architect & Cloud DevOps*
  - **Yanuar Dwi Prasetya (J0404251022)** — *Security & Authentication Engineer*
  - **Madina Dwiyana Putri (J0404251090)** — *Database & DataTables Engineer*
  - **Iasha Irdanti (J0404251115)** — *UI/UX & Interactive Journal Engineer*
* **Akses Live Production:** `https://pokedex-k13-a2-production.up.railway.app/pokedex`
* **Arsitektur Inti:** Monolitik Modern Laravel 11 (PHP 8.2+), MySQL 8.0, Bento Glassmorphism UI.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Kuliah P1 : Kontrak Perkuliahan dan Pendahuluan]` & `[Praktikum P14 & P15 : Presentasi Proyek Akhir]`
* **File / Kode Acuan:** `src/composer.json`, `src/routes/web.php`, `docs/arsitektur-sistem.md`.
* **Catatan Presenter:** Sampaikan salam pembuka dengan percaya diri. Perkenalkan keempat anggota kelompok beserta spesialisasi teknis masing-masing. Tunjukkan bahwa aplikasi ini tidak hanya diuji di localhost, melainkan sudah berjalan *live* di cloud server publik yang dapat diuji langsung oleh tim dosen.

#### Rekomendasi Visual / Screenshot:
* Logo resmi vektor Pokéball (`src/public/images/pokeball.png`) berdampingan dengan logo Sekolah Vokasi IPB University dan Hero Banner tangkapan layar website bertema *Dark Cyber Crimson*.

---

### SLIDE 2: LATAR BELAKANG & GAMBARAN UMUM APLIKASI
* **Judul Slide:** Latar Belakang & Visi Produk
* **Subjudul:** Menjembatani Kompleksitas Data 1.025 Pokémon ke dalam Aplikasi Web Interaktif, Edukatif, & Siap Pakai

#### Konten Slide (Bullet Points):
* **Fragmentasi Data Master:** Informasi Pokémon lintas Generasi I s.d. IX (Kanto hingga Paldea) seringkali terpisah antara data ensiklopedia resmi dan catatan tangkapan pribadi pengguna.
* **Ketiadaan Jurnal Taktis:** Trainer membutuhkan media pencatatan strategi bertarung, tanggal tangkap, dan lokasi spesifik yang fleksibel menggunakan format teks kaya (*rich text*).
* **Kebutuhan Pelaporan Resmi:** Kurangnya platform yang menyediakan dokumentasi fisik siap cetak berstandar dokumen resmi (PDF A4) dan rekap data tabular (Excel `.xlsx`).
* **Laboratorium Implementasi Pemweb:** Membangun studi kasus komprehensif yang mengimplementasikan 100% materi silabus kuliah Praktikum Pemrograman Web dari pekan pertama hingga akhir.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Kuliah P1 : Kontrak Perkuliahan dan Pendahuluan — Identifikasi Kebutuhan Sistem & Solusi Digital]`
* **File / Kode Acuan:** `src/config/pokedex.php` (katalog referensi tipe & fun facts), `docs/arsitektur-sistem.md`.
* **Catatan Presenter:** Jelaskan bahwa aplikasi ini membagi sistem menjadi dua domain besar: *Pokemon Library* (data ensiklopedia statis 1.025 entri yang bersifat referensi read-only) dan *Pokédex Caught Tracker* (area dinamis tempat user mencatat tangkapan, menyusun strategi, dan mengekspor dokumen).

#### Rekomendasi Visual / Screenshot:
* Tampilan kartu Bento Grid dashboard (`Preview/#1 Home - Funfact.png`) yang menampilkan kartu statistik persentase koleksi, tombol unduh, dan funnel generasi 1–9.

---

### SLIDE 3: ARSITEKTUR SISTEM & TECH STACK TERPASANG
* **Judul Slide:** Arsitektur Sistem & Tech Stack Aktual
* **Subjudul:** Struktur Monolitik Laravel 11 MVC dengan Ekosistem Pustaka Pihak Ketiga Berstandar Industri

#### Konten Slide (Bullet Points):
* **Frontend Layer:** Blade Templating Engine, Vanilla JavaScript ES6+ murni (tanpa runtime overhead), CSS3 Modern (Dark Glassmorphism Bento Grid), DataTables 2.x, dan Quill.js WYSIWYG.
* **Backend Layer:** Laravel Framework v11.x (PHP 8.2+ / 8.3), Router Terstruktur, Eloquent ORM, serta Middleware Kustom (`EnsureDeveloper`).
* **Database Layer:** RDBMS MySQL 8.0 dengan 4 tabel relasional berintegritas *cascading foreign keys*.
* **Ekosistem Pustaka Pihak Ketiga:**
  - `phpoffice/phpspreadsheet` (^3.9) untuk parsing & manipulasi file `.xlsx`.
  - `barryvdh/laravel-dompdf` (^3.1) untuk rendering dokumen PDF A4 resmi.
  - REST Client PokéAPI v2 untuk konsumsi data asinkronus (`fetch`).
* **Cloud Infrastructure:** Railway Cloud Platform, Nixpacks/Railpack Container, SSL Termination Reverse Proxy.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P3 : Instalasi Laravel]` & `[Praktikum P4 : Basic Laravel : Routing, Controllers, Requests, Responses, Views]`
* **File / Kode Acuan:** `src/composer.json`, `src/package.json`, `src/bootstrap/app.php`, `src/config/app.php`.
* **Catatan Presenter:** Tekankan bahwa arsitektur backend memisahkan tanggung jawab secara tegas (*Separation of Concerns*). Tidak ada logika SQL mentah yang tercecer di View, dan seluruh proses manipulasi berkas berat (Excel/PDF) diisolasi di Controller masing-masing.

#### Rekomendasi Visual / Screenshot:
* Diagram blok arsitektur sistem (Client Layer Browser → Laravel 11 Backend & Services → MySQL 8.0 Database) seperti yang tertera pada dokumen arsitektur v1.5.4.

---

### SLIDE 4: MATRIKS RESMI PEMETAAN FITUR VS SILABUS PEMWEB
* **Judul Slide:** Matriks Resmi Pemetaan Fitur vs Silabus Mata Kuliah Pemweb
* **Subjudul:** Rekapitulasi Menyeluruh Implementasi Kode Program Berdasarkan Rencana Perkuliahan Sekolah Vokasi IPB

#### Konten Slide (Tabel Silabus Resmi):
| Pertemuan | Kuliah (Teori) | Praktikum (Lab) | Fitur Terimplementasi di Pokédex K13 | File Kode Terkait |
| :---: | :--- | :--- | :--- | :--- |
| **1** | Kontrak Perkuliahan dan Pendahuluan | **HTML, CSS, dan JS** | Layout Bento Grid, Dark Glassmorphism, 18 Badges SVG, DOM Modal, Switcher i18n | `layouts/app.blade.php`, `pokedex.css`, `pokedex.js` |
| **2** | HTML | **PHP** | Logika pemrosesan PHP, array konfigurasi tipe, generasi, & 20 Fun Facts dwibahasa | `config/pokedex.php` |
| **3** | CSS | **Instalasi Laravel** | Setup Laravel 11, struktur folder MVC, dependensi Composer (PhpSpreadsheet, DomPDF) | `composer.json`, `.env.example` |
| **4** | Javascript | **Basic Laravel : Routing, Controllers, Requests, Responses, Views** | Routing `web.php`, Blade template modular (`@include`), Controller terisolasi, Request/Response | `routes/web.php`, `app/Http/Controllers/`, `resources/views/` |
| **5** | PHP | **Basic Laravel : Session dan Authentication** | Login/Register (Bcrypt), Session state, RBAC Dev vs Trainer, Quick Switcher 4 dev | `AuthController.php`, `EnsureDeveloper.php`, `auth-modal.blade.php` |
| **6** | Konsep MVC dan Framework | **CRUD** | Full CRUD Tangkapan (`store`, `index`, `updateDate`, `destroy`) & Jurnal Lapangan | `PokedexCatchController.php`, `TrainerJournalController.php` |
| **7** | Kuis / Review | **API** | Konsumsi Asinkronus PokéAPI v2 via JavaScript `fetch()` (Auto-fill form tangkapan) | `caught-modal.blade.php`, `pokedex.js` |
| **8** | **UTS** | **UTS** | Evaluasi Komprehensif: Fondasi Web, MVC Laravel, CRUD, & Integrasi API | *Seluruh Modul 1 s.d. 4* |
| **9** | API | **Pengolahan Grafik** | Visual progress bar rasio tangkapan, funnel persentase generasi 1–9, grafik statistik | `bento.blade.php`, `pokedex.js` |
| **10** | Pengolahan Grafik | **Pengolahan File PDF** | Cetak Dokumen Rekapitulasi Koleksi Resmi Format A4 Portrait via Barryvdh DomPDF | `PokedexCatchController::exportPdf()`, `pokedex-pdf.blade.php` |
| **11** | Pengolahan File PDF | **Pengolahan File Excel** | Ekspor koleksi (.xlsx) & Impor master dataset 4 kolom (Validasi 3 Status) via PhpSpreadsheet | `PokedexCatchController::exportExcel()`, `PokemonLibraryController::importExcel()` |
| **12** | Pengolahan File Excel | **DataTables dan WYSIWYG** | Tabel interaktif DataTables (Live search, sort, paging) & Editor teks kaya Quill.js (Anti-XSS) | `index.blade.php`, `journal-modal.blade.php`, `pokedex.js` |
| **13** | DataTables dan WYSIWYG | **Repo Git dan Hosting** | Multi-remote Git (GitLab/GitHub), Live Cloud Railway, Container Railpack, SSL Reverse Proxy | `bootstrap/app.php`, `AppServiceProvider.php`, Docker Railpack |
| **14 & 15**| Repo Git dan Hosting / Review | **Presentasi** | Presentasi Proyek Akhir Kelompok 13, Demo Aplikasi Live & Pengujian Fungsional Sistem | `docs/Presentasi_Fitur_Pokedex_Pemweb_K13.pptx` |
| **16** | **UAS** | **UAS** | Ujian Akhir Semester & Penilaian Akhir Portofolio Proyek | *Live Application Production* |

#### Catatan Presenter:
Jelaskan kepada dosen bahwa proyek Pokédex Kelompok 13 dibangun dengan disiplin tinggi mengikuti silabus resmi dari pekan ke-1 hingga pekan ke-15 tanpa ada satu modul praktikum pun yang dilewati.

---

### SLIDE 5: BEDAH FITUR 1 — PRAKTIKUM P1 (HTML, CSS, DAN JS)
* **Judul Slide:** Bedah Fitur 1: Antarmuka Modern Bento Grid & Interaktivitas DOM
* **Subjudul:** Implementasi Silabus Praktikum P1 (HTML, CSS, dan JS) — Dark Glassmorphism, 18 Badges SVG & Interaktivitas Klien Murni

#### Konten Slide (Bullet Points):
* **Struktur HTML5 Semantik:** Menggunakan elemen standar `<header>`, `<nav>`, `<main>`, `<section>`, dan `<dialog>` untuk aksesibilitas modal murni.
* **Bento Grid Dashboard (4 Kartu Inti):**
  1. *Kartu Progres Trainer:* Menampilkan rasio tangkapan terhadap 1.025 entitas master dan progress bar dinamis.
  2. *Kartu Filter Generasi:* Dropdown instan Generasi I (Kanto) hingga Generasi IX (Paldea).
  3. *Kartu Ensiklopedia & Fun Facts:* Carousel 20 fakta menarik dunia Pokémon dwibahasa.
  4. *Kartu Catatan Taktis:* Pintasan cepat membuka modal jurnal strategi.
* **18 Elemental Type Badges:** Menggunakan ikon vektor SVG murni (tanpa emoji pihak ketiga) dengan palet warna khusus sesuai tipe resmi Pokémon (Fire, Water, Grass, dll).
* **Desain Glassmorphism Translusen:** Menggunakan teknik CSS `backdrop-filter: blur(16px)` dengan aksen garis tepi *Crimson Glow* (`#E11D48`).
* **Interaktivitas JavaScript DOM:**
  - Modal Showcase dialog native dengan navigasi keyboard (`←`, `→`, `Esc`).
  - Pemutar audio cry Pokémon native menggunakan Web Audio API.
  - Kamus bahasa instan (ID ⇄ EN) tersimpan di `localStorage` dengan transisi efek *cyber scanline shimmer*.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P1 : HTML, CSS, dan JS]`
* **File / Kode Acuan:**
  - `src/resources/views/layouts/app.blade.php` (Master layout, viewport responsive, theme color).
  - `src/public/css/pokedex.css` (~78 KB stylesheet modular).
  - `src/resources/views/pokedex/partials/bento.blade.php` (Struktur 4 grid bento).
  - `src/public/js/pokedex.js` (Logika DOM, audio cry, keyboard navigation, i18n switcher).
* **Catatan Presenter:** Tunjukkan bahwa sisi frontend dibangun secara efisien menggunakan Vanilla JavaScript tanpa dependency framework berat, sehingga waktu muat halaman sangat instan dan ringan.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar Hero Banner (#0006 Charizard), Bento Grid Card Dashboard (`Preview/#1 Home - Funfact.png`), dan deretan 18 tombol badge tipe elemen.

---

### SLIDE 6: BEDAH FITUR 2 — PRAKTIKUM P2, P3, & P4 (PHP & BASIC LARAVEL)
* **Judul Slide:** Bedah Fitur 2: Katalog Master 1.025 Pokémon & Routing MVC Terstruktur
* **Subjudul:** Implementasi Silabus Praktikum P2 (PHP), P3 (Instalasi Laravel), & P4 (Basic Laravel : Routing, Controllers, Requests, Responses, Views)

#### Konten Slide (Bullet Points):
* **P2 (Pemrosesan PHP):**
  - Mengelola array multidimensi konfigurasi statis pada `config/pokedex.php` (katalog 18 tipe elemen, generasi 1–9, dan 20 fun facts bilingual).
  - Fungsi sanitasi string dan normalisasi format nomor index (`#0001+`).
* **P3 (Instalasi Laravel):**
  - Setup Laravel 11 monolitik, arsitektur folder terstruktur, konfigurasi `.env`, dan integrasi paket via Composer (`phpoffice/phpspreadsheet`, `barryvdh/laravel-dompdf`).
* **P4 (Basic Laravel : Routing, Controllers, Requests, Responses, Views):**
  - *Routing Terpusat:* Seluruh endpoint didefinisikan secara rapi di `routes/web.php` dengan pembagian grup middleware publik, authenticated, dan developer.
  - *Controller Terisolasi:* Pemisahan tanggung jawab Controller (`PokemonLibraryController`, `PokedexCatchController`, `TrainerJournalController`, `AuthController`).
  - *Blade Templating Views:* Mengadopsi inheritance layout `@extends('layouts.app')`, komponen modular `@include('pokedex.partials.*')`, dan dynamic `@push('scripts')`.
  - *Request & Response Handling:* Validasi form request server-side dan handling response ganda (Blade View HTML untuk web biasa & JSON untuk fetch AJAX).

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P2 : PHP]`, `[Praktikum P3 : Instalasi Laravel]`, & `[Praktikum P4 : Basic Laravel : Routing, Controllers, Requests, Responses, Views]`
* **File / Kode Acuan:**
  - `src/config/pokedex.php`
  - `src/routes/web.php`
  - `src/app/Http/Controllers/PokemonLibraryController.php`
  - `src/resources/views/pokedex/index.blade.php` & `src/resources/views/pokedex/partials/table.blade.php`
* **Catatan Presenter:** Jelaskan alur kerja dari URL browser yang ditangkap router `web.php`, diteruskan ke controller terkait, memvalidasi request, mengambil data model/config, lalu dirender ke view Blade secara mulus.

#### Rekomendasi Visual / Screenshot:
* Cuplikan diagram rute `web.php` dan tampilan Grid Katalog Master 1.025 Pokémon di halaman web.

---

### SLIDE 7: BEDAH FITUR 3 — PRAKTIKUM P5 (BASIC LARAVEL : SESSION & AUTH)
* **Judul Slide:** Bedah Fitur 3: Autentikasi Pengguna, Session State, & RBAC Developer
* **Subjudul:** Implementasi Silabus Praktikum P5 (Basic Laravel : Session dan Authentication) — Proteksi Akses Berlapis & Quick Switcher 4 Akun Dev

#### Konten Slide (Bullet Points):
* **Mode Tamu (Guest / Read-Only):**
  - Pengunjung tanpa login tetap dapat menikmati ensiklopedia master 1.025 Pokémon dan melihat statistik.
  - Jika tamu mencoba menambah tangkapan atau mencatat jurnal, sistem menampilkan modal popup gembok merah beranimasi di tengah layar (*Dev Lock Modal / `#devLockModal`*) yang mengarahkan untuk login.
* **Role: `trainer` (Pengguna Umum):**
  - Mendaftar mandiri via form registrasi (Password di-hash aman dengan algoritma Bcrypt).
  - Diberikan lencana navbar hijau bertuliskan `TRAINER`.
  - Berhak penuh mengelola koleksi tangkapan pribadi, jurnal taktis, dan ekspor dokumen personal.
* **Role: `developer` (Khusus 4 Akun Tim Kelompok 13):**
  - Memiliki badge navbar merah menyala bertuliskan `DEV`.
  - Memiliki wewenang mutasi master: hak istimewa melakukan **Import Dataset Master Excel**.
  - Dilindungi di tingkat kernel oleh middleware kustom `EnsureDeveloper.php`.
* **Fitur Quick Developer Switcher:** Dropdown instan di navbar untuk berpindah peran antara 4 akun developer (Yanuar, Arya, Madina, Iasha) guna mempermudah simulasi evaluasi saat presentasi.
* **Session Security:** Menerapkan regenerasi Session ID saat login untuk mencegah serangan *Session Fixation* dan validasi token CSRF pada setiap form.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P5 : Basic Laravel : Session dan Authentication]`
* **File / Kode Acuan:**
  - Controller: `src/app/Http/Controllers/AuthController.php` (`login()`, `register()`, `switchTrainer()`).
  - Middleware: `src/app/Http/Middleware/EnsureDeveloper.php`.
  - Model User: `src/app/Models/User.php` (Method `isDeveloper()`).
  - View Modal: `src/resources/views/pokedex/partials/auth-modal.blade.php`.
* **Catatan Presenter:** Praktikkan fitur *Quick Switcher* saat demo langsung di depan dosen untuk membuktikan bahwa peralihan hak akses dari Guest → Trainer → Developer bekerja seketika melalui sesi Laravel.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar Modal Login/Register dan menu dropdown DevKit Quick-Switch yang menampilkan profil 4 developer Kelompok 13.

---

### SLIDE 8: BEDAH FITUR 4 — PRAKTIKUM P6 (CRUD) & P7 (API)
* **Judul Slide:** Bedah Fitur 4: Siklus Penuh CRUD Koleksi & Konsumsi PokéAPI v2
* **Subjudul:** Implementasi Silabus Praktikum P6 (CRUD) & Praktikum P7 (API) — Caught Tracker Personal & Fetch REST API Asinkronus

#### Konten Slide (Bullet Points):
* **P6 (Implementasi Penuh Siklus CRUD):**
  - **Create:** Menambah Pokémon tangkapan baru via modal `caught-modal.blade.php` dan endpoint POST AJAX (dilengkapi deteksi duplikat HTTP `409` pada `v1.5.1` yang memberi tahu trainer bahwa Pokémon sudah pernah ditangkap beserta tanggal **First Caught**-nya).
  - **Read:** Menampilkan daftar koleksi tangkapan personal pada tabel Caught Tracker secara terisolasi per `user_id`.
  - **Update:** Fitur edit tanggal tangkap cepat (`updateDate`) dengan pemilih kalender modal terintegrasi.
  - **Delete:** Penghapusan Pokémon tangkapan (`destroy`) dengan modal konfirmasi peringatan cyber merah demi keamanan data.
* **P7 (Konsumsi REST API Eksternal - PokéAPI v2):**
  - **Tombol Cerdas '⚡ Ambil PokéAPI' (Index & Nama) + Animated Autocomplete (`v1.5.0`):** Cukup ketik nomor ID (misal `25`) atau sebagian nama Pokémon (misal `pik` akan memunculkan dropdown rekomendasi beranimasi `#0025 Pikachu` di atas `#0731 Pikipek` terurut berdasarkan index), lalu pilih saran atau klik **⚡ Ambil PokéAPI** di bawah kolom nama untuk mengeksekusi `fetch()` asinkronus ke endpoint publik:  
    `https://pokeapi.co/api/v2/pokemon/{id_or_name}`
  - **Auto-Fill Otomatis:** Data JSON yang diterima langsung di-parse untuk mengisi otomatis nomor index, nama Pokémon, tipe primer, tipe sekunder, nomor generasi, serta URL sprite resmi resolusi tinggi.
  - Mengurangi beban ketik pengguna dan menjamin akurasi data koleksi tangkapan 100% valid.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P6 : CRUD]` & `[Praktikum P7 : API]`
* **File / Kode Acuan:**
  - `src/resources/views/pokedex/partials/caught-modal.blade.php` (Logika async fetch PokéAPI).
  - `src/app/Http/Controllers/PokedexCatchController.php` (`store()`, `updateDate()`, `destroy()`).
  - Endpoint PokéAPI: `https://pokeapi.co/api/v2/pokemon/{id}` & `pokemon-species/{id}`.
* **Catatan Presenter:** Tunjukkan saat demo live: ketik angka ID di formulir, klik tombol '⚡ Ambil PokéAPI', dan perlihatkan bagaimana form terisi otomatis dalam sekejap tanpa reload halaman browser.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar formulir Tambah Koleksi dengan tombol `⚡ Ambil PokéAPI` dan preview sprite hologram (`Preview/#2 Core Feature.png`).

---

### SLIDE 9: BEDAH FITUR 5 — PRAKTIKUM P9 (GRAFIK) & P12 (DATATABLES & WYSIWYG)
* **Judul Slide:** Bedah Fitur 5: Visualisasi Grafik, DataTables Interaktif, & WYSIWYG
* **Subjudul:** Implementasi Silabus Praktikum P9 (Pengolahan Grafik) & Praktikum P12 (DataTables dan WYSIWYG)

#### Konten Slide (Bullet Points):
* **P9 (Pengolahan Grafik, Distribusi Wilayah & Radar Efektivitas Tipe):**
  - *Distribusi Wilayah I–IX (`v1.5.2`):* Grafik batang interaktif populasi Kanto s.d. Paldea yang dapat diklik untuk langsung menyaring tabel Pustaka Pokémon.
  - *Radar Efektivitas Tipe (`v1.5.4`):* Panel analisis matchup **2× Efektif Serang**, **2× Kelemahan**, dan **½× / 0× Resistensi** di tengah Bento yang berdiri independen dengan dropdown pemilih 19 elemen berikon SVG.
  - *Progress Bar Dinamis:* Menampilkan rasio persentase tangkapan terhadap total 1.025 entitas Pokémon secara real-time.
  - *Funnel Kelengkapan Generasi:* Visual bar statistik koleksi per wilayah (Gen I Kanto hingga Gen IX Paldea).
  - *Visual Artwork & Sprites:* Rendering grafik visual resolusi tinggi dari GitHub raw data PokéAPI untuk setiap kartu koleksi.
* **P12 (Integrasi Plugin DataTables):**
  - Mengubah tabel HTML biasa menjadi tabel interaktif modern pada tabel Caught Tracker.
  - *Instant Live Search:* Pencarian data kilat lintas kolom (ID, Nama, Tipe, Lokasi) tanpa reload.
  - *Multi-Column Sorting:* Pengurutan data ascending/descending pada seluruh kolom.
  - *Dynamic Pagination:* Paginasi fleksibel (10, 25, 50, 100 baris) dengan kustomisasi CSS tema dark glassmorphism.
* **P12 (Rich Text Editor - Quill.js WYSIWYG):**
  - Modal Jurnal Taktis (`journal-modal.blade.php`) terintegrasi dengan editor Quill.js.
  - Memfasilitasi trainer menyusun strategi tempur dengan formatting teks kaya (Bold, Italic, Bullet Lists, Quotes).
  - Dilengkapi filter sanitasi server-side Anti-XSS (`strip_tags` whitelist) sebelum disimpan ke tabel `trainer_notes`.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P9 : Pengolahan Grafik]` & `[Praktikum P12 : DataTables dan WYSIWYG]`
* **File / Kode Acuan:**
  - DataTables: `src/public/js/pokedex.js` (`$('#caughtTable').DataTable({...})`).
  - WYSIWYG Editor: `src/resources/views/pokedex/partials/journal-modal.blade.php` & `TrainerJournalController.php`.
  - Visual Grafik: `src/resources/views/pokedex/partials/bento.blade.php`.
* **Catatan Presenter:** Soroti bagaimana DataTables membuat pencarian data tangkapan ratusan entri terasa instan, dan bagaimana Quill.js memberikan pengalaman pengguna layaknya aplikasi catatan modern.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar tabel DataTables dengan kontrol pencarian aktif dan tampilan editor teks kaya Quill.js di modal jurnal taktis (`Preview/#2 Core Feature.png`).

---

### SLIDE 10: BEDAH FITUR 6 — PRAKTIKUM P10 (PENGOLAHAN FILE PDF)
* **Judul Slide:** Bedah Fitur 6: Dokumen Laporan Koleksi Resmi Cetak A4 (DomPDF)
* **Subjudul:** Implementasi Silabus Praktikum P10 (Pengolahan File PDF) — Otomasi Generasi Berkas Rekapitulasi Koleksi via Barryvdh DomPDF

#### Konten Slide (Bullet Points):
* **Pustaka Pemroses:** Mengintegrasikan library terpercaya `barryvdh/laravel-dompdf` (v3.1) berbasis library rendering C-engine DomPDF.
* **Standar Dokumen Cetak A4 Portrait:**
  - Diformat presisi untuk kebutuhan cetak dokumen fisik berstandar A4 Portrait (210 x 297 mm).
  - Menggunakan CSS Print Media Stylesheet khusus untuk memastikan tata letak tidak berantakan saat dicetak.
* **Struktur Dokumen Laporan Komprehensif:**
  - *Kop Surat Resmi:* Memuat logo Pokédex, identitas nama trainer, ID trainer, dan metadata tanggal generasi dokumen (WIB).
  - *Ringkasan Statistik:* Menampilkan total Pokémon yang berhasil dikoleksi oleh trainer tersebut.
  - *Tabel Rekapitulasi Data:* Memuat Nomor Indeks (#), Nama Pokémon, Tipe Elemen Primer/Sekunder, Lokasi Penangkapan, dan Tanggal Tangkap.
  - *Kolom Pengesahan:* Ruang tanda tangan digital resmi trainer di bagian kaki dokumen sebagai bukti kepemilikan koleksi yang sah.
* **Pemicu Terpadu `Ekspor Data` + Hold-to-Confirm (`v1.5.2`):** Tombol tunggal **Ekspor Data** di atas tabel koleksi membuka modal pilihan format `.XLSX` vs `.PDF` dengan tombol *Hold to Confirm* serta animasi burung kertas origami yang terbang menuju sudut unduhan peramban sebelum mengunduh berkas (`GET /pokedex/export-pdf` / `GET /pokedex/export-excel`).

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P10 : Pengolahan File PDF]`
* **File / Kode Acuan:**
  - Controller: `src/app/Http/Controllers/PokedexCatchController.php` (Method `exportPdf()`).
  - Template PDF: `src/resources/views/pokedex/reports/pokedex-pdf.blade.php`.
  - Dependensi: `composer.json` (`barryvdh/laravel-dompdf: ^3.1`).
* **Catatan Presenter:** Tunjukkan bahwa fitur ini menjawab kebutuhan pelaporan administratif resmi bagi trainer yang ingin mengarsipkan bukti fisik koleksinya kepada pihak penguji atau asosiasi.

#### Rekomendasi Visual / Screenshot:
* Pratinjau visual berkas PDF A4 hasil ekspor yang rapi, lengkap dengan kop surat dan kolom tanda tangan.

---

### SLIDE 11: BEDAH FITUR 7 — PRAKTIKUM P11 (PENGOLAHAN FILE EXCEL)
* **Judul Slide:** Bedah Fitur 7: Otomasi Spreadsheet Excel (Ekspor & Impor Validasi 3 Status)
* **Subjudul:** Implementasi Silabus Praktikum P11 (Pengolahan File Excel) — Manipulasi Berkas .xlsx Menggunakan Library PhpSpreadsheet

#### Konten Slide (Bullet Points):
* **Pustaka Pemroses:** Didukung oleh pustaka berstandar industri `phpoffice/phpspreadsheet` (v3.9).
* **1. Ekspor Rekapitulasi Koleksi (`exportExcel`):**
  - Mengonversi data koleksi trainer yang sedang login menjadi lembar kerja `.xlsx` terstruktur.
  - *Styling Cell Otomatis:* Header sel bertema Dark Slate (`#75020F`), teks putih tebal, garis border tipis di seluruh sel, *auto-size* lebar kolom A s.d. G, dan *freeze-pane* baris pertama.
  - Penamaan file otomatis: `Pokedex_Koleksi_[Trainer]_[Timestamp].xlsx`.
* **2. Impor Master Dataset 1.025 Pokémon (`importExcel`):**
  - Menerima unggahan berkas spreadsheet dengan aturan **4 Kolom Wajib**:  
    `nomor_index` | `nama_pokemon` | `tipe` | `generasi`
  - **Sistem Validasi Ketat 3 Status:**
    1. *Data Berhasil Ditambahkan:* Seluruh 4 kolom valid, format nomor index baku, dan belum terdaftar di database.
    2. *Data Ditolak / Duplikat:* Nomor index Pokémon sudah ada di dalam katalog master (mencegah redundansi).
    3. *Data Tidak Valid:* Terdapat kolom kosong, format nomor index tidak sesuai (`#0001+`), atau tipe di luar 18 elemen resmi.
* **Otorisasi Khusus:** Menu impor master dilindungi middleware `EnsureDeveloper` (hanya dapat dieksekusi oleh 4 akun developer).

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P11 : Pengolahan File Excel]`
* **File / Kode Acuan:**
  - Ekspor: `src/app/Http/Controllers/PokedexCatchController.php` (Method `exportExcel()`).
  - Impor: `src/app/Http/Controllers/PokemonLibraryController.php` (Method `importExcel()`).
  - Feedback Alert: `src/resources/views/pokedex/partials/import-alert.blade.php`.
  - Berkas Uji: `src/public/sample_import_pokemon.xlsx`.
* **Catatan Presenter:** Paparkan bagaimana sistem memproses file baris demi baris, memisahkan header, melakukan normalisasi data, dan menampilkan banner feedback berisi rekap status baris yang berhasil, duplikat, dan tidak valid.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar formulir upload Excel drag-and-drop dan lembar kerja spreadsheet hasil ekspor (`Preview/#4 Exprot - Import.png` & `Preview/#5 Export ke xlsx.png`).

---

### SLIDE 12: BEDAH FITUR 8 — PRAKTIKUM P13 (REPO GIT DAN HOSTING)
* **Judul Slide:** Bedah Fitur 8: Multi-Remote Git & Deployment Cloud Live di Railway
* **Subjudul:** Implementasi Silabus Praktikum P13 (Repo Git dan Hosting) — Penerapan Praktik DevOps Modern, Container, & SSL Security

#### Konten Slide (Bullet Points):
* **P13 (Manajemen Repositori Git):**
  - *Multi-Remote Architecture:* Repositori lokal tersinkronisasi ganda ke GitLab SV IPB (`origin`) dan GitHub (`github: Ryazkaa/pokedex-k13-a2`).
  - *Branching Strategy Modular:* Pembagian branch fitur mandiri (`feat/modul-1-auth`, `feat/modul-3-caught`, `feat/modul-4-journal`) yang digabungkan ke `main` secara bersih melalui Merge Request.
  - *Commit History Semantik:* Menggunakan konvensi penamaan commit (`feat:`, `fix:`, `docs:`, `refactor:`) untuk riwayat audit yang transparan.
* **P13 (Cloud Hosting & Live Deployment):**
  - **Live URL:** `https://pokedex-k13-a2-production.up.railway.app/pokedex`
  - **Platform Hosting:** Railway Cloud Platform dengan container Railpack (PHP 8.2 & Node.js 20).
  - **Database Cloud:** Dedicated MySQL 8.0 Cloud Instance dengan persistensi data storage volume.
* **Resolusi Kendala Teknis di Server Cloud:**
  - *Ekstensi PHP Server:* Menambahkan variabel `RAILPACK_PHP_EXTENSIONS="gd,zip"` untuk mendukung pemrosesan PhpSpreadsheet dan DomPDF.
  - *Reverse Proxy HTTPS:* Menambahkan `$middleware->trustProxies(at: '*')` di `bootstrap/app.php` dan `URL::forceScheme('https')` di `AppServiceProvider.php` guna mengeliminasi insiden Mixed Content pada aset CSS/JS.
  - *Build Auto-Sanitizer:* Mencegah crash build 'Invalid URI' pada `config/app.php` saat eksekusi `php artisan config:cache`.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P13 : Repo Git dan Hosting]`
* **File / Kode Acuan:**
  - `src/bootstrap/app.php` (`trustProxies`).
  - `src/app/Providers/AppServiceProvider.php` (`forceScheme('https')`).
  - `src/config/app.php` (`sanitizeAppUrl`).
  - GitHub Repo: `https://github.com/Ryazkaa/pokedex-k13-a2`
* **Catatan Presenter:** Tunjukkan bahwa keunggulan utama kelompok ini adalah kemampuan memecahkan masalah nyata pada server produksi cloud—bukan sekadar menjalankan aplikasi di laptop lokal.

#### Rekomendasi Visual / Screenshot:
* Tangkapan layar status deployment aktif berwarna hijau di dashboard Railway bersanding dengan terminal Git multi-remote.

---

### SLIDE 13: KESIMPULAN & SESI DISKUSI (Q&A) — PRAKTIKUM P14 & P15
* **Judul Slide:** Kesimpulan Capaian Proyek & Sesi Diskusi (Q&A)
* **Subjudul:** Implementasi Silabus Praktikum P14 & P15 (Presentasi) — Evaluasi Keberhasilan & Sesi Demonstrasi Live

#### Konten Slide (Bullet Points):
* **Pencapaian Kompetensi 100%:** Seluruh materi silabus Praktikum Pemrograman Web (Pertemuan 1 hingga 13) terbukti terimplementasi secara lengkap, harmonis, dan fungsional.
* **Keunggulan Produk Pokédex K13:**
  - *Skalabilitas Tinggi:* Siap menampung 1.025 entitas master Pokémon lintas 9 generasi.
  - *UI/UX Modern Berstandar Industri:* Desain Dark Cyber Glassmorphism Bento Grid yang responsif dan memanjakan mata.
  - *Fitur Terlengkap:* Auto-fill PokéAPI v2, Jurnal Taktis WYSIWYG, Cetak PDF Resmi A4, Ekspor/Impor Excel dengan Validasi 3 Status, serta RBAC Developer.
  - *Production Ready:* Berjalan stabil secara live di cloud server Railway dengan enkripsi SSL/HTTPS.
* **Tautan Akses & Dokumentasi:**
  - **Live URL:** `https://pokedex-k13-a2-production.up.railway.app/pokedex`
  - **GitHub Repo:** `https://github.com/Ryazkaa/pokedex-k13-a2`
  - **Dokumentasi Teknis:** Tersedia lengkap di folder `docs/` (`arsitektur-sistem.md`, Panduan Job 1 s.d. 4).
* **Sesi Tanya Jawab (Q&A):** Kami mengundang Bapak/Ibu Dosen Pengampu dan rekan-rekan mahasiswa untuk memberikan evaluasi, pertanyaan, dan masukan.

#### Kaitan Pertemuan Pemweb & Detail Teknis:
* **Kaitan Silabus Resmi:** `[Praktikum P14 & P15 : Presentasi Proyek Akhir]` & `[Pertemuan 16 : UAS]`
* **Catatan Presenter:** Tutup presentasi dengan ucapan terima kasih kepada dosen pengampu praktikum. Buka browser proyektor dan tawarkan demonstrasi fitur interaktif secara langsung.

#### Rekomendasi Visual / Screenshot:
* Kartu penutup ucapan terima kasih berlatar belakang Pokéball vektor merah cyber dengan badge logo resmi IPB University.

---
*Dokumen ini diperbarui secara komprehensif mengikuti Rencana Perkuliahan resmi Sekolah Vokasi IPB University (Pertemuan 1 s.d. 16).*
