<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_POST['id'] ?? 0;
$cek = $conn->prepare("SELECT id FROM artikel WHERE id_kategori = ?");
$cek->bind_param("i", $id);
$cek->execute();
if ($cek->get_result()->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Kategori masih dipakai artikel, tidak bisa hapus']);
    exit;
}
$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal hapus']);
}
?>