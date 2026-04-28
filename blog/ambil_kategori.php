<?php
require_once 'koneksi.php';

// Menyiapkan query untuk mengambil semua data kategori [cite: 1989-1990]
// Kita urutkan berdasarkan ID DESC agar data terbaru muncul di atas [cite: 2007]
$query = "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY id DESC";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

$data = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        'id' => $baris['id'],
        // Sanitasi output dengan htmlspecialchars [cite: 3029-3031]
        'nama_kategori' => htmlspecialchars($baris['nama_kategori']),
        'keterangan' => htmlspecialchars($baris['keterangan'])
    ];
}

// Mengirimkan data dalam format JSON [cite: 2004]
echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>