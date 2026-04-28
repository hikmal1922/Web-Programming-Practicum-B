<?php
require_once 'koneksi.php';

// Meminta data penulis dari database, diurutkan dari yang terbaru
$query = "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC";
$stmt = mysqli_prepare($conn, $query);

// Eksekusi query
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

$data = [];
while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = [
        'id' => $baris['id'],
        // Sanitasi output untuk keamanan (Syarat Mutlak UTS) [cite: 3364]
        'nama_depan' => htmlspecialchars($baris['nama_depan']),
        'nama_belakang' => htmlspecialchars($baris['nama_belakang']),
        'user_name' => htmlspecialchars($baris['user_name']),
        // Cek jika foto kosong, berikan nama default.png
        'foto' => empty($baris['foto']) ? 'default.png' : htmlspecialchars($baris['foto'])
    ];
}

// Kembalikan dalam bentuk JSON ke JavaScript
echo json_encode($data);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>