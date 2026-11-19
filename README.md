# Pokédex Collection Tracker & Trainer Directory

Aplikasi web direktori dan pelacak koleksi Pokémon komprehensif berbasis **Laravel 11**, **PhpSpreadsheet**, **DataTables**, **Barryvdh DomPDF**, dan **Quill.js WYSIWYG Editor**. Dirancang khusus untuk eksplorasi katalog master Pokémon (*Pokemon Library*) hingga 1.025 entitas (Gen I–IX), pelacakan koleksi tangkapan pemain (*Pokédex Caught Tracker*), pencatatan jurnal strategi trainer (*Field Notes*), serta ekspor-impor data multi-format (Excel & PDF).

Proyek ini dikembangkan oleh **Kelompok 13 — Kelas Praktikum Pemrograman Web A / A2 (Sekolah Vokasi IPB University)**:
* **Arya Andra Diazka (J0404251155)** — *Lead Architect, DevOps & Master Library*
* **Yanuar Dwi Putra (J0404251139)** — *Authentication & Developer Role Management*
* **Madina Dwiyana Putri (J0404251097)** — *Pokédex Caught Tracker, DataTables & Export*
* **Iasha Irdanti (J0404251053)** — *Trainer Field Notes & Quill.js WYSIWYG Journal*

---

## 🌟 Sorotan Fitur Utama (v1.1 Concept Overhaul)

### 1. Pokemon Library (Master Catalog 1.025 Pokémon)
* **Katalog Lengkap Generasi I–IX:** Menyajikan data 1.025 Pokémon resmi dari wilayah Kanto hingga Paldea dengan 19 tipe elemen (18 standar + 1 Stellar).
* **Bento Grid Glassmorphism:** Tata letak modular bergaya *dark futuristic*, lengkap dengan kartu statistik *Kelengkapan Library* dan shortcut loncat cepat ke indeks terakhir.
* **Dropdown Filter Generasi 1–9:** Fitur filter interaktif `<select id="bentoGenFilter">` untuk menyaring Pokémon berdasarkan rentang generasi (#0001–#0151 s.d. #0906–#1025).
* **Import Master Dataset (.xlsx):** Khusus pengguna berstatus `developer`, tersedia panel import spreadsheet untuk memperbarui database master atau menambah Pokémon baru (#1026+).

### 2. Pokédex (Trainer Caught Tracker)
* **Pelacakan Koleksi Pribadi:** Trainer mencatat Pokémon yang telah berhasil ditangkap di lapangan.
* **Modal "+ Tambah Koleksi" (Integrasi PokéAPI):** Form penambahan tangkapan dengan tombol **"Ambil PokéAPI"** yang secara otomatis mengunduh nama, tipe utama, tipe sekunder, generasi, dan preview sprite resmi secara asinkron.
* **DataTables Collection View:** Tabel data canggih dengan pencarian instan, pengurutan kolom, dan pagination dinamis.
* **Ekspor Multi-Format:** Ekspor daftar koleksi tangkapan ke berkas **Microsoft Excel (.xlsx)** dan cetak dokumen resmi **PDF berstandar A4** dengan pustaka DomPDF.

### 3. Jurnal Taktik & Catatan Lapangan (Trainer Field Notes)
* **Catatan Tangkapan Lapangan:** Mencatat tanggal penangkapan (*caught date*) dan lokasi penangkapan (*caught location*, misal *Route 102*, *Viridian Forest*).
* **WYSIWYG Editor (Quill.js):** Editor teks interaktif berformat kaya (*bold, italic, list, quote*) dengan proteksi sanitasi HTML (*Anti-XSS*) untuk mendokumentasikan strategi bertarung Pokémon.

### 4. Manajemen Akun & Otoritas Role
* **Role Developer vs Trainer:** 4 anggota tim (Yanuar, Arya, Madina, Iasha) ditetapkan sebagai `developer` dengan lencana visual merah, berhak melakukan import master library. Pengguna umum berstatus `trainer` mengelola koleksi pribadi tanpa dapat mengubah katalog master.
* **Fitur Quick Switch Trainer:** Pengalihan akun instan untuk kemudahan demonstrasi dan evaluasi tugas praktikum.

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
│   └── README.md                   # Catatan rilis dan riwayat versi
├── datasets/                       # Dataset acuan spreadsheet (.xlsx)
├── docs/                           # Dokumentasi & rancangan sistem
│   └── arsitektur-sistem.md        # Dokumen rancangan arsitektur lengkap
├── src/                            # Kode sumber aplikasi Laravel 11
│   ├── app/                        # Controllers, Models, Middleware
│   ├── config/                     # Konfigurasi sistem
│   ├── database/                   # Migrations & Seeders
│   ├── public/                     # Aset statis (SVG icons, sprite, CSS, JS)
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

| Anggota | Modul Utama | Luaran & Komponen yang Dihasilkan |
|---|---|---|
| **Yanuar Dwi Putra**<br>*(J0404251139)* | **Modul 1:** Autentikasi, Sesi, & Role Developer | Migrasi `users.role`, `EnsureDeveloper` Middleware, `AuthController`, modal login/switch account (`auth-modal.blade.php`), lencana navbar. |
| **Arya Andra Diazka**<br>*(J0404251155)* | **Modul 2:** Master Library, Excel Import, & DevOps | Katalog 1.025 entitas master, validasi 4 kolom `PhpSpreadsheet`, Bento Card 2 Dropdown Gen 1–9, Card 3 Kelengkapan Library, Git branching & CI/CD deployment. |
| **Madina Dwiyana Putri**<br>*(J0404251097)* | **Modul 3:** Pokédex Caught Tracker & Ekspor | Migrasi `trainer_catches`, model `TrainerCatch`, modal `+ Tambah Koleksi` dengan auto-fetch PokéAPI, integrasi DataTables, serta ekspor Excel & DomPDF A4. |
| **Iasha Irdanti**<br>*(J0404251053)* | **Modul 4:** Field Notes & Jurnal Strategi Trainer | Migrasi `trainer_notes`, model `TrainerNote`, modal Jurnal Taktik dengan tanggal/lokasi tangkap, integrasi editor WYSIWYG Quill.js, sanitasi HTML. |

---

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk keperluan praktikum mata kuliah **Pemrograman Web** — Program Studi Manajemen Informatika / Teknologi Rekayasa Perangkat Lunak, Sekolah Vokasi IPB University.
