<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_POST['id'] ?? 0;
$judul = $_POST['judul'] ?? '';
$id_penulis = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$isi = $_POST['isi'] ?? '';

$stmt = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$old = $stmt->get_result()->fetch_assoc();
$gambar_name = $old['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['gambar']['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, ['image/jpeg','image/png','image/jpg'])) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe gambar tidak valid']);
        exit;
    }
    if ($_FILES['gambar']['size'] > 2*1024*1024) {
        echo json_encode(['status' => 'error', 'message' => 'Maksimal 2MB']);
        exit;
    }
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar_name = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar_name);
    if (file_exists('uploads_artikel/' . $old['gambar'])) {
        unlink('uploads_artikel/' . $old['gambar']);
    }
}

$stmt = $conn->prepare("UPDATE artikel SET judul=?, id_penulis=?, id_kategori=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param("siissi", $judul, $id_penulis, $id_kategori, $isi, $gambar_name, $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel diperbarui']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>