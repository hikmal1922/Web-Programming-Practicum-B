<?php
require_once 'koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul_artikel'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi_artikel'];

// Ambil nama gambar lama dari database
$query_lama = "SELECT gambar FROM artikel WHERE id = ?";
$stmt_lama = mysqli_prepare($conn, $query_lama);
mysqli_stmt_bind_param($stmt_lama, "i", $id);
mysqli_stmt_execute($stmt_lama);
$hasil_lama = mysqli_stmt_get_result($stmt_lama);
$data_lama = mysqli_fetch_assoc($hasil_lama);
$gambar_lama = $data_lama['gambar'];
mysqli_stmt_close($stmt_lama);

$gambar_simpan = $gambar_lama; // Default gunakan gambar lama

// Jika user mengunggah gambar baru
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $ukuran = $_FILES['gambar']['size'];

    // Validasi maksimal 2MB
    if ($ukuran > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran gambar maksimal 2 MB.']);
        exit;
    }

    // Validasi tipe file (finfo)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);

    if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/webp'])) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Format gambar tidak valid.']);
        exit;
    }

    $ekstensi = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar_simpan = uniqid() . '.' . $ekstensi;
    $tujuan = 'uploads_artikel/' . $gambar_simpan;

    if (move_uploaded_file($tmp_name, $tujuan)) {
        // Hapus file gambar lama dari server
        if (file_exists('uploads_artikel/' . $gambar_lama)) {
            unlink('uploads_artikel/' . $gambar_lama);
        }
    }
}

// Update data artikel (tanggal tidak diubah saat edit)
$query_update = "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?";
$stmt_update = mysqli_prepare($conn, $query_update);
mysqli_stmt_bind_param($stmt_update, "iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar_simpan, $id);

if (mysqli_stmt_execute($stmt_update)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil diperbarui!']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt_update);
mysqli_close($conn);
