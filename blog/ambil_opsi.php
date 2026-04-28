<?php
require_once 'koneksi.php';

// 1. Ambil Semua Kategori
$q_kategori = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori_artikel ORDER BY nama_kategori ASC");
$kategori = [];
while($row = mysqli_fetch_assoc($q_kategori)) {
    $row['nama_kategori'] = htmlspecialchars($row['nama_kategori']);
    $kategori[] = $row;
}

// 2. Ambil Semua Penulis
$q_penulis = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM penulis ORDER BY nama_depan ASC");
$penulis = [];
while($row = mysqli_fetch_assoc($q_penulis)) {
    $row['nama_depan'] = htmlspecialchars($row['nama_depan']);
    $row['nama_belakang'] = htmlspecialchars($row['nama_belakang']);
    $penulis[] = $row;
}

// Kembalikan dua data sekaligus dalam satu JSON
echo json_encode([
    'kategori' => $kategori,
    'penulis' => $penulis
]);

mysqli_close($conn);
?>