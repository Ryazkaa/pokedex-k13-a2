\# Pokédex Collection Tracker \& Trainer Directory



Aplikasi web direktori dan pelacak koleksi Pokémon komprehensif berbasis Laravel dan PhpSpreadsheet. Dirancang khusus bagi para pemain dan penggemar Pokémon untuk mencari direktori data Pokémon secara instan, menandai status Pokémon yang sudah ditangkap (Caught Tracker), membintangi Pokémon favorit (Favorite System), serta mencadangkan dan memulihkan data koleksi melalui format spreadsheet Excel (.xlsx).



\---



\## Fitur Utama Aplikasi

\* \*\*Pencarian Cepat \& Multi-Filter:\*\* Pencarian instan berdasarkan nama dan nomor indeks Pokémon, filter tipe elemen, dan filter generasi.

\* \*\*Pelacak Koleksi \& Sistem Favorit:\*\* Menandai Pokémon yang sudah berhasil dikoleksi serta membintangi Pokémon favorit pemain.

\* \*\*Statistik Kelengkapan Koleksi:\*\* Memantau persentase kelengkapan koleksi database secara real-time.

\* \*\*Modul Ekspor dan Impor Excel:\*\* Pencadangan data koleksi ke format .xlsx dengan stempel waktu otomatis dan validasi skema 4 kolom wajib.

\* \*\*Antarmuka Modern Tactical Dark:\*\* Desain antarmuka berstandar tinggi yang responsif, ergonomis, dan terstruktur.



\---



\## Tim Pengembang

\* \*\*Arya Andra Diazka (J0404251155)\*\* — Project Lead, Core Architecture \& DevOps Integrator

&#x20; \* Mengembangkan arsitektur inti (P11), sistem UI/UX, modul manipulasi Excel PhpSpreadsheet, katalog direktori dasar, serta manajemen repositori Git dan deployment server.

\* \*\*\[Nama Teman A]\*\* — Authentication, Session \& Trainer Role

&#x20; \* Mengembangkan sistem autentikasi akun trainer, manajemen sesi login/register, dan pembatasan hak akses fitur.

\* \*\*\[Nama Teman B]\*\* — DataTables Integration \& Multi-Format Export

&#x20; \* Mengintegrasikan pustaka DataTables, penyortiran kolom tabel katalog, serta fitur ekspor data multi-format.

\* \*\*\[Nama Teman C]\*\* — WYSIWYG Editor \& Jurnal Catatan Trainer

&#x20; \* Mengembangkan editor teks kaya untuk modul jurnal catatan strategi dan analisis taktik Pokémon.



\---



\## Struktur Repositori

\* `pokedex-app/` : Source code utama aplikasi Laravel.

\* `docs/` : Berkas dokumentasi laporan praktikum dan arsitektur sistem.

\* `datasets/` : Berkas master data Pokémon dan sampel template spreadsheet.

\* `archives/` : Berkas arsip (.zip) rekam jejak perkembangan versi aplikasi.

\* `design-assets/` : Tangkapan layar antarmuka dan aset visual pendukung.



\---



\## Panduan Menjalankan Proyek

1\. Masuk ke direktori aplikasi:

&#x20;  ```bash

&#x20;  cd pokedex-app

&#x20;  ```

2\. Jalankan server lokal:

&#x20;  ```bash

&#x20;  php artisan serve

&#x20;  ```

3\. Buka peramban dan akses alamat `http://127.0.0.1:8000`.

