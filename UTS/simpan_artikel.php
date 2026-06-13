<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

$judul = $_POST['judul'] ?? '';
$id_penulis = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$isi = $_POST['isi'] ?? '';

if (empty($judul) || empty($id_penulis) || empty($id_kategori) || empty($isi)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
    exit;
}

// Upload gambar wajib
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Gambar artikel wajib diupload']);
    exit;
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['gambar']['tmp_name']);
finfo_close($finfo);
$allowed = ['image/jpeg', 'image/png', 'image/jpg'];
if (!in_array($mime, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Tipe file gambar tidak diizinkan']);
    exit;
}
if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Ukuran gambar maksimal 2MB']);
    exit;
}
$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$gambar_name = time() . '_' . uniqid() . '.' . $ext;
move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar_name);

// Format hari_tanggal
$hariIndo = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$now = new DateTime();
$hari_tanggal = $hariIndo[(int)$now->format('w')] . ', ' . $now->format('j') . ' ' . $bulanIndo[(int)$now->format('n')] . ' ' . $now->format('Y') . ' | ' . $now->format('H:i');

$stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("iissss", $id_penulis, $id_kategori, $judul, $isi, $gambar_name, $hari_tanggal);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>