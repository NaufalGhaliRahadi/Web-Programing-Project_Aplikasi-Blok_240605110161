<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$res = $conn->query("SELECT id, CONCAT(nama_depan, ' ', nama_belakang) as nama_lengkap FROM penulis ORDER BY nama_lengkap");
$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['status' => 'success', 'data' => $data]);
?>