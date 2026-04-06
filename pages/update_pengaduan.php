<?php
session_start();
include '../../config/koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];

// cek upload gambar
if($_FILES['bukti']['name']){
    $nama_file = time() . '_' . $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];

    move_uploaded_file($tmp, "../assets/upload/" . $nama_file);

    mysqli_query($conn, "
        UPDATE pengaduan 
        SET judul='$judul', isi='$isi', bukti='$nama_file'
        WHERE id='$id'
    ");
} else {
    mysqli_query($conn, "
        UPDATE pengaduan 
        SET judul='$judul', isi='$isi'
        WHERE id='$id'
    ");
}

header("Location: ../index.php?menu=tracking");