<?php
require_once 'koneksi.php';

// Menangkap ID yang dikirim oleh JavaScript
$id = $_POST['id'];

// Query untuk mengambil satu baris data berdasarkan ID [cite: 350-353]
$query = "SELECT * FROM kategori_artikel WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

// "i" berarti tipe data ID adalah integer
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

// Mengirimkan data tunggal ini kembali dalam format JSON
echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>