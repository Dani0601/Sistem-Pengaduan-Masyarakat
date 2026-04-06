<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pengaduan_db";

// koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// optional: set timezone (biar tanggal sesuai Indonesia)
date_default_timezone_set("Asia/Jakarta");
?>