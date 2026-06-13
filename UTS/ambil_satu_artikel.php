<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Artikel tidak ditemukan']);
}
?>