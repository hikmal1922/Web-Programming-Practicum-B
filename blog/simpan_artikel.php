<?php
require_once 'koneksi.php';

// Mengatur zona waktu agar tanggal sesuai
date_default_timezone_set('Asia/Jakarta');

$judul = $_POST['judul_artikel'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi_artikel'];

// Membuat format hari dan tanggal (Contoh: Senin, 27 April 2026)
$daftar_hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$hari = $daftar_hari[date('w')];
$tgl = date('d');
$bulan = $daftar_bulan[date('n')];
$tahun = date('Y');
$hari_tanggal = "$hari, $tgl $bulan $tahun";

// Validasi Gambar
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gambar wajib diunggah!']);
    exit;
}

$tmp_name = $_FILES['gambar']['tmp_name'];
$ukuran = $_FILES['gambar']['size'];

// Maksimal 2MB
if ($ukuran > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran gambar maksimal 2MB.']);
    exit;
}

// Cek tipe file pakai finfo
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $tmp_name);
finfo_close($finfo);

if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/webp'])) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Hanya boleh mengunggah gambar (JPG/PNG/WEBP).']);
    exit;
}

// Generate nama file unik
$nama_gambar = uniqid() . ".jpg";
move_uploaded_file($tmp_name, "uploads_artikel/" . $nama_gambar);

// Simpan ke database
$query = "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iissss", $id_penulis, $id_kategori, $judul, $isi, $nama_gambar, $hari_tanggal);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil diterbitkan!']);
} else {
    echo json_encode(['status' => 'gagal', 'pesan' => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>