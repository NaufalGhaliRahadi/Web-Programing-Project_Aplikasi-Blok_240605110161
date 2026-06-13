<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$id = $_POST['id'] ?? 0;
$nama_depan = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$old = $stmt->get_result()->fetch_assoc();
$foto_name = $old['foto'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan']);
        exit;
    }
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran maksimal 2MB']);
        exit;
    }
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_name = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto_name);
    if ($old['foto'] !== 'default.png' && file_exists('uploads_penulis/' . $old['foto'])) {
        unlink('uploads_penulis/' . $old['foto']);
    }
}

if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $user_name, $hashed, $foto_name, $id);
} else {
    $stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama_depan, $nama_belakang, $user_name, $foto_name, $id);
}
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>