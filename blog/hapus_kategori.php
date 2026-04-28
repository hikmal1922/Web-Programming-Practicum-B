<?php
require_once 'koneksi.php';

$id = $_POST['id'];

// Gunakan Prepared Statement untuk operasi DELETE
$query = "DELETE FROM kategori_artikel WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

// Kita gunakan blok try-catch untuk menangkap error constraint ON DELETE RESTRICT
try {
    mysqli_stmt_execute($stmt);
    
    // Cek apakah ada baris yang berhasil dihapus
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'sukses', 'pesan' => 'Data kategori berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Data tidak ditemukan.']);
    }
} catch (mysqli_sql_exception $e) {
    // Jika penghapusan ditolak oleh database karena kategori masih dipakai di tabel artikel
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal! Kategori tidak dapat dihapus karena masih memiliki artikel.']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>