<?php
session_start();
include '../config/koneksi.php';

// 🔒 CEK LOGIN
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'user'){
    header("Location: ../auth/login.php");
    exit;
}

// 🔹 AMBIL DATA
$user_id  = $_SESSION['id'];
$judul    = mysqli_real_escape_string($conn, $_POST['judul']);
$kategori = mysqli_real_escape_string($conn, $_POST['kategori']); // 🔥 BARU
$isi      = mysqli_real_escape_string($conn, $_POST['isi']);
$tanggal  = date('Y-m-d H:i:s');
$status   = 'pending';
$kecamatan = ucwords(strtolower($_POST['kecamatan']));
$desa = ucwords(strtolower($_POST['desa']));

// 🔹 UPLOAD FILE
$nama_file = $_FILES['bukti']['name'];
$tmp_file  = $_FILES['bukti']['tmp_name'];

$bukti = ""; // default kosong

if($nama_file != ""){

    $folder = "../assets/upload/";

    // 🔒 VALIDASI EXTENSION
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        die("Format file tidak didukung!");
    }

    // 🔒 BATASI UKURAN (2MB)
    if($_FILES['bukti']['size'] > 2 * 1024 * 1024){
        die("Ukuran file terlalu besar! Max 2MB");
    }

    // 🔥 RENAME FILE
    $new_name = time() . '_' . rand(100,999) . '.' . $ext;

    // PINDAH FILE
    if(move_uploaded_file($tmp_file, $folder . $new_name)){
        $bukti = $new_name;
    }
}

// 🔹 INSERT DATABASE
$query = "INSERT INTO pengaduan 
(user_id, judul, kategori, kecamatan, desa, isi, bukti, status, tanggal)
VALUES 
('$user_id', '$judul', '$kategori', '$kecamatan', '$desa', '$isi', '$bukti', '$status', '$tanggal')";

$insert = mysqli_query($conn, $query);
// setelah insert pengaduan
$id_pengaduan = mysqli_insert_id($conn);

// simpan status awal
mysqli_query($conn, "
INSERT INTO riwayat_status (pengaduan_id, status)
VALUES ('$id_pengaduan', 'pending')
");
// 🔹 REDIRECT
if($insert){
    header("Location: ../index.php?menu=tracking&success=1");
    exit;
} else {
    echo "Gagal menyimpan: " . mysqli_error($conn);
}
?>