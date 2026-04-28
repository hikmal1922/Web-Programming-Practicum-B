<?php
require_once 'koneksi.php';

// Menangkap data dari form edit
$id = $_POST['id'];
$nama = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

// Validasi input
if (empty($nama) || empty($keterangan)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Semua kolom harus diisi']);
    exit;
}

// Gunakan Prepared Statement untuk operasi UPDATE [cite: 350-353]
$query = "UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

// "ssi" berarti String, String, Integer
mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data kategori berhasil diperbarui!']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal memperbarui data: ' . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>