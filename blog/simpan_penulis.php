<?php
require_once 'koneksi.php';

$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password = $_POST['password'];

// Validasi input dasar
if (empty($nama_depan) || empty($nama_belakang) || empty($user_name) || empty($password)) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Semua kolom wajib diisi!']);
    exit;
}

// 1. Enkripsi Password menggunakan PASSWORD_BCRYPT 
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Default nama foto jika tidak ada upload 
$nama_file_foto = 'default.png';

// 2. Proses Upload File (Jika ada file yang diunggah)
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['foto']['tmp_name'];
    $ukuran = $_FILES['foto']['size'];

    // Validasi maksimal 2MB [cite: 3363]
    if ($ukuran > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Ukuran file foto maksimal 2 MB.']);
        exit;
    }

    // Validasi tipe file MENGGUNAKAN FINFO (Sesuai Syarat Mutlak UTS) [cite: 3359, 3362]
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);

    $tipe_diizinkan = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mime_type, $tipe_diizinkan)) {
        echo json_encode(['status' => 'gagal', 'pesan' => 'Tipe file harus berupa gambar (JPG, PNG, GIF).']);
        exit;
    }

    // Generate nama file acak agar tidak bentrok, lalu pindahkan
    $ekstensi = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nama_file_foto = uniqid() . '.' . $ekstensi;
    $tujuan = 'uploads_penulis/' . $nama_file_foto;
    
    move_uploaded_file($tmp_name, $tujuan);
}

// 3. Simpan ke database menggunakan Prepared Statements
$query = "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssss", $nama_depan, $nama_belakang, $user_name, $hashed_password, $nama_file_foto);

// Eksekusi dan tangkap jika username duplikat (karena uq_user_name di database)
try {
    mysqli_stmt_execute($stmt);
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil ditambahkan!']);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'gagal', 'pesan' => 'Username sudah digunakan, silakan pilih yang lain.']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>