<?php
session_start();
include '../config/koneksi.php';

$user_id = $_SESSION['id'];
$role = $_SESSION['role'];

$pengaduan_id = $_POST['pengaduan_id'];
$komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

// cek pemilik laporan
$q = mysqli_query($conn, "SELECT user_id FROM pengaduan WHERE id='$pengaduan_id'");
$data = mysqli_fetch_assoc($q);

$isPemilik = $data['user_id'] == $user_id;

// ❌ blok user lain
if(!$isPemilik){
    die("Akses ditolak!");
}

// ✅ simpan komentar
mysqli_query($conn, "
INSERT INTO komentar (pengaduan_id, komentar, tanggal, role)
VALUES ('$pengaduan_id', '$komentar', NOW(), 'user')
");

// redirect balik
header("Location: ../index.php?menu=detail&id=$pengaduan_id&from=tracking");