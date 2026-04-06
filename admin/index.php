<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$menu = $_GET['menu'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<!-- DARK MODE FIX -->
<script>
if(localStorage.getItem('theme') === 'dark'){
    document.documentElement.classList.add('dark');
}
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

</head>

<body class="bg-gray-100 dark:bg-[#0F172A] text-gray-800 dark:text-white">

<div class="flex">

    <!-- SIDEBAR -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- CONTENT -->
    <div class="flex-1 p-6">

        <?php
        switch($menu){

            case 'dashboard':
                include 'dashboard.php';
                break;

            case 'pengaduan':
                include 'pengaduan.php';
                break;
            case 'verifikasi':
                include 'verifikasi_user.php';

            default:
                echo "<h1>Halaman tidak ditemukan</h1>";
        }
        ?>

    </div>

</div>

</body>
</html>