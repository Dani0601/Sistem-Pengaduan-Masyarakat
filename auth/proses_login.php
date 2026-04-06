<?php
session_start();
include '../config/koneksi.php';

// 🔒 VALIDASI CAPTCHA
if(!isset($_POST['captcha']) || 
   !isset($_SESSION['captcha']) || 
   strtolower(trim($_POST['captcha'])) != strtolower($_SESSION['captcha'])){
    
    header("Location: login.php?error=captcha");
    exit;
}

// hapus captcha setelah dipakai
unset($_SESSION['captcha']);

// 🔒 AMANKAN INPUT
$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$password = $_POST['password'];

// 🔍 CEK USER
$data = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
$user = mysqli_fetch_assoc($data);
if($user['verified'] == 0){
    echo "<script>alert('Akun belum diverifikasi admin'); window.location='login.php';</script>";
    exit;
}
if($user){

    // 🔑 CEK PASSWORD
    if(password_verify($password, $user['password'])){

        // 🔐 SESSION
        $_SESSION['login'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // 🔥 MULTI ROLE REDIRECT
        if($user['role'] === 'admin'){
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../index.php");
        }
        exit;

    } else {
        header("Location: login.php?error=password");
        exit;
    }

} else {
    header("Location: login.php?error=user");
    exit;
}
?>