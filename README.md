# Pokédex Collection Tracker & Trainer Directory

Aplikasi web direktori dan pelacak koleksi Pokémon komprehensif berbasis **Laravel 11**, **PhpSpreadsheet**, **DataTables**, **Barryvdh DomPDF**, dan **Quill.js WYSIWYG Editor**. Dirancang khusus untuk eksplorasi katalog master Pokémon (*Pokemon Library*) hingga 1.025 entitas (Gen I–IX), pelacakan koleksi tangkapan pemain (*Pokédex Caught Tracker*), pencatatan jurnal strategi trainer (*Field Notes*), serta ekspor-impor data multi-format (Excel & PDF).

Proyek ini dikembangkan oleh **Kelompok 13 — Kelas Praktikum Pemrograman Web A / A2 (Sekolah Vokasi IPB University)**:
* **Arya Andra Diazka (J0404251155)** — *Lead Architect, DevOps & Master Library*
* **Yanuar Dwi Prasetya (J0404251022)** — *Authentication & Developer Role Management*
* **Madina Dwiyana Putri (J0404251090)** — *Pokédex Caught Tracker, DataTables & Export*
* **Iasha Irdanti (J0404251115)** — *Trainer Field Notes & Quill.js WYSIWYG Journal*

---

## 🌟 Sorotan Fitur Utama (v1.2 Release Milestone)

### 1. Pokemon Library (Master Catalog 1.025 Pokémon)
* **Katalog Lengkap Generasi I–IX:** Menyajikan data 1.025 Pokémon resmi dari wilayah Kanto hingga Paldea dengan 19 tipe elemen (18 standar + 1 Stellar).
* **Bento Grid Glassmorphism:** Tata letak modular bergaya *dark futuristic*, lengkap dengan kartu statistik *Kelengkapan Library* dan shortcut loncat cepat ke indeks terakhir.
* **Dropdown Filter Generasi 1–9:** Fitur filter interaktif `<select id="bentoGenFilter">` untuk menyaring Pokémon berdasarkan rentang generasi (#0001–#0151 s.d. #0906–#1025).
* **Import Master Dataset (.xlsx):** Khusus pengguna berstatus `developer`, tersedia panel import spreadsheet untuk memperbarui database master atau menambah Pokémon baru (#1026+).

### 2. Pokédex (Trainer Caught Tracker & DataTables)
* **Pelacakan Koleksi Pribadi:** Trainer mencatat Pokémon yang berhasil ditangkap di lapangan secara terstruktur.
* **Modal "+ Tambah Koleksi" (Integrasi PokéAPI):** Form penambahan tangkapan bertema Crimson Dark dengan tombol **"⚡ Ambil PokéAPI"** yang secara otomatis mengunduh nama, tipe utama, tipe sekunder, generasi, dan preview sprite resmi secara asinkron.
* **DataTables Collection View:** Tabel data interaktif dengan pencarian instan, pengurutan kolom, dan pagination dinamis.
* **Ekspor Multi-Format:** Ekspor daftar koleksi tangkapan ke berkas **Microsoft Excel (.xlsx)** dan cetak dokumen resmi **PDF berstandar A4** dengan pustaka DomPDF.
* **Proteksi Akses Tamu (Centered Auth Popup):** Pengunjung tamu yang mencoba menambah koleksi disambut dengan modal popup beranimasi di tengah layar berikon gembok merah berdenyut, yang langsung mengarahkan ke tab Login, Registrasi, atau Switch Dev Kelompok 13.

### 3. Jurnal Taktik & Catatan Lapangan (Trainer Field Notes)
* **Catatan Tangkapan Lapangan:** Mencatat tanggal penangkapan (*caught date*) dan lokasi penangkapan (*caught location*, misal *Route 102*, *Viridian Forest*).
* **WYSIWYG Editor (Quill.js):** Editor teks interaktif berformat kaya (*bold, italic, list, quote*) dengan proteksi sanitasi HTML (*Anti-XSS*) untuk mendokumentasikan strategi bertarung Pokémon.

### 4. Manajemen Akun & Otoritas Role
* **Role Developer vs Trainer:** 4 anggota tim (Yanuar, Arya, Madina, Iasha) ditetapkan sebagai `developer` dengan lencana visual merah, berhak melakukan import master library. Pengguna umum berstatus `trainer` mengelola koleksi pribadi tanpa dapat mengubah katalog master.
* **Fitur Quick Switch Trainer:** Pengalihan akun instan untuk kemudahan demonstrasi dan evaluasi tugas praktikum.

### 5. Brand Visual Identity (Official Pokéball SVG Integration)
* **Favicon & Logo Navbar Resmi:** Penggantian ikon kawat (*wireframe*) menjadi vektor Pokéball resmi (kubah merah `#FF1C1C`, kubah putih `#FFFFFF` beraksen bayangan `#DFDFDF`, sabuk hitam, dan tombol pusat putih) lengkap dengan animasi rotasi mikro pada bilah navigasi.

### 6. Harmonisasi Bahasa Indonesia & Multi-Language Switcher (v1.2.3 Milestone)
* **Bilingual Switcher (ID / EN):** Tombol pengalih bahasa interaktif pada navbar (`🌐 ID` / `EN`) dan bilah menu drawer yang menyimpan preferensi secara instan di `localStorage`. Judul dan label navigasi diselaraskan ke dalam Bahasa Indonesia baku (`Beranda`, `Eksplorasi`, `Koleksi`, `Pustaka`).
* **Input Tanggal Penangkapan Kustom (`caught_at`):** Form Tambah Koleksi PokéAPI dilengkapi input tanggal penangkapan fleksibel (default tanggal hari ini `YYYY-MM-DD`, dapat diubah) yang tersimpan ke basis data MySQL.
* **Fitur Edit Tanggal & Hapus Koleksi DataTables:** Trainer dapat mengedit tanggal tangkapan lewat modal ✏️ **Edit Tanggal** (`updateDate`) dan menghapus entri tangkapan lewat modal konfirmasi 🗑️ **Hapus** (`destroy`) tanpa merusak katalog master Library.
* **Indikator Progres Dinamis & Centered Alert Popups:** Pengunjung tamu tidak lagi melihat total data koleksi silang ("Belum Masuk Akun" dengan tautan masuk), sementara trainer login disajikan metrik persentase (`%`), jumlah tangkapan terhadap 1.025 Pokémon, dan seluruh pesan notifikasi tampil dalam popup animasi di tengah layar.

### 7. Refinement Visual & Transisi Multi-Bahasa (v1.2.4 Milestone)
* **Format Tanggal Baku (Tanggal - Bulan - Tahun):** Koreksi teks petunjuk format tanggal penangkapan menjadi format standar Indonesia `DD/MM/YYYY`.
* **Eliminasi Emoji ke Vektor SVG Murni:** Standardisasi seluruh ikon aksi tabel (pensil, tong sampah, catatan taktis), lencana status gembok, tombol ekspor, dan modal menjadi SVG inline murni yang tajam dan serasi dengan tema Crimson Dark.
* **Bendera Vektor Bahasa (ID/EN) & Modal Konfirmasi:** Penggantian ikon bahasa menjadi bendera vektor Indonesia (Merah-Putih) dan Inggris (Union Jack), dilengkapi modal konfirmasi animasi (`#langConfirmModal`) sebelum pergantian bahasa.
* **Transisi Cepat Skeleton Shimmer & Type-Reveal:** Efek transisi pemindaian cyber ultra-ringan (~280ms) dan type-reveal saat pergantian bahasa, serta penerjemahan komprehensif seluruh konten panduan dan metrik kartu.

### 8. Jurnal Taktis Trainer & Catatan Lapangan WYSIWYG (v1.3.0 Milestone Final)
* **Editor WYSIWYG Quill.js Bertema Gelap:** Modal Jurnal Taktis (`#journalModal`) terhubung langsung ke setiap Pokémon yang terkoleksi, menyajikan editor teks kaya (*bold, italic, list, blockquote*) dengan proteksi anti-XSS (`strip_tags`) untuk menyusun strategi bertarung.
* **Metadata Lapangan Lengkap:** Pencatatan lokasi penangkapan (*caught location*) dan tanggal penangkapan fleksibel.
* **Integrasi Penuh 4 Modul Tim (100% Selesai):** Seluruh modul anggota Kelompok 13 (Modul 1: Yanuar, Modul 2: Arya, Modul 3: Madina, Modul 4: Iasha) kini telah terintegrasi penuh ke dalam basis kode utama.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

* **Backend Framework:** [Laravel 11.x](https://laravel.com/) (PHP 8.2+)
* **Database Engine:** MySQL 8.0+ / MariaDB 10.4+
* **Frontend & Styling:** Vanilla JavaScript (ES6+), Modern Semantic HTML5, Custom CSS3 Grid & Flexbox Glassmorphism
* **Pustaka Pihak Ketiga:**
  * `phpoffice/phpspreadsheet` — Parsing & validasi dataset Excel (.xlsx)
  * `barryvdh/laravel-dompdf` — Kompilasi laporan cetak PDF berstandar A4
  * `datatables.net` — Tabel interaktif sisi klien
  * `quilljs` — Editor teks kaya WYSIWYG
  * `PokéAPI v2` — REST API data publik Pokémon

---

## 📁 Struktur Direktori Proyek

```
Pertemuan 999/
├── archives/                       # Berkas arsip checkpoint rilis
│   ├── pokedex-app(v1.0.0).zip     # Rilis base fondasi awal (Arya Andra Diazka)
│   ├── pokedex-app(v1.0.1).zip     # Rilis perombakan konsep v1.1 & UI Bento
│   ├── pokedex-app(v1.1.0).zip     # Rilis integrasi Modul 1: Auth & Role (Yanuar Dwi Prasetya)
│   ├── pokedex-app(v1.1.1).zip     # Rilis refinement: Navbar & Lock Modal Import (Yanuar & Arya)
│   ├── pokedex-app(v1.2.0).zip     # Rilis integrasi Modul 3: Caught Tracker & DataTables (Madina Dwiyana Putri)
│   ├── pokedex-app(v1.2.1).zip     # Rilis bugfix: DomPDF, Location Column, Crimson Dark Modal (Arya & Madina)
│   ├── pokedex-app(v1.2.2).zip     # Rilis brand overhaul: Official Pokéball SVG Vector (Arya & Kelompok 13)
│   ├── pokedex-app(v1.2.3).zip     # Rilis bilingual ID/EN, edit/delete caught date & centered alerts (Arya & K13)
│   ├── pokedex-app(v1.2.4).zip     # Rilis pure SVG icons, vector flags, lang modal & shimmer (Arya & K13)
│   ├── pokedex-app(v1.3.0).zip     # Rilis integrasi Modul 4: Jurnal Taktik & Quill.js WYSIWYG (Iasha Irdanti)
│   └── README.md                   # Catatan rilis dan riwayat versi komprehensif
├── datasets/                       # Dataset acuan spreadsheet (.xlsx)
├── docs/                           # Dokumentasi & rancangan sistem
│   └── arsitektur-sistem.md        # Dokumen rancangan arsitektur lengkap
├── src/                            # Kode sumber aplikasi Laravel 11
│   ├── app/                        # Controllers, Models, Middleware
│   ├── config/                     # Konfigurasi sistem
│   ├── database/                   # Migrations & Seeders
│   ├── public/                     # Aset statis (SVG icons, sprite, CSS, JS)
│   │   ├── images/pokeball.svg     # Logo Pokéball SVG vektor resmi
│   │   ├── favicon.svg             # Favicon Pokéball SVG peramban
│   │   └── favicon.ico             # Favicon Pokéball ICO peramban
│   ├── resources/views/pokedex/    # Template Blade & partial modular
│   └── routes/web.php              # Pemetaan rute per modul anggota
└── README.md                       # Dokumentasi utama repositori
```

---

## 🚀 Panduan Instalasi & Menjalankan Lokal

### 1. Kebutuhan Sistem
* PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `gd`, `zip`, `xml`)
* Composer >= 2.5
* MySQL >= 8.0
* Web Browser modern (Chrome, Edge, Firefox)

### 2. Langkah Instalasi

1. **Masuk ke direktori kode sumber (`src/`):**
   ```bash
   cd src
   ```

2. **Salin berkas konfigurasi lingkungan:**
   ```bash
   copy .env.example .env
   ```

3. **Pasang paket dependensi PHP:**
   ```bash
   composer install
   ```

4. **Konfigurasi basis data pada `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_pokedex
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan migrasi basis data:**
   ```bash
   php artisan migrate
   ```

7. **Jalankan server pengembangan Laravel:**
   ```bash
   php artisan serve
   ```
   Buka peramban web pada alamat: `http://127.0.0.1:8000/pokedex`

---

## 👥 Pembagian Tugas & Tanggung Jawab Anggota (Kelompok 13)

| Anggota | Modul Utama | Status Integrasi | Luaran & Komponen yang Dihasilkan |
|---|---|:---:|---|
| **Yanuar Dwi Prasetya**<br>*(J0404251022)* | **Modul 1:** Autentikasi, Sesi, & Role Developer | ✅ **Terintegrasi (v1.1.0 / v1.1.1)** | Migrasi `users.role`, `EnsureDeveloper` Middleware, `AuthController`, modal login/switch account (`auth-modal.blade.php`), lencana status navbar `DEV`/`TRAINER`. |
| **Arya Andra Diazka**<br>*(J0404251155)* | **Modul 2:** Master Library, Excel Import, & DevOps | ✅ **Terintegrasi (v1.0.1 / v1.1.1 / v1.2.1 / v1.2.2 / v1.2.3 / v1.2.4)** | Katalog 1.025 entitas master, validasi 4 kolom `PhpSpreadsheet`, Bento Card 2 Dropdown Gen 1–9, Card 3 Kelengkapan Library, Git branching, identitas brand Pokéball resmi, sistem bilingual (ID/EN) menyeluruh, dan CI/CD. |
| **Madina Dwiyana Putri**<br>*(J0404251090)* | **Modul 3:** Pokédex Caught Tracker, DataTables, & Ekspor | ✅ **Terintegrasi (v1.2.0 / v1.2.1)** | Migrasi `trainer_catches`, model `TrainerCatch`, modal `+ Tambah Koleksi` dengan auto-fetch PokéAPI, integrasi DataTables, serta ekspor Excel & DomPDF A4. |
| **Iasha Irdanti**<br>*(J0404251115)* | **Modul 4:** Field Notes & Jurnal Strategi Trainer | ✅ **Terintegrasi (v1.3.0)** | Migrasi `trainer_notes`, model `TrainerNote`, modal Jurnal Taktik dengan tanggal/lokasi tangkap, integrasi editor WYSIWYG Quill.js, sanitasi HTML. |

---

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk keperluan praktikum mata kuliah **Pemrograman Web** — Program Studi Manajemen Informatika / Teknologi Rekayasa Perangkat Lunak, Sekolah Vokasi IPB University.
