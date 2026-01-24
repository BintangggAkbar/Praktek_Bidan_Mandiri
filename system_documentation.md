# Sistem Informasi Rekam Medis & Manajemen Klinik

## 1. Judul Sistem
**Sistem Informasi Rekam Medis Elektronik (E-Rekam Medis)**

## 2. Gambaran Umum Sistem
Sistem ini adalah aplikasi berbasis web yang dirancang untuk mengelola operasional harian klinik kesehatan. Fungsi utamanya mencakup pendaftaran pasien, pencatatan rekam medis (pemeriksaan fisik, diagnosa, tindakan), pengelolaan stok obat, serta pelaporan manajerial. Sistem memisahkan peran operasional (Bidan) dengan peran manajerial (Admin) untuk menjaga integritas data dan efisiensi kerja.

## 3. Teknologi & Arsitektur Sistem
Sistem dibangun menggunakan arsitektur **Monolithic MVC (Model-View-Controller)** dengan teknologi berikut:

*   **Framework Backend**: Laravel (ver 12.0)
*   **Frontend**: Laravel Blade Templates dengan Tailwind CSS
*   **Database**: Relational Database (MySQL/MariaDB/PostgreSQL - dikelola via Eloquent ORM)
*   **Server Environment**: PHP 8.2+

Arsitektur sistem memisahkan logika bisnis (Controllers), presentasi data (Views/Blade), dan struktur data (Models) secara tegas. Middleware digunakan sebagai gerbang keamanan untuk validasi akses pengguna.

## 4. Struktur dan Peran Pengguna
Sistem memiliki dua aktor utama dengan tanggung jawab yang berbeda:

### A. Admin (Administrator)
Berperan sebagai pengelola sistem dan manajer operasional tingkat atas.
*   **Tanggung Jawab**: Mengelola data pengguna (Bidan), data master (Layanan, Obat - Read Only dalam konteks tertentu), dan melihat laporan.
*   **Batasan**: Admin memiliki akses **Read-Only** terhadap data sensitif pasien dan rekam medis untuk menjaga privasi medis, namun memiliki otoritas penuh atas akun pengguna.

### B. Bidan (Tenaga Medis)
Berperan sebagai operator utama pelayanan kesehatan.
*   **Tanggung Jawab**: Melakukan pendaftaran pasien, pemeriksaan medis, diagnosa, pemberian resep obat, dan pencatatan transaksi layanan.
*   **Otoritas**: Memiliki hak akses penuh (CRUD) untuk data operasional sehari-hari (Pasien, Rekam Medis).

## 5. Alur Autentikasi dan Otorisasi
Sistem menggunakan mekanisme keamanan berlapis:
1.  **Autentikasi**: Menggunakan sesi (Session-based Authentication) standar Laravel. Pengguna login menggunakan email dan password.
2.  **Role-Based Access Control (RBAC)**:
    *   Middleware `RoleMiddleware` memverifikasi peran pengguna (`admin` atau `bidan`) pada setiap permintaan ke rute yang dilindungi.
    *   Jika peran tidak sesuai, sistem akan menolak akses (HTTP 403 Forbidden).
3.  **Status Check**: Khusus untuk akun Bidan, terdapat pengecekan status (`aktif`/`nonaktif`) saat login. Akun nonaktif akan ditolak aksesnya.

## 6. Alur Kerja Sistem (Workflow)

### A. Alur Pelayanan Pasien (Bidan)
1.  **Pendaftaran**: Bidan mendaftarkan pasien baru atau mencari data pasien lama.
2.  **Pemeriksaan**: Bidan membuat Rekam Medis baru yang mencakup:
    *   Data vital (Tensi, Suhu, Berat Badan, dll).
    *   Anamnesa (Keluhan Utama).
    *   Pemeriksaan Fisik & Diagnosa.
3.  **Tindakan & Resep**:
    *   Memilih layanan yang diberikan.
    *   Memilih obat dari stok tersedia.
    *   **Validasi Stok**: Sistem secara otomatis mengecek ketersediaan stok obat sebelum menyimpan.
4.  **Finalisasi**: Data disimpan secara transaksional. Stok obat berkurang otomatis, dan riwayat medis pasien diperbarui.

### B. Alur Manajemen & Reporting (Admin)
1.  **Manajemen User**: Admin membuat/mengedit akun Bidan & mengelola status aktifnya.
2.  **Monitoring**: Admin melihat dashboard statistik (Kunjungan, Pendapatan, Stok Obat).
3.  **Pelaporan**: Admin dan Bidan dapat menarik laporan (Kunjungan, 10 Besar Penyakit, Pemakaian Obat, Keuangan) dan mengekspornya ke format CSV/Excel atau mencetak langsung.

## 7. Struktur Routing dan Kontrol Akses
Routing dikelompokkan berdasarkan peran untuk memudahkan pemeliharaan dan keamanan:

| Grup Route | Prefix URL | Middleware | Akses |
| :--- | :--- | :--- | :--- |
| **Auth** | `/`, `/login`, `/forgot-password` | `guest` | Publik / Unauthenticated |
| **Bidan** | `/bidan/*` | `auth`, `role:bidan` | Dashboard, Pasien (CRUD), Rekam Medis (W), Obat (CRUD), Laporan (R/W) |
| **Admin** | `/admin/*` | `auth`, `role:admin` | Dashboard, User Mgmt, Laporan (R), Master Data (CRUD/R) |

*(Note: W = Write/Create/Update, R = Read)*

## 8. Pengelolaan Data dan Relasi Utama
Model data dirancang menggunakan Eloquent ORM dengan relasi kunci sebagai berikut:

*   **User**: Tabel utama pengguna, dengan kolom `role` sebagai pembeda.
*   **Patient (Pasien)**: Menyimpan biodata pasien (One-to-Many ke Rekam Medis).
*   **MedicalRecord (Rekam Medis)**: Entitas pusat yang menghubungkan:
    *   `Pasien` (Siapa yang sakit)
    *   `User/Bidan` (Siapa yang memeriksa)
    *   `Service/Layanan` (Apa tindakannya)
    *   `Medicine/Obat` (Apa obatnya - Relasi Many-to-Many dengan pivot `jumlah` & `dosis`).
*   **Service (Layanan)**: Master data tindakan medis.
*   **Medicine (Obat)**: Master data farmasi dengan kontrol stok.

## 9. Mekanisme Keamanan Sistem
1.  **Validasi Input**: Semua input form divalidasi secara ketat di sisi server (Controller) untuk mencegah data korup atau injeksi.
2.  **Database Transaction**: Operasi simpan Rekam Medis dibungkus dalam `DB::transaction`. Jika stok obat tidak cukup atau terjadi error saat insert obat, seluruh transaksi (termasuk data pemeriksaan pasien) dibatalkan (Rollback) untuk mencegah ketidakkonsistenan data.
3.  **Race Condition Handling**: Menggunakan `lockForUpdate()` saat pengurangan stok obat untuk mencegah stok minus jika ada transaksi bersamaan.
4.  **Read-Only Policies**: Admin dibatasi hanya bisa melihat (View) data medis tanpa bisa mengubahnya, meminimalisir risiko manipulasi data medis oleh pihak non-medis.

## 10. Kesimpulan Analisis Sistem
Sistem ini adalah solusi manajemen klinik yang **fungsional, aman, dan terstruktur**. Kekuatan utamanya terletak pada **pemisahan hak akses yang jelas** antara peran manajerial dan operasional, serta **integritas data yang tinggi** melalui penggunaan transaksi database dan validasi stok realtime. Arsitektur MVC memudahkan pengembangan fitur di masa depan (seperti integrasi BPJS atau pembayaran digital). Sistem siap digunakan untuk mendukung operasional klinik skala kecil hingga menengah.
