<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$nama = $_POST['nama_kategori'] ?? '';
$ket = $_POST['keterangan'] ?? '';
if (empty($nama)) {
    echo json_encode(['status' => 'error', 'message' => 'Nama kategori wajib']);
    exit;
}
$stmt = $conn->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $ket);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>