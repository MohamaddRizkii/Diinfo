# Diinfo - Portal Berita Digital

**Diinfo** adalah platform portal berita digital berbasis web yang mengadopsi arsitektur *Decoupled Fullstack* (RESTful API Backend + Frontend UI terintegrasi). Proyek ini dibangun secara mandiri untuk memenuhi tugas besar UAS dengan fokus pada kecepatan performa *no-reload*, keamanan token mandiri, serta tampilan antarmuka premium sekelas media nasional terpercaya.

---

##  1. Bahasa Pemrograman yang Digunakan

* **PHP 8.2+**: Digunakan sebagai pondasi utama untuk membangun arsitektur core sistem dan RESTful API di sisi Server (*Server-Side*).
* **JavaScript (ES6+)**: Digunakan secara masif di sisi Klien (*Client-Side*) untuk mengonsumsi data API secara *asynchronous* melalui Fetch API, memungkinkan pemrosesan data interaktif secara *real-time*.
* **HTML5 & CSS3**: Digunakan sebagai kerangka struktural halaman web dan penataan elemen visual dasar.

---

##  2. Framework, Library, API, dkk yang Digunakan

* **Laravel 12**: Framework PHP utama yang digunakan untuk mengelola perutean web, kendali API backend, manajemen database Eloquent ORM, serta validasi request data.
* **Tailwind CSS (via CDN)**: Framework CSS berbasis *utility-first* untuk merancang antarmuka (UI) yang estetik, bersih, adaptif di berbagai ukuran layar (responsif), serta mendukung efek animasi transisi visual.
* **RESTful API Mandiri**: Seluruh komunikasi data antar halaman depan (Blade) dan database dijembatani oleh *endpoint* API buatan sendiri (jalur `/api/...`) dengan format respon JSON standar.
* **Custom Token Authentication Middleware**: Gerbang keamanan pintu masuk privat (`ManualAuth` middleware) yang dirancang secara mandiri dengan memanfaatkan pencatatan string token acak pada tabel database pengguna, menggantikan peran package eksternal seperti Laravel Sanctum.
* **MySQL & phpMyAdmin**: Berperan sebagai sistem manajemen database relasional (RDBMS) lokal untuk menyimpan entitas data pengguna, kategori, manuskrip berita, dan opini pembaca.

---

##  3. Fungsi dan Fitur Proyek yang Dibangun

### A. Fitur Halaman Publik (Pembaca Biasa):
* **Tampilan Halaman Utama Responsif**
Halaman utama menampilkan berita utama serta daftar berita lainnya dalam bentuk grid yang tetap nyaman dilihat pada berbagai ukuran layar.
* **Filter Kategori Berita**
Pengguna dapat memilih kategori seperti Politik, Teknologi, Olahraga, Hiburan, dan Ekonomi untuk melihat berita sesuai kategori yang dipilih. Kategori yang sedang aktif akan ditandai agar lebih mudah dikenali.
* **Pencarian Berita**
Tersedia kolom pencarian pada bagian atas halaman yang dapat digunakan untuk mencari berita berdasarkan judul.
* **Halaman Detail Berita**
Pengguna dapat membaca isi berita secara lengkap pada halaman detail yang disusun agar mudah dibaca.
* **Profil Pengguna**
Setelah login, pengguna dapat melihat menu profil yang berisi pilihan untuk mengubah profil, logout, dan mengakses halaman admin apabila memiliki hak akses sebagai admin.
* **Edit Profil**
Pengguna dapat memperbarui informasi akun seperti nama, email, dan password melalui menu edit profil.
* **Komentar Berita**
Pengguna yang sudah login dapat memberikan komentar pada setiap berita. Sementara itu, pengunjung yang belum login akan diminta untuk masuk terlebih dahulu sebelum dapat mengirim komentar.

### B. Fitur Panel Kontrol (Ruang Kerja Admin):
* **Dashboard Admin**
Menampilkan ringkasan informasi seperti jumlah artikel, kategori, komentar, dan pengguna. Dashboard juga menampilkan daftar beberapa berita yang memiliki komentar terbanyak.
* **Kelola Komentar**
Admin dapat melihat komentar yang masuk dan menghapus komentar yang dianggap tidak sesuai.
* **Kelola Kategori**
Admin dapat menambah, mengubah, dan menghapus kategori berita. Slug akan dibuat secara otomatis untuk mempermudah pembuatan URL.
* **Kelola Berita**
Admin dapat menambahkan, mengedit, dan menghapus berita. Saat membuat berita, admin juga dapat mengunggah gambar thumbnail sebagai ilustrasi berita.
* **Data Awal (Seeder)**
Proyek menyediakan seeder untuk mengisi data awal seperti kategori dan beberapa contoh berita sehingga aplikasi dapat langsung digunakan untuk pengujian.

---

##  4. Kelebihan Proyek yang Dibangun
* **Backend dan Frontend dalam Satu Proyek**
Aplikasi dibangun menggunakan Laravel dengan backend API dan tampilan frontend yang saling terhubung dalam satu proyek sehingga proses pengembangan menjadi lebih sederhana dan mudah dipelajari.
* **Antarmuka yang Sederhana dan Mudah Digunakan**
Tampilan aplikasi dibuat sederhana, rapi, dan responsif sehingga pengguna dapat membaca berita serta mengakses berbagai fitur dengan lebih nyaman, baik melalui komputer maupun perangkat seluler.
* **Autentikasi Menggunakan Token**
Komunikasi antara frontend dan API menggunakan Bearer Token untuk mengakses data yang memerlukan proses login sehingga data pengguna lebih terjaga.
* **Interaksi Halaman Lebih Lancar**
Beberapa proses, seperti pencarian berita, menampilkan data, dan mengirim komentar, menggunakan Fetch API sehingga halaman tidak selalu perlu dimuat ulang.
* **Pengelolaan Data yang Mudah**
Admin dapat mengelola berita, kategori, dan komentar melalui halaman admin yang sederhana sehingga proses pengelolaan konten menjadi lebih praktis.
* **Struktur Kode yang Mudah Dikembangkan**
Kode aplikasi disusun secara terstruktur sehingga memudahkan proses pemeliharaan maupun penambahan fitur di kemudian hari.

---

##  5. Kekurangan Proyek yang Dibangun (Bug / Warning / Limitasi)
* **Fitur trending yang belum selesai**
* **Fitur Masih Sederhana**
Aplikasi masih berfokus pada fitur utama portal berita seperti pengelolaan berita, kategori, dan komentar. Beberapa fitur pendukung masih belum tersedia.
* **Belum Tersedia Reset Password**
Pengguna yang lupa password belum dapat melakukan reset melalui email sehingga perubahan password hanya dapat dilakukan setelah berhasil login.
* **Paginasi Admin Masih Dapat Dioptimalkan**
Halaman admin masih memuat banyak data sekaligus. Jika jumlah berita semakin banyak, performa halaman dapat menurun dan perlu dioptimalkan dengan paginasi atau pemuatan data secara bertahap.
* **Penyimpanan Gambar Masih Lokal**
Gambar berita masih disimpan pada penyimpanan lokal aplikasi sehingga belum menggunakan layanan penyimpanan cloud.
* **Validasi dan Keamanan Masih Dapat Dikembangkan**
Beberapa validasi input dan fitur keamanan masih dapat ditingkatkan agar aplikasi lebih aman dan nyaman digunakan.
* **Belum Ada Fitur Notifikasi**
Aplikasi belum menyediakan notifikasi untuk aktivitas seperti komentar baru atau perubahan data sehingga pengguna perlu memeriksa informasi secara manual.
* **Tampilan Masih Sederhana**
Antarmuka aplikasi dibuat sederhana dan mudah digunakan, namun masih dapat dikembangkan agar lebih menarik serta memberikan pengalaman pengguna yang lebih baik.

---

### Langkah Instalasi

#### 1. Masuk ke Folder Proyek

Buka terminal atau Command Prompt, lalu masuk ke folder proyek yang sudah di-*clone*.

```bash
cd nama-folder-proyek
```

#### 2. Install Dependency

Jalankan perintah berikut untuk menginstal seluruh dependency yang dibutuhkan oleh Laravel.

```bash
composer install
```

#### 3. Buat File `.env`

Salin file `.env.example` menjadi `.env`.

**Linux / macOS**

```bash
cp .env.example .env
```

**Windows (Command Prompt)**

```cmd
copy .env.example .env
```

**Windows (PowerShell)**

```powershell
Copy-Item .env.example .env
```

#### 4. Konfigurasi Database

Buat database baru, misalnya dengan nama **diinfo_db**.

Selanjutnya buka file `.env`, kemudian sesuaikan konfigurasi database seperti berikut.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_berita
DB_USERNAME=
DB_PASSWORD=
```

> Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan pengaturan database pada komputer Anda.

#### 5. Generate Application Key

Jalankan perintah berikut untuk membuat application key Laravel.

```bash
php artisan key:generate
```

#### 6. Jalankan Migrasi dan Seeder

Buat seluruh tabel database sekaligus mengisi data awal.

```bash
php artisan migrate:fresh --seed
```

> **Catatan:** Jika seeder mengunduh gambar dari internet, pastikan koneksi internet tersedia agar proses dapat berjalan dengan baik.

#### 7. Jalankan Aplikasi

Aktifkan server lokal Laravel.

```bash
php artisan serve
```

Setelah server berjalan, buka browser dan akses alamat berikut.

```text
http://localhost:8000
```

---

## AKUN DEMO
### Admin
- Email: admin@gmail.com
- Password: admin123

### User
- Email: user@gmail.com
- Password: user123

---

# KELOMPOK 5
## Kontributor :
- MOHAMAD RIZKI / 2305101011
- DELTA PUTRA BAGASKARA / 2305101001
- BAGAS HENDRY SUTIKNO / 2305101005
- ARRUDYA DEVANDRA / 2305101007
- ASTRID NABILA / 2305101009
- MARCHELLINO BRIAN / 2305101015
