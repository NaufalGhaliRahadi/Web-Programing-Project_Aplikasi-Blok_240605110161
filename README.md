# Web Programming Project - Laporan UTS & UAS

**Nama:** Naufal Ghali Rahadi  
**NIM:** [240605110161]  
**Mata Kuliah:** Pemrograman Web  
**Semester:** Genap 2025/2026  
**Dosen:** A’la Syauqi M.Kom.
**Link Youtube** https://youtu.be/3VygEuoRTsY

---

## Daftar Isi

1. [Pendahuluan](#1-pendahuluan)
2. [Landasan Teori](#2-landasan-teori)
3. [Analisis dan Perancangan](#3-analisis-dan-perancangan)
4. [Implementasi UTS (Vanilla PHP)](#4-implementasi-uts-vanilla-php)
5. [Implementasi UAS (Laravel)](#5-implementasi-uas-laravel)
6. [Pengujian](#6-pengujian)
7. [Kesimpulan](#7-kesimpulan)


---

## 1. Pendahuluan

### 1.1 Latar Belakang

Aplikasi web CMS (Content Management System) diperlukan untuk mengelola konten blog secara efisien. Pada UTS, aplikasi dibangun dengan PHP native (tanpa framework) untuk memahami konsep dasar CRUD, keamanan, dan JavaScript asynchronous. Pada UAS, aplikasi dikembangkan lebih lanjut menggunakan framework Laravel dengan menambahkan halaman publik yang dapat diakses tanpa login.

### 1.2 Tujuan

- Membangun CMS dengan operasi CRUD asynchronous (UTS)
- Menerapkan keamanan (prepared statements, password hashing, validasi file)
- Mengembangkan aplikasi blog lengkap dengan halaman publik menggunakan Laravel (UAS)
- Menampilkan 5 artikel terbaru, widget kategori, detail artikel, dan 5 artikel terkait

### 1.3 Ruang Lingkup

Proyek mencakup tiga entitas: Penulis, Kategori Artikel, dan Artikel. UAS menambahkan halaman publik (beranda, filter kategori, detail artikel, artikel terkait).

---

## 2. Landasan Teori

- **PHP & MySQL**: Bahasa server-side dan database relasional. Prepared statements mencegah SQL injection.
- **Laravel 11**: Framework MVC dengan fitur routing, Eloquent ORM, Blade, autentikasi.
- **Bootstrap 5**: Framework CSS untuk tampilan responsif.
- **Fetch API**: JavaScript untuk request asynchronous tanpa reload.
- **Arsitektur MVC**: Model (database), View (tampilan), Controller (logika).

---

## 3. Analisis dan Perancangan

### 3.1 Kebutuhan Fungsional

| Kode | Kebutuhan |
|------|-----------|
| F01 | CRUD Penulis (tambah, lihat, edit, hapus) |
| F02 | CRUD Kategori |
| F03 | CRUD Artikel (upload gambar) |
| F04 | Password dienkripsi (bcrypt) |
| F05 | Validasi file gambar |
| F06 | Notifikasi toast (UTS) |
| F07 | Dark mode (UTS) |
| F08 | Autentikasi login/register (UAS) |
| F09 | Halaman publik: 5 artikel terbaru + widget kategori (UAS) |
| F10 | Filter artikel berdasarkan kategori (UAS) |
| F11 | Detail artikel + 5 artikel terkait (UAS) |

### 3.2 Struktur Database (db_blog)

**Tabel `penulis`**

| Field | Tipe | Keterangan |
|-------|------|-------------|
| id | INT | Primary Key, Auto Increment |
| nama_depan | VARCHAR(100) | |
| nama_belakang | VARCHAR(100) | |
| user_name | VARCHAR(50) | Unique |
| password | VARCHAR(255) | Hash bcrypt |
| foto | VARCHAR(255) | Default 'default.png' |

**Tabel `kategori_artikel`**

| Field | Tipe | Keterangan |
|-------|------|-------------|
| id | INT | PK |
| nama_kategori | VARCHAR(100) | Unique |
| keterangan | TEXT | |

**Tabel `artikel`**

| Field | Tipe | Keterangan |
|-------|------|-------------|
| id | INT | PK |
| id_penulis | INT | FK ke penulis(id) |
| id_kategori | INT | FK ke kategori_artikel(id) |
| judul | VARCHAR(255) | |
| isi | TEXT | |
| gambar | VARCHAR(255) | |
| hari_tanggal | VARCHAR(50) | Format tgl Indonesia |

> Relasi: `ON DELETE RESTRICT` – tidak bisa hapus penulis/kategori jika masih memiliki artikel.

---

## 4. Implementasi UTS (Vanilla PHP)

### 4.1 Struktur Folder
```
UTS/
├── index.php # Halaman utama (UI + JS)
├── koneksi.php # Koneksi database
├── db_blog.sql # Skema database
├── ambil_penulis.php
├── ambil_satu_penulis.php
├── simpan_penulis.php
├── update_penulis.php
├── hapus_penulis.php
├── ambil_kategori.php
├── ambil_satu_kategori.php
├── simpan_kategori.php
├── update_kategori.php
├── hapus_kategori.php
├── ambil_artikel.php
├── ambil_satu_artikel.php
├── simpan_artikel.php
├── update_artikel.php
├── hapus_artikel.php
├── uploads_penulis/
│ ├── .htaccess
│ └── default.png
└── uploads_artikel/
└── .htaccess
```
---

### 4.2 Contoh Kode (Simpan Penulis)

```php
// simpan_penulis.php
include 'koneksi.php';
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$foto = 'default.png';
if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
    finfo_close($finfo);
    if (in_array($mime, ['image/jpeg','image/png'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads_penulis/$foto");
    }
}

$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $foto);
$stmt->execute();
echo json_encode(['sukses' => true]);
```
---
### 4.3 Fitur Tambahan UTS
Dark Mode: Toggle dengan JavaScript, simpan ke localStorage.

Toast Notification: Notifikasi sukses/gagal.

Fetch API: Semua operasi CRUD tanpa reload halaman.

---

## 5. Implementasi UAS (Laravel)
### 5.1 Struktur Proyek (Laravel 11)
```
   UAS/
├── app/
│   ├── Http/Controllers/
│   │   ├── ArtikelController.php
│   │   ├── PenulisController.php
│   │   ├── KategoriArtikelController.php
│   │   ├── LoginController.php
│   │   ├── RegisterController.php
│   │   ├── DashboardController.php
│   │   ├── PublicController.php
│   │   └── PublicArticleController.php
│   └── Models/
│       ├── User.php
│       ├── Artikel.php
│       ├── Penulis.php
│       └── KategoriArtikel.php
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php (CMS)
│   │   └── public.blade.php (publik)
│   ├── artikel/, penulis/, kategori/, dashboard/, login/, auth/
│   └── public/
│       ├── home.blade.php
│       ├── show.blade.php
│       ├── categories.blade.php
│       └── about.blade.php
├── routes/web.php
├── storage/app/public/
│   ├── foto/
│   └── gambar/
├── .env.example
└── composer.json
```
---
### 5.2 Autentikasi (Login, Register)
Model User.php disesuaikan dengan tabel penulis:
```
protected $table = 'penulis';
public $timestamps = false;
```
LoginController:
```
$kredensial = ['user_name' => $request->user_name, 'password' => $request->password];
if (Auth::attempt($kredensial)) {
    $request->session()->regenerate();
    $request->session()->put('waktu_login', now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM Y | HH:mm'));
    return redirect()->intended('/dashboard');
}
```
RegisterController menggunakan bcrypt() untuk password.
---
### 5.3 CRUD dengan Resource Controller
Contoh ArtikelController@store:

```
$file = $request->file('gambar');
$namaFile = time().'_'.$file->getClientOriginalName();
$file->storeAs('gambar', $namaFile, 'public');
Artikel::create([
    'judul' => $request->judul,
    'isi' => $request->isi,
    'id_penulis' => Auth::id(),
    'id_kategori' => $request->id_kategori,
    'gambar' => $namaFile,
    'hari_tanggal' => now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM Y | HH:mm')
]);
```

Route resource (dalam grup middleware('auth')):
```
Route::resource('artikel', ArtikelController::class);
```
---
### 5.4 Halaman Publik
PublicController:

home(): 5 artikel terbaru + widget kategori

filterByCategory($id): artikel berdasarkan kategori

categories(): daftar semua kategori

about(): halaman tentang

PublicArticleController:

show($id): detail artikel + 5 artikel terkait (kategori sama)

View public/home.blade.php menampilkan artikel dalam card dengan gambar thumbnail, meta info, tombol baca.

View public/show.blade.php menampilkan breadcrumb, isi artikel, widget artikel terkait (dengan gambar kecil, judul, tanggal) dan widget kategori.

### 5.5 Layout dan Tema
Layout CMS (layouts/app.blade.php): sidebar gelap, flash message.

Layout publik (layouts/public.blade.php): header gradien biru, menu (Beranda, Artikel, Kategori, Tentang), tombol Login/Dashboard (berubah sesuai status login), footer.

Semua menggunakan Bootstrap 5 dan Font Awesome 6.

---
## 6. Pengujian
### 6.1 Skenario Uji UTS

|No	| Skenario |	Hasil    |
|---|----------|-------------|
|1	|Tambah penulis dengan upload foto |Berhasil, foto tersimpan|
|2	|Edit penulis (ganti foto)|	Foto lama terhapus, foto baru tampil|
|3	|Hapus penulis tanpa artikel|	Berhasil|
|4	|Hapus penulis yang punya artikel|	Gagal (toast error)|
|5	|Tambah kategori|	Berhasil|
|6	|Hapus kategori yang dipakai artikel|	Gagal|
|7	|Tambah artikel dengan gambar|	Berhasil|
|8	|Edit artikel (ganti gambar)|	Gambar lama terhapus|
|9	|Hapus artikel|	Berhasil|
|10	|Dark mode toggle|	Tema berubah, tersimpan|
|11	|Semua operasi async|	Fetch API bekerja, toast muncul|

## 6.2 Skenario Uji UAS

| No | Skenario | Hasil |
|----|----------|-------|
| 1 | Registrasi akun baru | Berhasil, redirect login |
| 2 | Login valid | Masuk dashboard, waktu login tampil |
| 3 | Tambah kategori | Berhasil |
| 4 | Edit kategori | Berhasil |
| 5 | Hapus kategori tanpa artikel | Berhasil |
| 6 | Hapus kategori yang dipakai artikel | Gagal (pesan error) |
| 7 | Tambah penulis dengan foto | Foto tersimpan di storage |
| 8 | Hapus penulis tanpa artikel | Berhasil, foto ikut terhapus |
| 9 | Tambah artikel dengan gambar | Berhasil |
| 10 | Edit artikel (ganti gambar) | Gambar lama terhapus |
| 11 | Hapus artikel | Berhasil |
| 12 | Halaman utama publik | Menampilkan 5 artikel terbaru + widget kategori |
| 13 | Filter kategori | Artikel tersaring |
| 14 | Detail artikel + artikel terkait | Tampil lengkap, 5 artikel terkait |
| 15 | Klik artikel terkait | Pindah ke detail lain |
| 16 | Tombol kembali ke beranda | Berfungsi |
| 17 | Logout | Kembali ke login |

## 6.3 Hasil Pengujian
Semua skenario berhasil. Aplikasi UTS dan UAS berfungsi tanpa error, memenuhi semua spesifikasi.
---
## 7. Kesimpulan
### 7.1 Kesimpulan
- UTS berhasil membangun CMS dengan PHP native, CRUD asynchronous, dark mode, dan keamanan dasar.

- UAS berhasil mengembangkan aplikasi blog dengan Laravel, mencakup autentikasi, CRUD, dan halaman publik (5 artikel terbaru, filter kategori, detail + 5 artikel terkait).

- Semua fitur UAS terpenuhi: halaman publik tanpa login, controller terpisah, layout sendiri, tampilan bersih dan responsif.

---
***
---
# Aplikasi Blog - 240605110161

**Nama Lengkap:** Naufal Ghali Rahadi  
**NIM:** 240605110161  
**Mata Kuliah:** Pemrograman Web  
**Semester:** Genap 2025/2026  
**Dosen:** A’la Syauqi M.Kom.
**Link Youtube** https://youtu.be/3VygEuoRTsY

---

## 📌 Deskripsi Singkat Aplikasi

Aplikasi Blog ini merupakan sistem manajemen konten (CMS) yang dibangun dengan **Laravel 11** sebagai proyek **UAS**. Aplikasi ini memiliki dua bagian:

1. **Halaman Admin (CMS)** – hanya dapat diakses setelah login. Admin dapat mengelola:
   - **Artikel** (tambah, edit, hapus, upload gambar)
   - **Penulis** (tambah, edit, hapus, upload foto profil)
   - **Kategori artikel** (tambah, edit, hapus)

2. **Halaman Publik** – dapat diakses oleh siapa saja tanpa login, menampilkan:
   - **5 artikel terbaru** di halaman utama
   - **Widget kategori** di samping untuk menyaring artikel
   - **Halaman detail artikel** dengan isi lengkap dan **5 artikel terkait** dari kategori yang sama

Aplikasi ini memenuhi seluruh spesifikasi Ujian Akhir Semester (UAS) Pemrograman Web.

> Proyek ini merupakan kelanjutan dari **UTS** (Vanilla PHP) yang sebelumnya telah membangun CMS dengan PHP native. Laporan lengkap mencakup kedua proyek.

---

## 🚀 Langkah-langkah Menjalankan Aplikasi Secara Lokal (UAS Laravel)

### Prasyarat
- PHP 8.2 atau lebih baru
- Composer
- MySQL (Laragon / XAMPP)
- Git (opsional)

### 1. Clone repositori
```bash
git clone https://github.com/NaufalGhalRahadi/aplikasi-blog-240605110161.git
cd aplikasi-blog-240605110161/UAS   # jika struktur repo berisi folder UAS
Atau jika langsung di root:

bash
git clone https://github.com/NaufalGhalRahadi/aplikasi-blog-240605110161.git
cd aplikasi-blog-240605110161
```
### 2. Install dependensi PHP
```bash
composer install
```
### 3. Konfigurasi environment
Copy file .env.example menjadi .env

```bash
cp .env.example .env   # Linux/Mac
copy .env.example .env # Windows
Buka file .env dan sesuaikan konfigurasi database:

env
DB_DATABASE=db_blog
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Generate application key
```bash
php artisan key:generate
```
### 5. Jalankan migrasi (tabel sessions)
```bash
php artisan session:table
php artisan migrate
```
### 6. Buat symbolic link storage
```bash
php artisan storage:link
```
### 7. Buat folder upload dan file default
- Pastikan folder storage/app/public/foto dan storage/app/public/gambar sudah ada (buat jika belum).

- Letakkan file default.png (foto profil default) di storage/app/public/foto/.

### 8. (Opsional) Buat akun penulis pertama
```bash
php artisan tinker
php
App\Models\Penulis::create([
    'nama_depan' => 'Admin',
    'nama_belakang' => 'Sistem',
    'user_name' => 'admin',
    'password' => bcrypt('12345678'),
    'foto' => 'default.png'
]);
Ketik exit untuk keluar.
```
### 9. Jalankan server development
```bash
php artisan serve
```
### 10. Akses aplikasi
- Halaman publik: http://localhost:8000

- Halaman login admin: http://localhost:8000/login

- Username: admin

- Password: 12345678 (atau sesuai akun yang dibuat)

Catatan: Pastikan database db_blog sudah ada dengan tabel penulis, kategori_artikel, artikel (dari UTS). Jika belum, import file db_blog.sql yang tersedia di folder UTS/ repositori ini.

