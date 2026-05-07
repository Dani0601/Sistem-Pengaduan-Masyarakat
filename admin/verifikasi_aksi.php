<?php
session_start();
include '../config/koneksi.php';

$id = intval($_GET['id']);

mysqli_query($conn, "
UPDATE users SET verified=1 WHERE id='$id'
");

header("Location: index.php?menu=verifikasi");