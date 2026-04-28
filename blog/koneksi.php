<?php
$host = "localhost";
$username = "root";
$password = "Hikmal041903";
$database = "db_blog"; // Sesuai dengan nama database di soal UTS

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die ("Koneksi gagal: " . mysqli_connect_error());
}
?>