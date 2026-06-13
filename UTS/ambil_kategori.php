<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$result = $conn->query("SELECT * FROM kategori_artikel ORDER BY id DESC");
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode(['status' => 'success', 'data' => $data]);
?>