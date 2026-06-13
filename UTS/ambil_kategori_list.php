<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$res = $conn->query("SELECT id, nama_kategori FROM kategori_artikel ORDER BY nama_kategori");
$data = $res->fetch_all(MYSQLI_ASSOC);
echo json_encode(['status' => 'success', 'data' => $data]);
?>