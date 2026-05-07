<?php
session_start();
include 'config/koneksi.php';

$menu = $_GET['menu'] ?? 'home';

// 🔒 PROTEKSI LOGIN (PINDAH KE SINI)
if($menu == 'form'){
    if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'user'){
        header("Location: auth/login.php");
        exit;
    }
}

// baru load tampilan
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/menu.php';
include 'includes/footer.php';
?>