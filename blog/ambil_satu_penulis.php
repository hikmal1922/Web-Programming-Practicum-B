<?php
require_once 'koneksi.php';

$id = $_POST['id'];

// Ambil data penulis berdasarkan ID (password tidak perlu ditarik demi keamanan)
$query = "SELECT id, nama_depan, nama_belakang, user_name FROM penulis WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>