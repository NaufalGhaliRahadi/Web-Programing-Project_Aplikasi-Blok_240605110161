<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_POST['id'] ?? 0;
$stmt = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$gbr = $stmt->get_result()->fetch_assoc();
if ($gbr && file_exists('uploads_artikel/' . $gbr['gambar'])) {
    unlink('uploads_artikel/' . $gbr['gambar']);
}
$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal hapus artikel']);
}
?>