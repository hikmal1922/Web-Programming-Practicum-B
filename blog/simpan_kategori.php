<?php
require_once 'koneksi.php';

// Menangkap data dari FormData JavaScript [cite: 1436-1440]
$nama = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

// Validasi: Pastikan semua kolom diisi [cite: 1952]
if (empty($nama) || empty($keterangan)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Semua kolom harus diisi']);
    exit;
}

// Gunakan Prepared Statement untuk keamanan [cite: 1953-1954]
$query = "INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $nama, $keterangan);

if (mysqli_stmt_execute($stmt)) {
    // Jika sukses, kirim status sukses dalam format JSON [cite: 1573-1575]
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data kategori berhasil disimpan!']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menyimpan data: ' . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>