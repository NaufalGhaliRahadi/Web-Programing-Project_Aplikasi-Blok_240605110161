<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_POST['id'] ?? 0;

// Cek apakah punya artikel
$cek = $conn->prepare("SELECT id FROM artikel WHERE id_penulis = ?");
$cek->bind_param("i", $id);
$cek->execute();
if ($cek->get_result()->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Penulis masih memiliki artikel, tidak bisa dihapus']);
    exit;
}
$stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal hapus']);
}
?>