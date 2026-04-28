<?php
require_once 'koneksi.php';

$id = $_POST['id'];

// Wajib pakai prepared statement
$query = "SELECT * FROM artikel WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

// Balas ke JavaScript pakai JSON
echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
