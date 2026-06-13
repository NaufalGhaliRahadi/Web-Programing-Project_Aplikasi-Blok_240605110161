# Sistem Manajemen Blog (CMS) - UTS Pemrograman Web

**Nama:** [Nama Lengkap Anda]  
**NIM:** [NIM Anda]  
**Mata Kuliah:** Pemrograman Web  
**Semester:** Genap 2025/2026

---

## 📌 Deskripsi Proyek

Aplikasi web Content Management System (CMS) berbasis **PHP & MySQL** untuk mengelola data **Penulis**, **Artikel**, dan **Kategori Artikel** secara **asynchronous** menggunakan **Fetch API**. Seluruh operasi CRUD berjalan tanpa reload halaman, dilengkapi dengan **Dark Mode** dan notifikasi **Toast**.

Proyek ini merupakan tugas **Ujian Tengah Semester (UTS)** yang mengimplementasikan konsep:

- PHP murni (tanpa framework) dengan arsitektur terpisah (file per operasi)
- MySQL dengan prepared statements (PDO atau mysqli)
- JavaScript modern (Fetch API, localStorage, event handling)
- Responsive design & tema gelap/terang

---

## ✨ Fitur Utama

### 📝 Kelola Penulis (CRUD)
- **Tambah** penulis baru dengan nama, username, password, dan foto profil
- **Lihat** seluruh daftar penulis dalam format tabel
- **Edit** data penulis melalui modal form
- **Hapus** penulis dengan konfirmasi — penulis yang masih memiliki artikel **tidak dapat dihapus**
- **Password** dienkripsi menggunakan `password_hash()` (BCRYPT)
- **Foto profil** menggunakan `default.png` jika tidak diunggah

### 📄 Kelola Artikel (CRUD)
- **Tambah** artikel dengan judul, isi, penulis, kategori, dan gambar
- **Lihat** seluruh daftar artikel beserta info tanggal, penulis, dan kategori
- **Edit** artikel dengan perbarui gambar (opsional)
- **Hapus** artikel beserta file gambar fisik dari server
- **Kolom `hari_tanggal`** diisi otomatis dari server PHP (format: `Senin, 13 Apr 2025 | 15:17`, timezone `Asia/Jakarta`)
- **Dropdown penulis & kategori** diisi dinamis dari database

### 🏷️ Kelola Kategori Artikel (CRUD)
- **Tambah**, **edit**, dan **hapus** kategori
- **Kategori yang masih memiliki artikel tidak dapat dihapus**

---

## ✨ Fitur Tambahan

| Fitur | Keterangan |
|-------|-------------|
| **Dark Mode** | Toggle tema gelap/terang yang elegan, pilihan disimpan di `localStorage` |
| **Responsive Design** | Tampilan optimal di desktop & mobile dengan Navigation Drawer |
| **Async / No Reload** | Seluruh operasi CRUD berjalan menggunakan Fetch API tanpa reload halaman |
| **Toast Notification** | Notifikasi sukses/gagal yang muncul otomatis di pojok layar |
| **Konfirmasi Hapus** | Modal konfirmasi sebelum data dihapus |

---

## 🔒 Keamanan

- **Prepared Statements** (`mysqli` atau `PDO`) untuk seluruh operasi database — mencegah SQL Injection
- **Validasi tipe file menggunakan `finfo`** (bukan hanya `$_FILES['type']`)
- **Enkripsi password menggunakan `PASSWORD_BCRYPT`**
- **Batasan ukuran file unggahan maksimal 2 MB** (default) atau 20 MB (bisa disesuaikan)
- **Folder `uploads_penulis/` dan `uploads_artikel/` dilindungi oleh `.htaccess`** untuk mencegah eksekusi PHP

---

## 🗄️ Struktur Database

Database: `db_blog`

```sql
-- Tabel penulis
CREATE TABLE penulis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_depan VARCHAR(100) NOT NULL,
    nama_belakang VARCHAR(100) NOT NULL,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL
) ENGINE=InnoDB CHARSET=utf8mb4;

-- Tabel kategori_artikel
CREATE TABLE kategori_artikel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL UNIQUE,
    keterangan TEXT
) ENGINE=InnoDB CHARSET=utf8mb4;

-- Tabel artikel (berelasi ke penulis & kategori)
CREATE TABLE artikel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_penulis INT NOT NULL,
    id_kategori INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    hari_tanggal VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_penulis) REFERENCES penulis(id) ON DELETE RESTRICT,
    FOREIGN KEY (id_kategori) REFERENCES kategori_artikel(id) ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8mb4;

```
## 📁 Struktur Folder
```

01-UTS-VanillaPHP/
├── index.php                     # Halaman utama (UI + JavaScript)
├── koneksi.php                   # Koneksi ke database MySQL
├── db_blog.sql                   # Skrip SQL untuk membuat database & tabel
├── docker-compose.yml            # Konfigurasi Docker
├── Dockerfile                    # Docker image
├── ambil_penulis.php             # [READ] Daftar penulis
├── ambil_satu_penulis.php        # [READ] Detail satu penulis
├── simpan_penulis.php            # [CREATE] Tambah penulis
├── update_penulis.php            # [UPDATE] Edit penulis
├── hapus_penulis.php             # [DELETE] Hapus penulis
├── ambil_kategori.php            # [READ] Daftar kategori
├── ambil_satu_kategori.php       # [READ] Detail satu kategori
├── simpan_kategori.php           # [CREATE] Tambah kategori
├── update_kategori.php           # [UPDATE] Edit kategori
├── hapus_kategori.php            # [DELETE] Hapus kategori
├── ambil_artikel.php             # [READ] Daftar artikel
├── ambil_satu_artikel.php        # [READ] Detail satu artikel
├── simpan_artikel.php            # [CREATE] Tambah artikel
├── update_artikel.php            # [UPDATE] Edit artikel
├── hapus_artikel.php             # [DELETE] Hapus artikel
├── uploads_penulis/              # Folder foto profil penulis
│   ├── .htaccess                 # Proteksi eksekusi PHP
│   └── default.png               # Foto profil default
└── uploads_artikel/              # Folder gambar artikel
    └── .htaccess                 # Proteksi eksekusi PHP
