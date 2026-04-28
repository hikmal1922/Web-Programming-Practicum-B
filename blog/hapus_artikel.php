<?php
require_once 'koneksi.php';

$id = $_POST['id'];

// Ambil nama file gambar terlebih dahulu
$query_lama = "SELECT gambar FROM artikel WHERE id = ?";
$stmt_lama = mysqli_prepare($conn, $query_lama);
mysqli_stmt_bind_param($stmt_lama, "i", $id);
mysqli_stmt_execute($stmt_lama);
$hasil_lama = mysqli_stmt_get_result($stmt_lama);
$data_lama = mysqli_fetch_assoc($hasil_lama);
$gambar_lama = $data_lama['gambar'];
mysqli_stmt_close($stmt_lama);

$query_hapus = "DELETE FROM artikel WHERE id = ?";
$stmt_hapus = mysqli_prepare($conn, $query_hapus);
mysqli_stmt_bind_param($stmt_hapus, "i", $id);

if (mysqli_stmt_execute($stmt_hapus)) {
    // Hapus gambar fisik dari folder
    if (file_exists('uploads_artikel/' . $gambar_lama)) {
        unlink('uploads_artikel/' . $gambar_lama);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel dan gambar berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal menghapus artikel.']);
}

mysqli_stmt_close($stmt_hapus);
mysqli_close($conn);
?>