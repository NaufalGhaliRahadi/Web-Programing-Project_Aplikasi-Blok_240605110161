<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_POST['id'] ?? 0;
$nama = $_POST['nama_kategori'] ?? '';
$ket = $_POST['keterangan'] ?? '';
$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
$stmt->bind_param("ssi", $nama, $ket, $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>