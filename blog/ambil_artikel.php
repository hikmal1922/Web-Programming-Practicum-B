<?php
require_once 'koneksi.php';

// Query JOIN untuk mengambil data artikel lengkap dengan nama kategori dan penulis
$query = "SELECT a.*, p.nama_depan, p.nama_belakang, k.nama_kategori 
          FROM artikel a
          JOIN penulis p ON a.id_penulis = p.id
          JOIN kategori_artikel k ON a.id_kategori = k.id
          ORDER BY a.id DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

$data = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        'id' => $baris['id'],
        'judul' => htmlspecialchars($baris['judul']),
        'isi' => htmlspecialchars($baris['isi']),
        'gambar' => htmlspecialchars($baris['gambar']),
        'nama_kategori' => htmlspecialchars($baris['nama_kategori']),
        'nama_penulis' => htmlspecialchars($baris['nama_depan'] . " " . $baris['nama_belakang']),
        'hari_tanggal' => htmlspecialchars($baris['hari_tanggal'])
    ];
}

echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>