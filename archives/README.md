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
| `pokedex-app(v1.2.2).zip` | `v1.2.2` | 23 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Brand Visual Identity Overhaul (Official Pokéball SVG Vector Integration):**<br>1. **Pembaruan Favicon Peramban:** Memperbarui `favicon.svg` dan `favicon.ico` menjadi vektor Pokéball resmi (kubah merah `#FF1C1C`, kubah putih `#FFFFFF` berbayangan halus `#DFDFDF`, sabuk hitam, dan tombol pusat putih).<br>2. **Penyempurnaan Logo Navbar Kiri Atas:** Mengganti ikon brand navbar (`brand-logo__icon`) menjadi Pokéball SVG bundar yang presisi tanpa bingkai kotak merah yang kaku, dilengkapi efek interaksi hover rotasi 20 derajat.<br>3. **Standardisasi Ikon Seluruh Komponen:** Mengganti seluruh ikon kawat (*wireframe*) Pokéball pada modal Tambah Koleksi (`caught-modal.blade.php`), placeholder preview sprite, modal autentikasi (`auth-modal.blade.php`), status kosong tabel (`table.blade.php`), dan kartu Bento Grid menjadi ikon Pokéball SVG resmi. |
| `pokedex-app(v1.2.3).zip` | `v1.2.3` | 23 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Harmonisasi Bahasa Indonesia, Multi-Language Mode (ID/EN), Tanggal Penangkapan Kustom & Aksi CRUD Koleksi (Edit/Hapus):**<br>1. **Harmonisasi Bahasa Indonesia & Switcher ID/EN:** Penyelarasan seluruh judul navigasi dan bagian ke Bahasa Indonesia baku (Beranda, Eksplorasi, Koleksi, Pustaka) serta tombol toggle bilingual (`ID`/`EN`) di topbar dan menu drawer dengan penyimpanan `localStorage`.<br>2. **Urutan Navigasi Navbar Sesuai Alur Komponen:** Mengurutkan pil navbar: `Beranda` (`#home`) › `Eksplorasi` (`#explore`) › `Koleksi` (`#pokedex-caught`) › `Pustaka` (`#search`).<br>3. **Perbaikan Bug Tamu Bento Card 1:** Menghilangkan tampilan bug "9 Total Terdata" pada pengunjung tamu (belum login) menjadi status "Belum Masuk Akun" dengan ajakan login/daftar.<br>4. **Indikator Progres Persentase Koleksi:** Saat trainer login, menampilkan "X dari 1.025 Pokémon", lencana persentase dinamis (`%`), dan bilah progres koleksi.<br>5. **Modal Notifikasi Sesi di Tengah Layar:** Mengubah alert sesi menjadi modal popup animasi di tengah (`#sessionNotificationModal`).<br>6. **Pembaruan Menu Drawer:** Menghapus tombol Excel & filter cepat lawas yang usang, menambahkan ringkasan akun trainer (Login/Ganti Akun) dan pilihan bahasa.<br>7. **Tanggal Penangkapan Kustom (`caught_at`):** Input tanggal penangkapan pada modal Tambah Koleksi (default hari ini, dapat diubah).<br>8. **Fitur Edit Tanggal & Hapus Koleksi DataTables:** Penambahan tombol ✏️ Edit Tanggal (modal kustom & route backend `updateDate`) dan tombol 🗑️ Hapus (konfirmasi modal & route `destroy`). |
| `pokedex-app(v1.2.4).zip` | `v1.2.4` | 23 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Format Tanggal Baku (DD/MM/YYYY), Vektor SVG Resmi (Eliminasi Emoji), Bendera Vektor (ID/EN), Modal Konfirmasi Bahasa, Transisi Skeleton Shimmer, & Lokalisasi Bilingual Menyeluruh (Hero, Bento, Tabel, Showcase Modal):**<br>1. **Koreksi Label Format Tanggal:** Memperbaiki label petunjuk input tanggal dari `Tahun - Bulan - Tanggal` menjadi `Format: Tanggal - Bulan - Tahun (DD/MM/YYYY)` pada modal edit dan tambah tangkapan.<br>2. **Eliminasi Emoji & Migrasi ke Vektor SVG Murni:** Mengganti seluruh emoji bawaan sistem (pensil `✏️`, tempat sampah `🗑️`, catatan `📝`, grafik `📊`, dokumen `📄`, petir `⚡`, gembok `🔒`, pintu `🚪`) dengan ikon vektor SVG modern yang tajam dan serasi dengan tema Crimson Dark.<br>3. **Bendera Vektor Bahasa (ID/EN):** Mengganti emoji bumi `🌐` dengan bendera vektor Indonesia (Merah-Putih) dan Inggris (Union Jack) di bilah navigasi dan menu drawer.<br>4. **Modal Popup Konfirmasi Ganti Bahasa:** Menampilkan modal konfirmasi animasi (`#langConfirmModal`) sebelum pergantian bahasa dieksekusi.<br>5. **Transisi Skeleton Shimmer & Type-Reveal:** Efek pemindaian cyber transisi halus (*fast skeleton shimmer*) dan type-reveal pada seluruh teks yang diterjemahkan tanpa memperberat aplikasi.<br>6. **Lokalisasi Bilingual Menyeluruh (Deep Translation):**<br>&nbsp;&nbsp;• **Hero & Fun Facts:** Seluruh 20 Fun Facts dunia Pokémon di `config/pokedex.php` dilengkapi versi Bahasa Inggris (`title_en`, `desc_en`, `topic_en`, `category_en`, `source_en`) sehingga preview slide, kartu pop-up, tombol, dan petunjuk keyboard berganti dinamis.<br>&nbsp;&nbsp;• **Bento Grid:** Kolom struktur Excel (`index_number`, `pokemon_name`, `type`, `generation`), deskripsi koleksi trainer aktif, status entri indeks terakhir (`Entry #1025 · All 1,025 Pokémon Registered!`), serta modal kunci developer.<br>&nbsp;&nbsp;• **Tabel Master Library & Caught Tracker:** Kolom nilai Generasi (`Generation I (Kanto)` s.d. `Generation IX (Paldea)`) serta opsi dropdown filter generasi.<br>&nbsp;&nbsp;• **Showcase Modal Detail:** Subheader generasi (`#0001 · Generation I (Kanto)`), integrasi *asynchronous English flavor text fetching* dari PokéAPI (dengan in-memory cache) + fallback deskripsi bahasa Inggris, label sprites, footer navigasi (`Use ← → to navigate · Esc to close`), dan identitas kelompok (`Pokédex - Group 13 - Class A / A2`). |
| `pokedex-app(v1.3.1).zip` | `v1.3.1` | 24 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Bugfix & Redesain Visual Jurnal Taktik Trainer (Resolusi SQL Exception Kolom caught_date/location, Eliminasi Emoji Sistem ke SVG Murni & Centered Popup Modal Feedback):**<br>1. **Resolusi SQL Exception (Bug Solved):** Menambahkan migrasi `2026_11_24_000001_ensure_fields_in_trainer_notes_table.php` untuk melengkapi kolom `caught_date` dan `caught_location` pada tabel `trainer_notes`, serta menangani konversi string tanggal kosong sehingga operasi penyimpanan catatan taktis berfungsi 100% mulus.<br>2. **Redesain Total Crimson Dark Glassmorphism:** Menghapus tampilan modal kaku dan monoton menjadi estetika futuristik Crimson Dark (`#0f1923`) dengan border cyan neon, avatar sprite hologram melingkar, dan header cyber kicker.<br>3. **Eliminasi Total Emoji Sistem ke Vektor SVG Murni:** Mengganti seluruh emoji (📅, 📍, 🎯, 📝, 🗑) pada modal form menjadi ikon vektor SVG inline murni yang tajam dan serasi.<br>4. **Modal Popup Feedback Interaktif di Tengah Layar:** Mengganti alert browser dengan modal popup beranimasi di tengah layar (`#journalFeedbackModal`) berikon centang hijau emerald menyala saat simpan berhasil, dan ikon gembok merah saat belum login.<br>5. **Paket Arsip Utuh (23.66 MiB):** Menjamin paket arsip rilis memuat seluruh paket vendor, cache framework, dan kode sumber terlengkap. |
| `pokedex-app(v1.4.0).zip` | `v1.4.0` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Milestone Cloud Hosting & Production Deployment di Railway:**<br>1. **Ekstensi PHP Cloud (`ext-gd` & `ext-zip`):** Mendeklarasikan ekstensi wajib PhpSpreadsheet & DomPDF di `composer.json` dan `composer.lock` untuk kontainer Railpack Railway.<br>2. **Reverse Proxy & HTTPS Force Scheme:** Konfigurasi `$middleware->trustProxies(at: '*')` di `bootstrap/app.php` dan `URL::forceScheme('https')` di `AppServiceProvider.php`.<br>3. **Produksi HTTPS Assets & CSP:** Penggunaan `secure_asset()` dan meta tag `upgrade-insecure-requests` agar aset CSS/JS/SVG termuat aman tanpa *mixed content*.<br>4. **Build `config:cache` Sanitizer:** Sanitasi otomatis `app.url` di `config/app.php` dan penyesuaian header aman untuk mencegah galat `Invalid URI` saat build Railway. |
| `pokedex-app(v1.3.0).zip` | `v1.3.0` | 24 November 2026 | **Iasha Irdanti** & **Kelompok 13** | **Milestone Integrasi Modul 4 (Jurnal Taktis Trainer, Catatan Lapangan & Editor Quill.js WYSIWYG) & Finalisasi Seluruh 4 Modul Tim:**<br>1. **Merge Request !4:** Berhasil menggabungkan branch `feat/modul-4-journal-iasha` ke `main` melalui GitLab tanpa konflik.<br>2. **Skema Basis Data:** Migrasi tabel `trainer_notes` (`user_id`, `pokemon_id`, `title`, `content`, `caught_date`, `caught_location`) dan model `TrainerNote` berelasi `belongsTo` ke `User` dan `Pokemon`.<br>3. **Integrasi Editor WYSIWYG Quill.js:** Modal Jurnal Taktis Trainer (`#journalModal`) bertema gelap presisi dengan toolbar format teks lengkap (bold, italic, underline, ordered/bullet list, blockquote), placeholder adaptif, dan proteksi Anti-XSS (`strip_tags` HTML sanitization).<br>4. **Penyempurnaan Estetika & Vektor SVG:** Mengeliminasi seluruh emoji bawaan sistem pada modal jurnal dan menggantikannya dengan ikon vektor SVG inline murni, serta styling tema gelap kustom untuk toolbar dan editor container Quill snow.<br>5. **Bilingual Localization (ID/EN):** Seluruh elemen modal jurnal taktis terintegrasi penuh ke dalam sistem alih bahasa dinamis (`i18nDict`).<br>6. **Pencapaian Milestone Final:** Seluruh 4 Modul Kelompok 13 (Modul 1: Yanuar, Modul 2: Arya, Modul 3: Madina, Modul 4: Iasha) 100% selesai dan terintegrasi penuh ke dalam satu platform Pokédex monolitik modern. |
| `pokedex-app(v1.4.1).zip` | `v1.4.1` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Optimasi Tampilan Responsif Mobile & Tablet (Tanpa Mengubah Fitur):**<br>1. **Topbar Mobile Tanpa Terpotong:** Merampingkan layout `.topbar__inner`, ukuran brand logo, pil bahasa, serta `.topbar-auth-pill`, dan mengubah `#menuBtn` menjadi tombol ikon hamburger kompak pada layar `< 440px`.<br>2. **Hero Fun Fact Deck Adaptif:** Mengubah tinggi tetap `364px` menjadi `height: auto`, memberi `padding-bottom: 72px` untuk kontrol `< >` agar tidak menumpuk di atas teks atau menabrak Bento Grid.<br>3. **Bento Grid & Import Card Mobile:** Menata tombol `Import Pokemon untuk Database` bertumpuk rapi bersama lencana `TERKUNCI (DEV ONLY)` serta merapikan ukuran `.info-card` dan toolbar pencarian.<br>4. **Kartu Responsif 7-Kolom Caught Tracker:** Memisahkan layout kartu Master Library (`.dex-table--master`) dan DataTables Caught Tracker (`.caught-table`), plus penataan ulang kontrol DataTables.<br>5. **Scrollable Modals (`100dvh`):** Memastikan `dialog.showcase`, `dialog.fact-modal`, dan `.pkm-modal__dialog` dapat di-scroll vertikal di layar ponsel pendek. |
| `pokedex-app(v1.4.2).zip` | `v1.4.2` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Penyempurnaan UI Responsif Mobile Lanjutan (Polishing Layar Sempit):**<br>1. **Eyebrow, Isolasi Deck & Gradien Kontras Hero:** Menambahkan `flex-wrap: wrap` pada `.hero__eyebrow`, memposisikan slide deck non-aktif `position: absolute; inset: 0;`, dan mengarahkan gradien merah ke atas di belakang artwork agar teks hero kontras penuh.<br>2. **Topbar Login & Filter Tipe Grid 3 Kolom (`<= 479px`):** Menyembunyikan `.topbar-auth-name` pada layar `< 480px` agar seluruh kontrol tetap muat, serta menyusun 19 chip `Filter Tipe` dalam grid seragam 3 kolom (2 kolom di `< 360px`).<br>3. **Simetri Toolbar & Modal Auth 1-Baris:** Menata `.caught-toolbar` ke grid 1+2 (`1fr 1fr`), memperluas dropdown `.select-field` `100%` sejak `<= 600px`, menjaga `.auth-tabs` tetap 1 baris penuh di `<= 540px`, dan mengkompaksi stage `dialog.showcase`. |
| `pokedex-app(v1.5.0).zip` | `v1.5.0` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **PokéAPI Fetch by Name, Animated Autocomplete Dropdown & Perbaikan Scroll Modal:**<br>1. **Autocomplete Nama Pokémon Beranimasi (`#apiDexNameList`):** Ketik nama sebagian (misal `pik`) untuk menampilkan dropdown rekomendasi beranimasi (`caughtSuggestIn` / `caughtSuggestItemIn`) lengkap dengan sprite, badge index, tipe, dan dukungan navigasi keyboard (`↑`/`↓`/`Enter`/`Esc`), terurut index *ascending* (misal `#0025 Pikachu` di atas `#0731 Pikipek`).<br>2. **Ambil PokéAPI via Nama maupun Index:** Memindahkan `#btnFetchPokeApi` ke bawah field *Nama Pokémon* dan mendukung fetch berdasarkan **Nomor Index** ataupun **Nama Pokémon** lengkap.<br>3. **Perbaikan Scroll & Tombol Modal:** Menghapus inline `overflow: hidden` pada dialog `#addCaughtModal`, `#journalModal`, dan `#editCaughtDateModal` serta mengatur `.pkm-modal__actions .action-pill { width: auto; }` agar modal bisa di-scroll di zoom 100% dan tombol aksi sejajar rapi. |
| `pokedex-app(v1.5.1).zip` | `v1.5.1` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Bugfix Proteksi Duplikat Tangkapan & Informasi First Caught:**<br>1. **Deteksi Duplikat Sebelum Simpan (`PokedexCatchController::store()`):** Mengecek `trainer_catches` milik trainer aktif sebelum insert dan menolak penyimpanan ulang dengan respons HTTP `409` (`already_caught: true`, `first_caught_at`) tanpa menimpa tanggal penangkapan pertama.<br>2. **Popup Peringatan Amber `Sudah Pernah Ditangkap!` (`caught-modal.blade.php`):** Menambahkan varian `'warning'` (`#f59e0b`) pada `window.showCaughtFeedback()` yang menampilkan pesan informatif bahwa Pokémon sudah ada di Pokédex beserta lencana tanggal **First Caught**. |
| `pokedex-app(v1.5.2).zip` | `v1.5.2` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Ekspor Data Terpadu (Hold-to-Confirm + Animasi Burung Kertas) & Bento Distribusi Wilayah I–IX:**<br>1. **Tombol Terpadu `Ekspor Data` & Modal Pilihan Format (`caught-table.blade.php`):** Menyatukan `Ekspor Excel` dan `Unduh Laporan PDF` menjadi 1 tombol **Ekspor Data** (`#btnOpenCaughtExportModal`) yang membuka `#caughtExportModal` untuk memilih `.XLSX` atau `.PDF` dan mengonfirmasinya dengan **Hold to Confirm**.<br>2. **Animasi Dokumen → Burung Kertas Origami → Terbang ke Kanan Atas (`#paperBirdOverlay`):** Lembar dokumen `.XLSX`/`.PDF` terlipat menjadi burung kertas SVG bersayap mengepak dan terbang melengkung menuju sudut kanan atas layar (arah ikon Unduhan Chrome) saat file diunduh.<br>3. **Bento 1-Kotak Panjang `Distribusi Wilayah Generasi I – IX` (`bento.blade.php`):** Mengganti 2 kotak *Format & Aturan* menjadi 1 daftar batang populasi 9 region (**Kanto** s.d. **Paldea**) yang dapat diklik untuk langsung menyaring tabel Pustaka Pokémon (`data-filter-gen`) serta mendukung mode bilingual ID/EN. |
| `pokedex-app(v1.5.3).zip` | `v1.5.3` | 25 November 2026 | **Arya Andra Diazka** & **Kelompok 13** | **Reorganisasi Bento Kolom Tengah & Fitur Random Encounter Spotlight:**<br>1. **Susunan Baru Kolom Tengah (`bento.blade.php`, `pokedex.css`):** Menghilangkan dropdown *Filter Generasi* (`#bentoGenFilter`) yang sudah diwakili Bento kiri, memindahkan **Filter Tipe** (19 elemen) ke posisi teratas, dan menempatkan kartu **Import Pokemon untuk Database** di posisi bawah tepat di atas teks *Tarik & lepas file `.xlsx`*.<br>2. **Fitur `Random Encounter` Tengah (`#encounterCard`, `pokedex.js`, `caught-modal.blade.php`):** Menambahkan kartu eksplorasi acak dengan tombol **Acak**, **Detail** (buka Showcase Modal), dan **+ Tangkap** (otomatis mengisi form Tambah Koleksi via `openAddCaughtModal(prefill)`). |

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

### 7. Versi 1.2.2 (`pokedex-app(v1.2.2).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Penyempurnaan Identitas Brand Visual (Official Pokéball SVG Vector Asset):**
  1. **Favicon Resmi Browser (`favicon.svg` & `favicon.ico`):**
     * Mengganti ikon favicon kotak menjadi logo bundar Pokéball vektor resmi dengan kubah atas merah (`#FF1C1C`), kubah bawah putih (`#FFFFFF`) beraksen bayangan lembut (`#DFDFDF`), sabuk hitam pekat, serta tombol pusat putih presisi.
  2. **Logo Brand Navbar Kiri Atas:**
     * Ikon brand utama pada bilah navigasi diperbarui menampilkan Pokéball SVG resmi yang proporsional (tanpa kotak pembungkus merah kaku), dilengkapi efek visual *micro-interaction* berupa rotasi halus 20 derajat dan pembesaran skala saat kursor diarahkan (*hover*).
  3. **Standardisasi Ikon Seluruh Antarmuka:**
     * Menyeragamkan seluruh ikon Pokéball pada modal Tambah Koleksi (`caught-modal.blade.php`), placeholder *preview sprite* Pokémon, modal manajemen akun (`auth-modal.blade.php`), status kosong tabel katalog (`table.blade.php`), dan kartu ringkasan Bento Grid.

---

### 8. Versi 1.2.3 (`pokedex-app(v1.2.3).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Harmonisasi Bahasa Indonesia, Multi-Language Mode (ID/EN), Tanggal Penangkapan Kustom & Manajemen Koleksi (Edit Tanggal / Hapus):**
  1. **Harmonisasi Bahasa Indonesia & Switcher Bilingual (ID/EN):**
     * Seluruh judul navigasi dan label utama diselaraskan ke dalam Bahasa Indonesia baku (`Beranda`, `Eksplorasi`, `Koleksi`, `Pustaka`).
     * Tersedia tombol pengganti bahasa interaktif (`🌐 ID` / `EN`) di sebelah tombol Menu pada navbar atas serta di dalam menu drawer, didukung sistem kamus klien `localStorage` yang instan tanpa memuat ulang halaman.
  2. **Koreksi Urutan Navigasi Bilah Atas:**
     * Menyesuaikan urutan pil navigasi navbar agar selaras persis dengan alur fisik susunan halaman: `Beranda` (`#home`), `Eksplorasi` (`#explore`), `Koleksi` (`#pokedex-caught`), dan `Pustaka` (`#search`).
  3. **Penyelesaian Bug Tamu Bento Card 1 (Statistik Koleksi):**
     * Memperbaiki bug di mana pengunjung tamu (belum login) sebelumnya melihat teks "9 Total Terdata" dari database global.
     * Kini kartu secara elegan menampilkan status **"Belum Masuk Akun"** disertai tautan langsung untuk masuk atau mendaftar akun Trainer.
  4. **Metrik Persentase & Progres Visual Koleksi Tangkapan:**
     * Ketika trainer masuk ke dalam sistem, kartu menampilkan metrik presisi format **"X dari 1.025 Pokémon"**, lencana persentase warna hijau emerald (`%`), serta bilah kemajuan (*mini progress bar*) yang terisi dinamis.
  5. **Modal Popup Notifikasi Sesi di Tengah Layar:**
     * Mengganti banner sticky alert in-page dengan modal popup kustom beranimasi lembut di tengah layar (`#sessionNotificationModal`) dengan efek backdrop blur. Notifikasi kegagalan login kini diberi judul khusus "Gagal Masuk Akun" dan tombol pintas membuka modal autentikasi.
  6. **Pembersihan & Peningkatan Menu Drawer:**
     * Menghapus tombol export Excel dan filter cepat yang tidak aktif dari menu drawer.
     * Menggantikannya dengan informasi akun trainer aktif (nama, email, role badge, tombol ganti akun & keluar) serta tombol pemilihan bahasa (🇮🇩 Indonesia / 🇬🇧 English).
  7. **Input Tanggal Penangkapan Kustom (`caught_at`):**
     * Menambahkan field input tanggal penangkapan pada modal Tambah Koleksi PokéAPI.
     * Otomatis terisi tanggal hari ini (`YYYY-MM-DD`) secara default, namun pengguna bebas memilih tanggal masa lampau atau masa kini. Disimpan aman ke basis data MySQL pada kolom `trainer_catches.caught_at`.
  8. **Fitur Edit Tanggal & Hapus Tangkapan pada DataTables:**
     * Pada kolom aksi DataTables, disediakan tombol **✏️ Tanggal** yang membuka modal edit tanggal penangkapan tanpa mengubah data master Pokémon dari PokéAPI.
     * Disediakan tombol **🗑️ Hapus** lengkap dengan modal konfirmasi peringatan cyber merah untuk menghapus rekaman tangkapan dari buku koleksi trainer tanpa merusak data master Library.

---

### 9. Versi 1.2.4 (`pokedex-app(v1.2.4).zip`)
* **Tanggal Rilis:** 23 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Format Tanggal Baku (DD/MM/YYYY), Vektor SVG Murni (Anti-Emoji), Bendera Vektor (ID/EN), Modal Konfirmasi Bahasa & Transisi Skeleton Shimmer:**
  1. **Koreksi Label Format Tanggal Penangkapan:**
     * Memperbaiki teks petunjuk tanggal dari yang sebelumnya keliru `Format: Tahun - Bulan - Tanggal` menjadi `Format: Tanggal - Bulan - Tahun (DD/MM/YYYY)` pada modal edit tanggal dan modal form tambah tangkapan.
  2. **Eliminasi Total Emoji Sistem Menjadi Vektor SVG Profesional:**
     * Mengganti seluruh emoji sistem bawaan peramban yang tidak konsisten menjadi ikon vektor SVG inline murni yang tajam:
       * Pensil edit (`✏️`) diganti SVG pensil tajam (`#FBBF24`).
       * Tempat sampah (`🗑️`) diganti SVG trash bin (`#F87171`).
       * Catatan taktis (`📝`) diganti SVG notebook/document (`#38BDF8`).
       * Tombol Ekspor Excel (`📊`) diganti SVG spreadsheet.
       * Tombol Unduh PDF (`📄`) diganti SVG dokumen PDF.
       * Ikon Terkunci (`🔒`) pada badge Developer Bento diganti SVG padlock vektor presisi.
       * Ikon kilat (`⚡`) pada tombol autentikasi diganti SVG lightning bolt.
       * Ikon switch (`⇄`) dan logout (`🚪`) diganti SVG transfer & door icons.
  3. **Bendera Vektor Resmi pada Bahasa (ID/EN):**
     * Mengganti emoji bumi `🌐` dengan bendera vektor Indonesia (Merah-Putih) saat mode ID dan bendera vektor Inggris (Union Jack) saat mode EN pada bilah navigasi atas dan bilah menu drawer.
  4. **Modal Popup Konfirmasi Pergantian Bahasa (`#langConfirmModal`):**
     * Menghadirkan dialog konfirmasi beranimasi halus sebelum sistem mengganti bahasa, menampilkan animasi transisi bendera asal ke bendera tujuan, judul, deskripsi, serta tombol Batal dan Konfirmasi.
  5. **Transisi Cepat Skeleton Shimmer & Type-Reveal:**
     * Saat pergantian bahasa disetujui, kontainer utama memicu efek *cyber scanline shimmer* (`.lang-shimmer-active`) selama ~280ms dan efek *type-reveal* lembut pada seluruh elemen teks, memberikan kesan futuristik, responsif, dan ringan tanpa lag.
  6. **Penerjemahan Konten Secara Komprehensif (Lokalisasi Mendalam):**
     * **Hero Slide & Modal Fun Facts:** Seluruh 20 Fun Facts dunia Pokémon di `config/pokedex.php` diterjemahkan secara komprehensif ke Bahasa Inggris (`title_en`, `desc_en`, `topic_en`, `category_en`, `source_en`) sehingga preview slide, kartu pop-up, tombol `(read more...)` / `Close`, dan petunjuk keyboard berganti dinamis.
     * **Bento Grid:** Kolom struktur panduan Excel (`nomor_index` $\rightarrow$ `index_number`, `nama_pokemon` $\rightarrow$ `pokemon_name`, `tipe` $\rightarrow$ `type`, `generasi` $\rightarrow$ `generation`, `Generation I (Kanto)`), deskripsi koleksi trainer aktif, status entri indeks terakhir (`Entry #1025 · All 1,025 Pokémon Registered!`), serta modal kunci developer.
     * **Tabel Master Library & Caught Tracker:** Kolom nilai Generasi (`Generation I (Kanto)` s.d. `Generation IX (Paldea)`) serta opsi dropdown filter generasi.
     * **Showcase Modal Detail:** Subheader generasi (`#0001 · Generation I (Kanto)`), integrasi *asynchronous English flavor text fetching* dari PokéAPI (dengan in-memory cache) + fallback deskripsi bahasa Inggris, label sprites, footer navigasi (`Use ← → to navigate · Esc to close`), dan identitas kelompok (`Pokédex - Group 13 - Class A / A2`).


---

### 10. Versi 1.3.0 (`pokedex-app(v1.3.0).zip`)
* **Tanggal Rilis:** 24 November 2026
* **Kontributor Utama:** Iasha Irdanti (NIM: J0404251115) & Kelompok 13
* **Milestone Integrasi Modul 4 (Jurnal Taktis Trainer, Catatan Lapangan & Editor Quill.js WYSIWYG) & Finalisasi Seluruh 4 Modul Tim:**
  1. **Penggabungan Fitur GitLab (Merge Request !4):**
     * Branch `feat/modul-4-journal-iasha` resmi digabungkan (*merged*) ke dalam branch utama `main` oleh Arya Andra Diazka dengan pesan commit penggabungan `Merge branch 'feat/modul-4-journal-iasha' into 'main'`.
  2. **Skema Basis Data Jurnal Trainer (`trainer_notes`):**
     * Berkas migrasi `database/migrations/2026_11_20_000003_create_trainer_notes_table.php` mendefinisikan tabel relasional `trainer_notes`:
       * `user_id` (foreign key ke `users.id`, cascade on delete).
       * `pokemon_id` (foreign key ke `pokemon.id`, cascade on delete).
       * `title` (varchar 255, judul catatan taktik).
       * `content` (longText, isi catatan strategi bertarung hasil format WYSIWYG).
       * `caught_date` (date, nullable, tanggal penangkapan).
       * `caught_location` (varchar 150, nullable, lokasi penangkapan seperti *Route 102*, *Viridian Forest*).
     * Model Eloquent `App\Models\TrainerNote` dilengkapi relasi `belongsTo` ke `User` dan `Pokemon` serta atribut `$casts` untuk `caught_date`.
  3. **Kontroler Jurnal Lapangan (`TrainerJournalController`):**
     * Endpoint `GET /pokedex/notes/{pokemonId}` (`pokedex.notes.show`) untuk mengambil riwayat catatan trainer secara asynchronous via AJAX.
     * Endpoint `POST /pokedex/notes/{pokemonId}` (`pokedex.notes.store`) untuk menyimpan atau memperbarui (`updateOrCreate`) catatan taktik dengan validasi request dan sanitasi anti-XSS (`strip_tags` mengizinkan tag formatting teks aman).
     * Endpoint `DELETE /pokedex/notes/{pokemonId}` (`pokedex.notes.destroy`) untuk menghapus catatan taktis pengguna aktif.
  4. **Antarmuka Interaktif Quill.js WYSIWYG Modal (`journal-modal.blade.php`):**
     * Menghadirkan modal bertema gelap futuristik (`#journalModal`) dengan header hologram sprite Pokémon, subtitle dinamis, input tanggal penangkapan, lokasi penangkapan, judul strategi, serta editor Quill.js.
     * Toolbar format teks kaya: Bold, Italic, Underline, Ordered List, Bullet List, Blockquote, dan Clear formatting.
  5. **Harmonisasi Vektor SVG & Tema Gelap Presisi:**
     * Mengeliminasi seluruh emoji sistem pada modal jurnal dan menggantikannya dengan ikon vektor SVG inline murni yang tajam (kalender, pin peta, target crosshair, berkas catatan, tempat sampah, dan simpan).
     * Menerapkan CSS kustom tema gelap pada toolbar (`.ql-toolbar.ql-snow`) dan kontainer editor (`.ql-container.ql-snow`) dengan aksen border halus `rgba(255,255,255,0.12)`, warna teks `#F1F5F9`, stroke ikon `#94A3B8`, serta warna aktif biru langit `#38BDF8`.
  6. **Integrasi Penuh Multi-Bahasa (Bilingual ID/EN):**
     * Seluruh elemen judul modal, label field input, placeholder, tombol simpan, tombol hapus, dan pesan aksi terdaftar pada kamus `i18nDict` (`localStorage`), memastikan pengalaman lokalisasi dwibahasa yang konsisten.
  7. **Pencapaian Milestone Final Proyek:**
     * Dengan penggabungan Modul 4 ini, seluruh 4 Modul Tim Kelompok 13 telah **100% Selesai & Terintegrasi Sempurna**:
       * Modul 1 (Yanuar Dwi Prasetya): Autentikasi, Role Developer/Trainer & Middleware.
       * Modul 2 (Arya Andra Diazka): Master Pokemon Library, Excel Import, DevOps & Brand Identitas Pokéball.
       * Modul 3 (Madina Dwiyana Putri): Pokédex Caught Tracker, PokéAPI Integration, DataTables & Ekspor Excel/PDF.
       * Modul 4 (Iasha Irdanti): Jurnal Taktis Trainer, Catatan Lapangan & Quill.js WYSIWYG.


---

### 11. Versi 1.3.1 (`pokedex-app(v1.3.1).zip`)
* **Tanggal Rilis:** 24 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Bugfix & Redesain Visual Jurnal Taktik Trainer (Resolusi Skema Basis Data, Eliminasi Emoji ke SVG Murni, & Centered Modal Feedback):**
  1. **Resolusi Fatal SQL Exception (Bug Solved):**
     * Mengidentifikasi penyebab kegagalan simpan pada v1.3.0 di mana tabel `trainer_notes` sebelumnya tidak memiliki kolom `caught_date` dan `caught_location`.
     * Menambahkan berkas migrasi `database/migrations/2026_11_24_000001_ensure_fields_in_trainer_notes_table.php` dan memperbaiki skema migrasi awal agar otomatis menambahkan kolom tersebut bila tabel sudah ada.
     * Memperbaiki `TrainerJournalController` agar menangani tanggal kosong (`null`) secara aman, sehingga seluruh operasi simpan `updateOrCreate` berjalan 100% sukses tanpa galat SQL.
  2. **Redesain Menyeluruh Bertema Crimson Dark Glassmorphism:**
     * Merombak total tampilan modal jurnal dari yang sebelumnya gelap monoton menjadi desain **Crimson Dark Cyber Glassmorphism** (`#0f1923`) yang serasi dengan modal Tambah Koleksi (`#addCaughtModal`).
     * Menambahkan cyber kicker `MODUL 4 · TACTICAL FIELD JOURNAL`, border neon cyan (`#38bdf8`), glow shadow mendalam, dan bingkai melingkar bercahaya untuk avatar sprite Pokémon.
  3. **Eliminasi Total Emoji Bawaan Sistem ke Vektor SVG Murni:**
     * Menghilangkan seluruh emoji sistem peramban yang tidak konsisten (📅, 📍, 🎯, 📝, 🗑) dan menggantikannya dengan ikon vektor SVG inline murni yang tajam:
       * Tanggal Penangkapan: Ikon Kalender SVG (`#38bdf8`).
       * Lokasi Penangkapan: Ikon GPS Map Pin SVG (`#ff4655`).
       * Judul Strategi: Ikon Crosshair Target SVG (`#fbbf24`).
       * Catatan WYSIWYG: Ikon Dokumen & Quill Pen SVG (`#34d399`).
       * Hapus Catatan: Ikon Tempat Sampah SVG dengan tombol subtle red.
       * Simpan Jurnal: Ikon Disket/Save SVG dengan tombol gradien Crimson Cyber.
  4. **Modal Popup Notifikasi Feedback di Tengah Layar (`#journalFeedbackModal`):**
     * Menghilangkan seluruh fungsi `alert()` bawaan peramban yang kaku.
     * Menggantikannya dengan modal popup beranimasi di tengah layar (`#journalFeedbackModal`) berlatar belakang blur:
       * **Status Sukses:** Ikon centang hijau emerald bercahaya (`#34d399`), judul apresiasi, pesan dinamis menyebut nama Pokémon yang disimpan, dan tombol "Selesai".
       * **Status Belum Login (401):** Ikon gembok merah cyber (`#ff4655`), pesan peringatan hak akses trainer, tombol "Batal", dan tombol 1-klik "⚡ Masuk / Buka Menu Login" yang langsung membuka `#authModal`.
  5. **Integritas & Kelengkapan Paket Arsip (23.66 MiB):**
     * Menjalankan `php artisan package:discover` untuk memastikan seluruh manifest package dan service discovery Laravel ter-generate sempurna.
     * Menghasilkan arsip `pokedex-app(v1.3.1).zip` berukuran **23.66 MiB** (24.8 MB) yang utuh, lengkap, dan melebihi versi v1.2.4 sebelumnya.

---

### 12. Versi 1.4.0 (`pokedex-app(v1.4.0).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Milestone Cloud Hosting & Production Deployment di Railway:**
  1. **Deklarasi Ekstensi PHP Cloud (`composer.json` & `composer.lock`):**
     * Menambahkan dependensi `"ext-gd": "*"` dan `"ext-zip": "*"` secara eksplisit di `composer.json` dan memperbarui `composer.lock` agar kontainer Railpack di Railway otomatis memasang ekstensi pemrosesan gambar & arsip yang dibutuhkan `PhpSpreadsheet` dan `DomPDF`.
  2. **Reverse Proxy & Force HTTPS Scheme (`bootstrap/app.php` & `AppServiceProvider.php`):**
     * Menambahkan `$middleware->trustProxies(at: '*')` di `bootstrap/app.php` untuk membaca header proxy HTTPS dari Railway Load Balancer.
     * Mengaktifkan `URL::forceScheme('https')` pada environment produksi di `AppServiceProvider.php`.
  3. **Keamanan Aset Produksi (`secure_asset` & CSP):**
     * Menggunakan `secure_asset()` untuk seluruh stylesheet, skrip, favicon, dan ikon pada `layouts/app.blade.php` serta `pokedex/index.blade.php`.
     * Menyematkan meta tag `<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">` untuk mencegah pemblokiran *mixed content*.
  4. **Sanitasi URL & Build Cache Aman (`config/app.php`):**
     * Menambahkan fungsi pembersih otomatis `app.url` di `config/app.php` dan penyesuaian header agar perintah `php artisan config:cache` berjalan bebas dari galat `Invalid URI` selama proses build Railway.

---

### 13. Versi 1.4.1 (`pokedex-app(v1.4.1).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Optimasi Tampilan Responsif Mobile & Tablet (Layout & CSS Only):**
  1. **Topbar Mobile Anti-Clip (`navbar.blade.php` & `pokedex.css`):**
     * Menambahkan class `.topbar-lang-btn`, `.topbar-auth-pill`, `.topbar-auth-name`, dan `.topbar-menu-btn` agar seluruh tombol navigasi tetap muat di lebar layar `320px–480px`.
     * Pada layar `< 440px`, label teks `Menu` disembunyikan menjadi tombol ikon hamburger kompak `38px` sehingga tidak terpotong di tepi kanan layar.
  2. **Perbaikan Hero Fun Fact Stack Slides (`<= 899px`):**
     * Menghilangkan batas tinggi tetap `364px` menjadi `height: auto`, memberi ruang bawah `72px` agar tombol `< >` tidak menutupi teks deskripsi, dan mengunci tinggi slide non-aktif agar tidak mendorong atau menumpuk ke seksi Bento di bawahnya.
  3. **Bento Grid, Search Toolbar, & Caught Tracker DataTables:**
     * Menata ulang `.import-trigger-head` agar badge `TERKUNCI (DEV ONLY)` tidak menyempitkan judul kartu di layar HP.
     * Memisahkan transformasi kartu mobile tabel Master Library (`.dex-table--master`) dari tabel Koleksi Tangkapan (`.caught-table` / `#caughtDataTable`) dengan grid kartu 7-kolom khusus dan kontrol DataTables bertumpuk rapi.
  4. **Scrollable Modals (`100dvh`):**
     * Menerapkan `max-height: calc(100dvh - 24px)` dan `overflow-y: auto` pada `dialog.showcase`, `dialog.fact-modal`, serta `.pkm-modal__dialog` agar form Tambah Koleksi, Jurnal WYSIWYG, dan Autentikasi nyaman digulir di layar HP pendek.

---

### 14. Versi 1.4.2 (`pokedex-app(v1.4.2).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Penyempurnaan UI Responsif Mobile Lanjutan (`pokedex.css` Polishing):**
  1. **Eyebrow, Isolasi Deck & Gradien Kontras Hero (`<= 899px`):**
     * Menambahkan `flex-wrap: wrap` pada `.hero__eyebrow` agar judul eyebrow (`FUN FACT · TOPIK`) tidak terpecah menjadi dua kolom sempit.
     * Menetapkan `position: absolute; inset: 0;` pada `.hero__slide:not([data-depth="0"])` agar tinggi tumpukan kartu sepenuhnya mengikuti kartu depan aktif.
     * Mengubah gradien `.hero__card-bg` di mobile menjadi `linear-gradient(155deg, #ff4655 0%, #d92b3a 31%, #0f1923 31.3%, #131f2c 100%)` sehingga seluruh teks deskripsi berada di atas latar gelap kontras tinggi.
  2. **Topbar Login & Filter Tipe Grid 3 Kolom (`<= 479px` & `<= 359px`):**
     * Menyembunyikan `.topbar-auth-name` pada lebar `< 480px` agar badge `DEV`/`TRAINER`, tombol switch `⇄`, `Logout`, `ID`, dan tombol menu hamburger tetap muat hingga layar `320px`.
     * Mengatur `.filter-pills` menjadi grid seragam 3 kolom pada `<= 479px` (2 kolom pada `< 360px`) dengan ellipsis rapi pada nama tipe.
  3. **Simetri Toolbar, Dropdown & Modal Mobile (`<= 600px`, `<= 540px`):**
     * Mengatur `.caught-toolbar` menjadi grid 1+2 (`+ Tambah Koleksi` penuh di atas, `Ekspor Excel` & `Unduh Laporan PDF` sejajar di bawah).
     * Memperluas `.select-field` menjadi `100%` sejak lebar `<= 600px` dan merapikan tombol `.pager`.
     * Menjaga `.auth-tabs` (`Login | Daftar | Switch Dev (K13)`) tetap muat 1 baris penuh tanpa terlipat, serta mengkompaksi `.showcase__stage` (`height: 190px`) dan `.gallery__grid` 2 kolom di ponsel.

---

### 15. Versi 1.5.0 (`pokedex-app(v1.5.0).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Fitur PokéAPI via Nama, Dropdown Autocomplete Beranimasi & Perbaikan Scroll Modal:**
  1. **Perbaikan Bug Scroll Vertikal & Tata Letak Tombol Modal (`caught-modal.blade.php`, `journal-modal.blade.php`, `caught-table.blade.php`, `pokedex.css`):**
     * Menghapus deklarasi inline `overflow: hidden;` pada elemen `.pkm-modal__dialog` di `#addCaughtModal`, `#journalModal`, dan `#editCaughtDateModal` serta memperkuat aturan CSS `max-height: calc(100dvh - 24px) !important` dan `overflow-y: auto !important` agar modal Tambah Koleksi maupun modal lainnya dapat digulir mulus pada zoom 100% di desktop maupun mobile.
     * Menambahkan `.pkm-modal__actions .action-pill { width: auto; }` sehingga tombol `Batal` dan `Simpan Koleksi` berjajar seimbang pada satu baris di desktop dan tidak terpotong di bawah viewport.
  2. **Relokasi Tombol & Dukungan Fetch PokéAPI via Nama Maupun Index (`#btnFetchPokeApi`):**
     * Memindahkan `#btnFetchPokeApi` (**⚡ Ambil PokéAPI**) ke bawah kolom *Nama Pokémon* dengan bilah tombol lebar penuh yang responsif.
     * Mendukung pengambilan data PokéAPI v2 (`https://pokeapi.co/api/v2/pokemon/{identifier}`) baik menggunakan **Nomor Index** (`1–1025`) maupun **Nama Pokémon** lengkap (dengan normalisasi slug seperti `Mr. Mime` → `mr-mime`, `Farfetch'd` → `farfetchd`, `Nidoran♀` → `nidoran-f`) sekaligus mengisi otomatis kolom nomor index (`data.id`), nama, tipe 1/2, generasi, sprite URL, dan preview hologram.
  3. **Dropdown Rekomendasi Nama Pokémon Beranimasi & Terurut Index (`#apiDexNameList`):**
     * Menambahkan combobox (`role="combobox"`, `aria-autocomplete="list"`, `role="listbox"`) yang menampilkan daftar rekomendasi beranimasi (`@keyframes caughtSuggestIn` & `caughtSuggestItemIn`, menghormati `prefers-reduced-motion`) saat mengetik nama sebagian (misal `pik` menampilkan `#0025 Pikachu` lalu `#0731 Pikipek` karena urutan nomor index *ascending*).
     * Menyertakan thumbnail sprite, sorotan teks cocok (`<mark>`), daftar tipe, lencana nomor index `#0000`, navigasi keyboard lengkap (`ArrowDown`, `ArrowUp`, `Enter`, `Escape`), dan fallback sinkronisasi 1.025 spesies PokéAPI.

---

### 16. Versi 1.5.1 (`pokedex-app(v1.5.1).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Bugfix Proteksi Duplikat Tangkapan & Informasi First Caught:**
  1. **Penjagaan Duplikat di Backend (`PokedexCatchController::store()`):**
     * Memeriksa keberadaan entri `TrainerCatch` untuk `user_id` dan `pokemon_id` yang sama (`orderBy('id', 'asc')->first()`) sebelum membuat baris baru dan tanpa menimpa kolom `caught_at` yang sudah ada.
     * Jika sudah pernah ditangkap, endpoint mengembalikan status HTTP `409` dengan `already_caught: true` serta `first_caught_at` terformat Indonesia (`d F Y`, dari `caught_at ?? created_at`).
  2. **Popup Peringatan Informasional Varian Amber (`caught-modal.blade.php`):**
     * Menambahkan dukungan mode `'warning'` (`#f59e0b`) pada `window.showCaughtFeedback()` lengkap dengan ikon jam amber, judul **"Sudah Pernah Ditangkap!"**, pesan jelas yang menyebut nama dan nomor index Pokémon, serta lencana **First Caught: `<tanggal>`**.

---

### 17. Versi 1.5.2 (`pokedex-app(v1.5.2).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Ekspor Data Terpadu (Hold-to-Confirm + Animasi Burung Kertas) & Bento Distribusi Region I–IX:**
  1. **Penyatuan Tombol Toolbar `Ekspor Data` (`caught-table.blade.php`, `pokedex.js`, `pokedex.css`):**
     * Mengganti dua tombol terpisah (`Ekspor Excel` & `Unduh Laporan PDF`) menjadi satu tombol **Ekspor Data** (`#btnOpenCaughtExportModal`, label dwibahasa `btn_export_data`) dan menata grid toolbar mobile `<= 540px` menjadi 2 tombol sejajar simetris.
     * Klik **Ekspor Data** membuka `#caughtExportModal` dengan pilihan kartu **Excel Spreadsheet (`.XLSX`)** dan **Laporan Resmi PDF (`.PDF`)**, lalu tombol **Hold to Confirm** (`window.pkmSetupHoldButton`) berdesain perimeter & ring progres dinamis sesuai format terpilih.
  2. **Animasi Dokumen → Burung Kertas Origami → Terbang ke Kanan Atas (`#paperBirdOverlay`):**
     * Setelah tombol selesai ditahan, overlay menampilkan lembar dokumen `.XLSX` (emerald) atau `.PDF` (crimson), lalu melipatnya menjadi SVG burung kertas origami bersayap mengepak (`birdWingFlap`) yang terbang ke sudut kanan atas layar (arah ikon Unduhan Chrome + *pulse beacon*) tepat saat berkas diunduh.
  3. **Bento 1-Kotak Panjang `Distribusi Wilayah Generasi I – IX` (`bento.blade.php`, `pokedex.css`, `pokedex.js`):**
     * Mengganti 2 kotak bertumpuk *Format & Aturan* di kolom kiri Bento Grid dengan **1 kotak panjang tunggal** (`.region-panel`) berisi 9 grafik batang populasi wilayah dari **Kanto (Gen I)** hingga **Paldea (Gen IX)** dengan jumlah real-time dari database.
     * Setiap baris wilayah (`button.region-row[data-filter-gen]`) langsung menyaring tabel Pustaka Pokémon ketika diklik dan terjemahannya tersinkronisasi penuh dengan switcher ID/EN.

---

### 18. Versi 1.5.3 (`pokedex-app(v1.5.3).zip`)
* **Tanggal Rilis:** 25 November 2026
* **Kontributor Utama:** Arya Andra Diazka (NIM: J0404251155) & Kelompok 13
* **Reorganisasi Bento Kolom Tengah & Fitur Random Encounter Spotlight:**
  1. **Tata Letak Baru Bento Tengah (`bento.blade.php`, `pokedex.css`):**
     * Menghapus dropdown *Filter Generasi* (`#bentoGenFilter`) karena penyaringan generasi telah terwakili lebih visual di Bento kiri (*Distribusi Wilayah Generasi I–IX*).
     * Memindahkan panel **Filter Tipe** (19 chip elemen) ke posisi paling atas, lalu meletakkan kartu **Import Pokemon untuk Database** di posisi bawah tepat di atas teks *Tarik & lepas file `.xlsx` langsung ke panel ini untuk import cepat* (`.control-bottom-stack`).
  2. **Kartu `Random Encounter` Interaktif di Bagian Tengah (`#encounterCard`, `pokedex.js`, `caught-modal.blade.php`):**
     * Menampilkan Pokémon acak beserta sprite, nomor indeks, tipe, dan generasi, lengkap dengan tombol **Acak** (`#btnRollEncounter`) beranimasi putar dadu & efek *pop*.
     * Menyediakan tombol **Detail** (`data-open-pokemon`) yang langsung membuka Showcase Modal serta tombol **+ Tangkap** yang memanggil `openAddCaughtModal(prefill)` untuk mengisi otomatis seluruh form *Tambah Koleksi Pokédex* (termasuk hologram preview) dengan Pokémon tersebut.

---

## Petunjuk Penggunaan Berkas Arsip

Jika ingin menjalankan atau mereproduksi salah satu versi arsip:
1. Ekstrak berkas zip target (misal `pokedex-app(v1.2.2).zip`) ke dalam folder lokal.
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
