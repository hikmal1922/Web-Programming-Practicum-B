<?php
require_once 'koneksi.php';

$id = $_POST['id'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password_baru = $_POST['password'];

// 1. Ambil data foto dan password lama dari database
$query_lama = "SELECT foto, password FROM penulis WHERE id = ?";
$stmt_lama = mysqli_prepare($conn, $query_lama);
mysqli_stmt_bind_param($stmt_lama, "i", $id);
mysqli_stmt_execute($stmt_lama);
$hasil_lama = mysqli_stmt_get_result($stmt_lama);
$data_lama = mysqli_fetch_assoc($hasil_lama);

$foto_lama = $data_lama['foto'];
$password_simpan = $data_lama['password']; // Default: pertahankan password lama
mysqli_stmt_close($stmt_lama);

// 2. Cek Password: Jika user mengisi password baru, hash yang baru! [cite: 147]
if (!empty($password_baru)) {
    $password_simpan = password_hash($password_baru, PASSWORD_BCRYPT);
}

// 3. Cek Foto: Jika user mengunggah foto baru [cite: 148]
$foto_simpan = $foto_lama; 
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['foto']['tmp_name'];
    $ukuran = $_FILES['foto']['size'];

    // Validasi ukuran (Maks 2MB)
    if ($ukuran > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran foto maksimal 2 MB.']);
        exit;
    }

    // Validasi tipe file (finfo)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);

    if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Tipe file harus berupa gambar.']);
        exit;
    }

    $ekstensi = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_simpan = uniqid() . '.' . $ekstensi;
    $tujuan = 'uploads_penulis/' . $foto_simpan;

    // Pindahkan foto baru
    if (move_uploaded_file($tmp_name, $tujuan)) {
        // HAPUS foto lama dari server agar tidak jadi sampah (kecuali default.png) 
        if ($foto_lama !== 'default.png' && file_exists('uploads_penulis/' . $foto_lama)) {
            unlink('uploads_penulis/' . $foto_lama);
        }
    }
}

// 4. Update data ke database
$query_update = "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?";
$stmt_update = mysqli_prepare($conn, $query_update);
mysqli_stmt_bind_param($stmt_update, "sssssi", $nama_depan, $nama_belakang, $user_name, $password_simpan, $foto_simpan, $id);

try {
    mysqli_stmt_execute($stmt_update);
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil diperbarui!']);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gagal! Username mungkin sudah dipakai oleh penulis lain.']);
}

mysqli_stmt_close($stmt_update);
mysqli_close($conn);
?>