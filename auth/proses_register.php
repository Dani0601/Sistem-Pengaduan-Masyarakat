<?php
include __DIR__ . '/../config/koneksi.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// VALIDASI NIK
if(strlen($nik) != 16 || !is_numeric($nik)){
    echo "<script>alert('NIK harus 16 digit angka!'); window.location='register.php';</script>";
    exit;
}

// CEK NIK
$cek_nik = mysqli_query($conn, "SELECT id FROM users WHERE nik='$nik'");
if(mysqli_num_rows($cek_nik) > 0){
    echo "<script>alert('NIK sudah terdaftar!'); window.location='register.php';</script>";
    exit;
}

// CEK EMAIL
$cek_user = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if(mysqli_num_rows($cek_user) > 0){
    echo "<script>alert('Email sudah digunakan!'); window.location='register.php';</script>";
    exit;
}

// SIMPAN
$query = mysqli_query($conn, "
INSERT INTO users (nik, nama, email, password, role, verified)
VALUES ('$nik','$nama','$email','$password','user',0)
");

if(!$query){
    echo "<script>alert('Terjadi error / data sudah digunakan!'); window.location='register.php';</script>";
    exit;
}

echo "<script>alert('Registrasi berhasil, tunggu verifikasi admin'); window.location='login.php';</script>";