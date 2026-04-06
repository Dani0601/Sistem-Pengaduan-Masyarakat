<?php
session_start();
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$id = $_POST['pengaduan_id'];
$komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

// ambil status sekarang dari database
$q = mysqli_query($conn, "SELECT status FROM pengaduan WHERE id='$id'");
$data = mysqli_fetch_assoc($q);
$status_db = $data['status'];

// simpan komentar
mysqli_query($conn, "
INSERT INTO komentar (pengaduan_id, komentar, role, tanggal) 
VALUES ('$id', '$komentar', 'admin', NOW())
");

