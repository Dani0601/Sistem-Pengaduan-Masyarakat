<?php

$menu = isset($_GET['menu']) ? $_GET['menu'] : 'home';

switch($menu){

    case 'form':
        include 'pages/form_pengaduan.php';
        break;

    case 'tracking':
        include 'pages/tracking.php';
        break;

    case 'login':
        include 'auth/login.php';
        break;

    case 'register':
        include 'auth/register.php';
        break;

    case 'daftar':
        include 'pages/daftar_pengaduan.php';
        break;
    
    case 'detail':
        include 'pages/detail_pengaduan.php';
        break;
    case 'tentang':
        include 'pages/tentang.php';
        break;
    case 'edit_pengaduan':
        include 'pages/edit_pengaduan.php';
        break;
    case 'hapus_pengaduan':
        include 'pages/hapus_pengaduan.php';
        break;
    default:
        include 'pages/home.php';
        break;
}
?>