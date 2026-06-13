<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT id, CONCAT(nama_depan, ' ', nama_belakang) as nama, user_name, foto FROM penulis ORDER BY id DESC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['status' => 'success', 'data' => $data]);
?>