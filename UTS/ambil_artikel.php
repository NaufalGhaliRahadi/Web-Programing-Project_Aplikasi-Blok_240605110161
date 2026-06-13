<?php
require_once 'koneksi.php';
header('Content-Type: application/json');
$sql = "SELECT a.id, a.judul, a.gambar, a.hari_tanggal, 
               CONCAT(p.nama_depan, ' ', p.nama_belakang) as penulis, 
               k.nama_kategori 
        FROM artikel a
        JOIN penulis p ON a.id_penulis = p.id
        JOIN kategori_artikel k ON a.id_kategori = k.id
        ORDER BY a.id DESC";
$res = $conn->query($sql);
$data = $res->fetch_all(MYSQLI_ASSOC);
echo json_encode(['status' => 'success', 'data' => $data]);
?>