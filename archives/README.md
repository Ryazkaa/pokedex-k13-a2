# Arsip Rilis & Rekam Jejak Versi (Release Archives)

Repositori ini menyimpan arsip kompresi (`.zip`) dari setiap pencapaian *milestone* dan checkpoint versi aplikasi **Pokédex Collection Tracker & Trainer Directory** sebagai bukti rekam jejak pengembangan perangkat lunak (*versioning timeline*) oleh **Kelompok 13 (Kelas A / A2)**.

---

## Daftar Berkas Arsip Rilis

| Berkas Arsip | Versi | Tanggal | Kontributor Utama | Cakupan Modul & Deskripsi Teknis |
|---|---|---|---|---|
| `pokedex-app(v1.0.0).zip` | `v1.0.0` | 19 November 2026 | **Arya Andra Diazka** | **Base Code & Master Foundation Pokédex:**<br>Arsip kompresi kode fondasi awal proyek yang dibangun lengkap oleh Arya Andra Diazka. Sudah mencakup implementasi **HTML5**, **CSS3 (Modern Bento Grid Glassmorphism)**, **JavaScript (ES6+)**, **PHP 8.2+**, **Laravel Framework 11**, **CRUD Database MySQL**, **Integrasi REST API (PokéAPI v2)**, serta **PhpSpreadsheet** (Import/Export catalog dasar 1.025 entitas Pokémon Gen I–IX). |
| `pokedex-app(v1.0.1).zip` | `v1.0.1` | 20 November 2026 | **Arya Andra Diazka** | **Minor Revision & Restrukturisasi Konsep v1.1:**<br>1. **Restrukturisasi Konsep:** Pemisahan tegas antara *Pokemon Library* (katalog master baca-saja bagi trainer, import khusus Developer) dengan *Pokédex* (koleksi tangkapan trainer).<br>2. **Bento Card 2:** Filter Generasi diperbarui menjadi Dropdown interaktif Generasi 1–9 (`#bentoGenFilter`), tombol Export di Library dialihkan.<br>3. **Bento Card 3:** Label diperbarui menjadi *"Kelengkapan Library"* dengan status *"Seluruh 1025 Pokémon Terdaftar!"* (menggantikan terminologi terkoleksi).<br>4. **Navbar & Identitas:** Pembaruan Made By menjadi *Kelompok 13 / Kelas A / A2*.<br>5. **Persiapan Kolaborasi Tim:** Menyiapkan slot modul kosong di `src/` agar bersih dan siap dikerjakan oleh Yanuar, Madina, dan Iasha sesuai pembagian modul masing-masing. |
| `pokedex-app(v1.1.0).zip` | `v1.1.0` | 22 November 2026 | **Yanuar Dwi Prasetya** | **Milestone Integrasi Modul 1 (Autentikasi & Role Trainer):**<br>1. **Merge Request !1:** Berhasil melakukan penggabungan fitur `feat/modul-1-auth-yanuar` ke `main` secara mulus tanpa konflik.<br>2. **Skema Basis Data:** Eksekusi migrasi kolom `role` (`developer`/`trainer`), `trainer_class`, dan `avatar_badge` pada tabel `users`.<br>3. **Role-Based Access Control:** Implementasi middleware `EnsureDeveloper` dan helper method `isDeveloper()` pada model `User`.<br>4. **Kontroler Autentikasi:** Implementasi `AuthController` dengan fitur login, register, switch account cepat 4 developer, dan logout.<br>5. **UI & Navigasi:** Modal autentikasi glassmorphism (`auth-modal.blade.php`), lencana dinamis `DEV` / `TRAINER` pada navbar Crimson Dark. |
| `pokedex-app(v1.1.1).zip` | `v1.1.1` | 23 November 2026 | **Yanuar Dwi Prasetya** & **Arya Andra Diazka** | **Refinement UI Navbar & Proteksi Modal Terkunci Khusus Developer:**<br>1. **Penyempurnaan CSS Navbar:** Memperbaiki perataan layout `.topbar__inner` (`auto 1fr auto`) dan mengunci `white-space: nowrap` pada teks nama trainer agar tidak terlipat atau menumpuk.<br>2. **Proteksi Backend Import Master:** Mengunci rute `POST /pokedex/import` dengan middleware `EnsureDeveloper`.<br>3. **Modal Popup Animasi Akses Terkunci:** Mengganti alert kaku browser dengan modal popup kustom beranimasi halus (`#devLockModal`) di tengah layar, dilengkapi ikon merah berdenyut (`lock-icon-pulse`), logo tanda silang `✕`, dan tombol 1-klik buka Switch Developer (K13).<br>4. **Kesiapan Repositori:** 100% bebas bug visual dan siap untuk penggabungan Modul 3 (Madina) dan Modul 4 (Iasha). |
| `pokedex-app(v1.2.0).zip` | `v1.2.0` | 23 November 2026 | **Madina Dwiyana Putri** | **Milestone Integrasi Modul 3 (Pokédex Caught Tracker, PokéAPI, DataTables & Ekspor):**<br>1. **Merge Request !3:** Berhasil melakukan penggabungan branch `feat/modul-3-caught-madina` ke `main` via GitLab.<br>2. **Skema Basis Data:** Migrasi tabel `trainer_catches` dan model `TrainerCatch` untuk menyimpan relasi penangkapan Pokémon oleh pengguna.<br>3. **Integrasi PokéAPI v2:** Modal form Tambah Koleksi dengan fitur auto-fetch data nomor indeks, nama, tipe 1 & 2, generasi, dan URL sprite.<br>4. **Tabel DataTables:** Menampilkan katalog koleksi tangkapan dengan pencarian instan, sorting kolom, dan pagination dinamis.<br>5. **Ekspor Spreadsheet (.xlsx):** Menghasilkan file Excel rekap koleksi trainer menggunakan pustaka `PhpSpreadsheet`.<br>*(Catatan: Rilis v1.2.0 ini merupakan checkpoint original hasil merge Madina sebelum perbaikan bug v1.2.1).* |
| `pokedex-app(v1.2.1).zip` | `v1.2.1` | 23 November 2026 | **Arya Andra Diazka** & **Madina Dwiyana Putri** | **Bugfix & Visual Overhaul (DomPDF, Skema Location, Crimson Dark Modal & Auth Popup):**<br>1. **Instalasi Paket DomPDF (Bug 2 Solved):** Mengintegrasikan paket `barryvdh/laravel-dompdf` (v3.1.2) ke dalam `src/composer.json` dan direktori `vendor/`, memperbaiki kegagalan fatal saat mencetak laporan PDF berstandar A4.<br>2. **Resolusi Kolom 'location' (Bug 4 Solved):** Menyempurnakan migrasi `trainer_catches` dan menambahkan migrasi `2026_11_23_000001_ensure_location_in_trainer_catches_table.php` sehingga penyimpanan tangkapan Pokémon bebas dari SQL exception `Column not found: 1054`.<br>3. **Redesain Crimson Dark Modal Tambah Koleksi (Bug 1 Solved):** Mengganti tampilan modal form yang sebelumnya putih polos (`#ffffff`) menjadi estetika futuristik **Crimson Dark Glassmorphism** (`#0f1923`) dengan aksen merah cyber (`#ff4655`), input gelap, hologram card preview sprite interaktif, dan animasi masuk `pkmModalIn`.<br>4. **Modal Popup Animasi Akses Terkunci di Tengah (Bug 3 Solved):** Mengganti alert browser pada pengunjung tamu dengan popup modal beranimasi di tengah layar (`#caughtAuthPromptModal`) berikon gembok merah berdenyut. Saat ditutup, modal ini secara otomatis membuka menu akun (`#authModal`) yang memuat tab Login, Daftar, dan DevKit (Switch Dev Kelompok 13).<br>5. **Statistik Bento Dinamis:** Menghubungkan Kartu 1 Bento Grid dengan query real-time total Pokémon yang berhasil dikoleksi trainer aktif. |

---

## Detail Rincian Versi

### 1. Versi 1.0.0 (`pokedex-app(v1.0.0).zip`)
* **Arsitek & Pengembang:** Arya Andra Diazka (NIM: J0404251155)
* **Karakteristik & Fitur:**
  * Fondasi monolitik Laravel 11 dengan struktur MVC standar industri.
  * Antarmuka visual gelap (*dark futuristic glassmorphism*) dengan tata letak Bento Grid responsif (CSS Grid & Flexbox modern).
  * Sistem katalog master data mencakup seluruh **1.025 entri Pokémon** lintas Generasi I hingga IX (Kanto sampai Paldea).
  * Pustaka ikon 19 tipe elemen (18 tipe resmi + 1 Stellar) berbasis file SVG vektor lokal resolusi tinggi.
  * Fitur pencarian instan sisi klien (*client-side search*) dengan shortcut keyboard `/`, serta filter tipe elemen.
  * Integrasi pustaka `phpoffice/phpspreadsheet` untuk import dataset `.xlsx` dengan validasi 4 kolom wajib (`nomor_index`, `nama_pokemon`, `tipe`, `generasi`).
  * Modal detail Pokémon dengan fetching otomatis ke PokéAPI (*front-default sprite*, status, tipe).

---

### 2. Versi 1.0.1 (`pokedex-app(v1.0.1).zip`)
* **Tanggal Rilis:** 20 November 2026
* **Perubahan & Penyempurnaan Minor:**
  * **Pemisahan Konsep Master Library vs Pokédex Koleksi:**
    * *Pokemon Library*: Katalog referensi master 1.025 Pokémon yang bersifat *read-only* bagi trainer umum. Tombol Export dihapus dari halaman Library karena fitur ekspor dialihkan khusus ke koleksi tangkapan pribadi trainer di Pokédex. Fitur Import Excel pada Library diisolasi khusus untuk akun berstatus `developer` (Arya, Yanuar, Madina, Iasha) guna mengupdate atau menambah entri master (misal jika kelak ada Pokémon #1026+).
    * *Pokédex*: Halaman koleksi tangkapan personal tempat trainer mencatat tanggal tangkap, lokasi tangkap, catatan taktis WYSIWYG, serta ekspor PDF/Excel.
  * **Penyempurnaan UI Bento Grid:**
    * **Bento Card 2 (Filter Generasi):** Diganti dari tombol pill statis menjadi elemen dropdown `<select id="bentoGenFilter">` yang memungkinkan pengguna memilih Generasi 1 sampai 9 secara interaktif.
    * **Bento Card 2 (Kontrol Data):** Panel ekspor mandiri dihilangkan, menyisakan panel *Import Master Dataset (.xlsx)* yang siap dihubungkan dengan hak akses Developer.
    * **Bento Card 3 (Statistik & Progress):** Label utama diganti menjadi **"Kelengkapan Library"** dan teks status disesuaikan menjadi **"Seluruh 1025 Pokémon Terdaftar!"** (bukan "Terkoleksi").
  * **Identitas Kelompok:**
    * Menu dropdown Made By di Navbar diperbarui menampilkan identitas resmi: **Kelompok 13** dan **Kelas A / A2**.
  * **Kesiapan Modul Tim (`src/`):**
    * Memastikan kode sumber `src/` tetap bersih (*clean base*) dari fitur final anggota lain, sehingga Yanuar, Madina, dan Iasha dapat mengerjakan modul mereka masing-masing sesuai spesifikasi modul tanpa terjadi konflik kode (*merge conflict*).

---

### 3. Versi 1.1.0 (`pokedex-app(v1.1.0).zip`)
* **Tanggal Rilis:** 22 November 2026
* **Kontributor Utama:** Yanuar Dwi Prasetya (NIM: J0404251022)
* **Milestone Integrasi Modul 1 (Autentikasi & Manajemen Sesi Trainer):**
  * **Penggabungan Branch Fitur (Merge Request !1):**
    * Branch `feat/modul-1-auth-yanuar` resmi digabungkan (*merged*) ke dalam branch `main` melalui GitLab Merge Request dengan metode fast-forward tanpa konflik.
  * **Migrasi Skema Basis Data:**
    * Berkas migrasi `database/migrations/2026_11_22_225257_add_role_and_trainer_fields_to_users_table.php` menambahkan kolom `role` (enum: `developer`, `trainer`), `trainer_class` (varchar 100), dan `avatar_badge` (varchar 255) ke dalam tabel `users`.
    * Migrasi berhasil dieksekusi via `php artisan migrate`.
  * **Model Pengguna (`App\Models\User`):**
    * Menambahkan atribut `$fillable` untuk `role`, `trainer_class`, dan `avatar_badge`.
    * Menyediakan method helper `isDeveloper()` yang mengembalikan nilai boolean untuk memverifikasi hak akses developer kelompok.
  * **Middleware Proteksi (`App\Http\Middleware\EnsureDeveloper`):**
    * Mengunci endpoint mutasi katalog master library agar hanya dapat diakses oleh akun dengan role `developer`.
  * **Kontroler Autentikasi (`App\Http\Controllers\AuthController`):**
    * Menangani proses `login`, `register`, `logout`, dan tampilan form login/registrasi.
    * Fitur **Quick Switch Developer (`/trainer/switch/{id}`)**: Memungkinkan pergantian akun instan antar 4 developer (Arya, Yanuar, Madina, Iasha) untuk mempermudah evaluasi dan demonstrasi praktikum.
  * **Penyempurnaan UI & Integrasi Visual:**
    * Menambahkan modal autentikasi (`resources/views/pokedex/partials/auth-modal.blade.php`) dengan desain *dark glassmorphism*.
    * Navbar menampilkan tombol interaktif: tombol **"Masuk"** saat tamu (*guest*), atau lencana merah **`DEV`** / hijau **`TRAINER`**, nama trainer, tombol switch `⇄`, dan tombol `Logout` saat sesi aktif.

---

### 4. Versi 1.1.1 (`pokedex-app(v1.1.1).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Yanuar Dwi Prasetya (NIM: J0404251022) & Arya Andra Diazka (NIM: J0404251155)
* **Penyempurnaan Antarmuka (UI Refinement) & Proteksi Ketat Fitur Developer:**
  * **Perbaikan Navbar & Tipografi Trainer:**
    * Mengubah pembagian grid navbar `.topbar__inner` menjadi `auto 1fr auto` sehingga kolom status akun di sebelah kanan memiliki ruang yang cukup dan tidak tertekan menyempit.
    * Menambahkan aturan `white-space: nowrap;` pada class `.pill` dan nama trainer, sehingga teks nama panjang (seperti *Yanuar Dwi Prasetya*) tetap tertata rapi dalam satu baris horizontal sejajar dengan lencana `DEV`, tombol switch `⇄`, dan tombol `Logout`.
  * **Proteksi Fitur Import Master Library:**
    * Mengunci endpoint `POST /pokedex/import` menggunakan middleware `App\Http\Middleware\EnsureDeveloper::class` di backend.
    * Menambahkan pengecekan status developer pada Bento Card 2: pengguna berstatus Trainer umum atau tamu (*guest*) tidak dapat memicu dialog file picker atau drag-and-drop file spreadsheet master.
  * **Modal Popup Animasi Akses Terkunci (`#devLockModal`):**
    * Menghilangkan alert bawaan browser yang kaku, menggantikannya dengan modal popup glassmorphism yang muncul beranimasi di tengah layar.
    * Dilengkapi logo lingkaran merah berdenyut (*pulsing red glow*) dengan tanda silang perisai (`✕`), teks pemberitahuan hak akses, serta tombol 1-klik **"⚡ Buka Switch Developer (K13)"** yang langsung membuka tab pergantian akun developer.

---

### 5. Versi 1.2.0 (`pokedex-app(v1.2.0).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Madina Dwiyana Putri (NIM: J0404251090)
* **Milestone Integrasi Modul 3 (Pokédex Caught Tracker, DataTables, & Ekspor):**
  * **Penggabungan Fitur (Merge Request !3):**
    * Branch `feat/modul-3-caught-madina` digabungkan ke branch utama `main` via GitLab.
  * **Skema Tabel Tangkapan (`trainer_catches`):**
    * Migrasi tabel `trainer_catches` dan model `App\Models\TrainerCatch` dengan relasi `belongsTo` ke `User` dan `Pokemon`.
  * **Kontroler Koleksi (`App\Http\Controllers\PokedexCatchController`):**
    * Menyediakan endpoint `store`, `destroy`, `toggleFavorite`, `exportExcel`, dan `exportPdf`.
  * **Integrasi PokéAPI v2:**
    * Modal Tambah Koleksi dengan pengisian otomatis nomor indeks, nama, tipe, dan URL sprite dari endpoint publik PokéAPI.
  * **Tabel Interaktif DataTables:**
    * Menampilkan koleksi Pokémon trainer dengan fitur sorting, pencarian, dan pagination.
  * **Status Rilis:**
    * Berkas rilis ini mencerminkan snapshot kode awal hasil penggabungan Madina sebelum penyempurnaan bugfix v1.2.1.

---

### 6. Versi 1.2.1 (`pokedex-app(v1.2.1).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Madina Dwiyana Putri (NIM: J0404251090)
* **Penyelesaian 4 Isu Bugfix & Redesain Visual Premium:**
  1. **Bug 1 Solved (Redesain Modal Tambah Koleksi):**
     * Tampilan modal form yang sebelumnya berlatar belakang putih polos `#ffffff` dirombak total menjadi **Crimson Dark Glassmorphism** (`#0f1923`) berbingkai merah cyber (`#ff4655`).
     * Form dilengkapi label cyber kicker, input dan dropdown bertema gelap, tombol aksi Ambil PokéAPI berikon petir, hologram box preview sprite interaktif, dan animasi masuk lembut `pkmModalIn`.
  2. **Bug 2 Solved (Pustaka Barryvdh DomPDF):**
     * Memasang paket `barryvdh/laravel-dompdf` (v3.1.2) ke direktori `vendor/` dan `composer.json` sehingga ekspor PDF berformat A4 portrait (`pokedex.reports.pokedex-pdf`) berfungsi sempurna tanpa kendala `Class Pdf not found`.
  3. **Bug 3 Solved (Modal Popup Peringatan Autentikasi di Tengah):**
     * Menghilangkan alert bawaan browser saat pengguna belum login mencoba menambah koleksi tangkapan.
     * Menggantikannya dengan modal popup beranimasi di tengah layar (`#caughtAuthPromptModal`) dengan ikon gembok merah berdenyut (`lock-icon-pulse`).
     * Saat popup ini ditutup atau diklik tombolnya, antarmuka langsung membuka `#authModal` yang menyajikan tiga pilihan akun: **Login**, **Daftar**, dan **Switch Dev Kelompok 13**.
  4. **Bug 4 Solved (Resolusi Missing Column 'location'):**
     * Mengatasi galat SQL `Unknown column 'location' in 'field list'` dengan memperbarui skema migrasi dan menambahkan migrasi `2026_11_23_000001_ensure_location_in_trainer_catches_table.php`.
     * Seluruh operasi penambahan koleksi Pokémon berhasil tersimpan mulus ke dalam basis data MySQL.

---

## Petunjuk Penggunaan Berkas Arsip

Jika ingin menjalankan atau mereproduksi salah satu versi arsip:
1. Ekstrak berkas zip target (misal `pokedex-app(v1.2.1).zip`) ke dalam folder lokal.
2. Salin berkas lingkungan:
   ```bash
   copy .env.example .env
   ```
3. Konfigurasikan kredensial basis data MySQL pada `.env`.
4. Jalankan migrasi basis data:
   ```bash
   php artisan migrate
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada: `http://127.0.0.1:8000/pokedex`
