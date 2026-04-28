<?php
require_once 'koneksi.php';

$id = $_POST['id'];

// 1. Ambil nama file foto dari database SEBELUM data dihapus [cite: 2766-2768, 2806]
$query_foto = "SELECT foto FROM penulis WHERE id = ?";
$stmt_foto = mysqli_prepare($conn, $query_foto);
mysqli_stmt_bind_param($stmt_foto, "i", $id);
mysqli_stmt_execute($stmt_foto);
$hasil_foto = mysqli_stmt_get_result($stmt_foto);
$data_foto = mysqli_fetch_assoc($hasil_foto);

$foto_dihapus = $data_foto['foto'];
mysqli_stmt_close($stmt_foto);

// 2. Siapkan eksekusi Hapus Data Penulis
$query_hapus = "DELETE FROM penulis WHERE id = ?";
$stmt_hapus = mysqli_prepare($conn, $query_hapus);
mysqli_stmt_bind_param($stmt_hapus, "i", $id);

// 3. Gunakan Try-Catch untuk menangani relasi database
try {
    mysqli_stmt_execute($stmt_hapus);
    
    if (mysqli_stmt_affected_rows($stmt_hapus) > 0) {
        // Hapus file foto dari folder uploads_penulis jika bukan gambar default [cite: 2789-2794, 2808-2809]
        if ($foto_dihapus !== 'default.png' && file_exists('uploads_penulis/' . $foto_dihapus)) {
            unlink('uploads_penulis/' . $foto_dihapus);
        }
        
        echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis dan foto berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Data tidak ditemukan.']);
    }
} catch (mysqli_sql_exception $e) {
    // Menangkap error dari ON DELETE RESTRICT 
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal! Penulis tidak dapat dihapus karena masih memiliki artikel.']);
}

mysqli_stmt_close($stmt_hapus);
mysqli_close($conn);
?>