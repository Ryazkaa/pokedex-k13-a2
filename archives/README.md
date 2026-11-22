# Arsip Rilis & Rekam Jejak Versi (Release Archives)

Repositori ini menyimpan arsip kompresi (`.zip`) dari setiap pencapaian *milestone* dan checkpoint versi aplikasi **Pokédex Collection Tracker & Trainer Directory** sebagai bukti rekam jejak pengembangan perangkat lunak (*versioning timeline*) oleh **Kelompok 13 (Kelas A / A2)**.

---

## Daftar Berkas Arsip Rilis

| Berkas Arsip | Versi | Tanggal | Kontributor Utama | Cakupan Modul & Deskripsi Teknis |
|---|---|---|---|---|
| `pokedex-app(v1.0.0).zip` | `v1.0.0` | 19 November 2026 | **Arya Andra Diazka** | **Base Code & Master Foundation Pokédex:**<br>Arsip kompresi kode fondasi awal proyek yang dibangun lengkap oleh Arya Andra Diazka. Sudah mencakup implementasi **HTML5**, **CSS3 (Modern Bento Grid Glassmorphism)**, **JavaScript (ES6+)**, **PHP 8.2+**, **Laravel Framework 11**, **CRUD Database MySQL**, **Integrasi REST API (PokéAPI v2)**, serta **PhpSpreadsheet** (Import/Export catalog dasar 1.025 entitas Pokémon Gen I–IX). |
| `pokedex-app(v1.0.1).zip` | `v1.0.1` | 20 November 2026 | **Arya Andra Diazka** | **Minor Revision & Restrukturisasi Konsep v1.1:**<br>1. **Restrukturisasi Konsep:** Pemisahan tegas antara *Pokemon Library* (katalog master baca-saja bagi trainer, import khusus Developer) dengan *Pokédex* (koleksi tangkapan trainer).<br>2. **Bento Card 2:** Filter Generasi diperbarui menjadi Dropdown interaktif Generasi 1–9 (`#bentoGenFilter`), tombol Export di Library dialihkan.<br>3. **Bento Card 3:** Label diperbarui menjadi *"Kelengkapan Library"* dengan status *"Seluruh 1025 Pokémon Terdaftar!"* (menggantikan terminologi terkoleksi).<br>4. **Navbar & Identitas:** Pembaruan Made By menjadi *Kelompok 13 / Kelas A / A2*.<br>5. **Persiapan Kolaborasi Tim:** Menyiapkan slot modul kosong di `src/` agar bersih dan siap dikerjakan oleh Yanuar, Madina, dan Iasha sesuai pembagian modul masing-masing. |
| `pokedex-app(v1.1.0).zip` | `v1.1.0` | 22 November 2026 | **Yanuar Dwi Prasetya** & **Arya Andra Diazka** | **Milestone Integrasi Modul 1 (Autentikasi, Sesi, & Role Developer):**<br>1. **Merge Request !1:** Berhasil melakukan penggabungan fitur `feat/modul-1-auth-yanuar` ke `main` secara mulus tanpa konflik.<br>2. **Skema Basis Data:** Eksekusi migrasi kolom `role` (`developer`/`trainer`), `trainer_class`, dan `avatar_badge` pada tabel `users`.<br>3. **Role-Based Access Control:** Implementasi middleware `EnsureDeveloper` dan helper method `isDeveloper()` pada model `User`.<br>4. **Kontroler Autentikasi:** Implementasi `AuthController` dengan fitur login, register, switch account cepat 4 developer, dan logout.<br>5. **UI & Navigasi:** Modal autentikasi glassmorphism (`auth-modal.blade.php`), lencana dinamis `DEV` / `TRAINER` pada navbar Crimson Dark.<br>6. **Verifikasi:** Diuji coba lokal tanpa bug atau regresi visual (`php artisan migrate` & `serve`). |

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
* **Kontributor Utama:** Yanuar Dwi Prasetya (NIM: J0404251022) & Arya Andra Diazka (NIM: J0404251155)
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
  * **Stabilitas Sistem:**
    * Seluruh rute terhubung aman (`routes/web.php`), tampilan tetap responsif dan konsisten dengan palet warna Crimson Dark, serta bebas dari bug.

## Petunjuk Penggunaan Berkas Arsip

Jika ingin menjalankan atau mereproduksi salah satu versi arsip:
1. Ekstrak berkas zip target (misal `pokedex-app(v1.0.1).zip`) ke dalam folder lokal.
2. Salin berkas lingkungan:
   ```bash
   copy .env.example .env
   ```
3. Pasang dependensi PHP dan Node.js:
   ```bash
   composer install
   npm install
   ```
4. Buat kunci aplikasi dan jalankan migrasi basis data:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
