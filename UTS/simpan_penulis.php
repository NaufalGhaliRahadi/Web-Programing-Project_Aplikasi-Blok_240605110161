<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$nama_depan = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$password = $_POST['password'] ?? '';
$foto_name = 'default.png';

if (empty($nama_depan) || empty($nama_belakang) || empty($user_name) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Cek username unik
$cek = $conn->prepare("SELECT id FROM penulis WHERE user_name = ?");
$cek->bind_param("s", $user_name);
$cek->execute();
if ($cek->get_result()->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan']);
    exit;
}

// Upload foto jika ada
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan (Hanya JPG/PNG)']);
        exit;
    }
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran maksimal 2MB']);
        exit;
    }
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_name = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto_name);
}

$hashed = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $hashed, $foto_name);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal: ' . $stmt->error]);
}
?>