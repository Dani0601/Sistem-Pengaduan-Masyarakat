<?php
session_start();
include __DIR__ . '/../config/koneksi.php';

$id = intval($_GET['id']);
$user_id = $_SESSION['id'];

// pastikan hanya pemilik yang bisa hapus
$cek = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id='$id' AND user_id='$user_id'");

if(mysqli_num_rows($cek) == 0){
    die("Akses ditolak");
}

// hapus data
mysqli_query($conn, "DELETE FROM pengaduan WHERE id='$id'");

header("Location: ../index.php?menu=tracking");