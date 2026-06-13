<?php
$host = 'localhost';
$user = 'root';
$pass = 'Lost.1311';
$db   = 'db_blog';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Koneksi gagal: ' . $conn->connect_error]));
}
$conn->set_charset("utf8mb4");
?>