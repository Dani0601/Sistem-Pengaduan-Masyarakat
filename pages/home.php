<?php
include 'config/koneksi.php';

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan"))['total'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan WHERE status='pending'"))['total'];
$ditinjau = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan WHERE status='ditinjau'"))['total'];
$proses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan WHERE status='diproses'"))['total'];
$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan WHERE status='selesai'"))['total'];
?>

<!DOCTYPE html>
<html lang="id" class="transition duration-300">
<head>
<meta charset="UTF-8">
<title>Pengaduan Masyarakat</title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<style>
.fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease forwards;
}
@keyframes fadeInUp {
    to { opacity: 1; transform: translateY(0); }
}
</style>

</head>

<body class="bg-white dark:bg-[#0F172A] text-gray-800 dark:text-[#E2E8F0]">

<!-- HERO -->
<div class="min-h-screen 
bg-gradient-to-br from-blue-50 to-white 
dark:from-[#0F172A] dark:to-[#1E293B] 
flex items-center px-4 md:px-6 pt-20">

<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

<!-- TEXT -->
<div class="fade-in text-center md:text-left">

<h1 class="text-gray-800 dark:text-white text-3xl md:text-5xl font-bold mb-4 leading-tight">
Sistem Pengaduan Masyarakat
</h1>

<p class="text-gray-600 dark:text-[#CBD5E1] mb-4 text-sm md:text-base">
Platform digital untuk menyampaikan keluhan secara cepat dan transparan.
</p>

<p class="text-gray-600 dark:text-[#CBD5E1] mb-6 text-sm md:text-base">
Pantau pengaduan secara real-time dengan sistem tracking.
</p>

<div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">

<a href="index.php?menu=form" 
class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 w-full sm:w-auto text-center">
🚀 Buat Pengaduan
</a>

<a href="index.php?menu=daftar" 
class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 dark:hover:bg-[#1E293B] w-full sm:w-auto text-center">
📋 Lihat Pengaduan
</a>

</div>
</div>

<!-- IMAGE -->
<div class="flex justify-center">
<img src="assets/img/hero.png" 
class="w-full max-w-xs sm:max-w-md md:max-w-lg drop-shadow-xl">
</div>

</div>
</div>

<!-- FITUR -->
<div class="py-16 bg-white dark:bg-[#0F172A]">
<div class="max-w-6xl mx-auto px-4 text-center">

<h2 class="text-xl text-gray-800 dark:text-white md:text-2xl font-bold mb-10">✨ Fitur Utama</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

<div class="p-6 rounded-xl shadow bg-white dark:bg-[#1E293B] hover:bg-gray-50 dark:hover:bg-[#334155]">
<h3 class="text-lg text-gray-800 dark:text-white font-semibold mb-2">📝 Mudah Digunakan</h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Laporkan masalah dengan cepat.</p>
</div>

<div class="p-6 rounded-xl shadow bg-white dark:bg-[#1E293B] hover:bg-gray-50 dark:hover:bg-[#334155]">
<h3 class="text-lg text-gray-800 dark:text-white font-semibold mb-2">📷 Upload Bukti</h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Lampirkan foto atau dokumen.</p>
</div>

<div class="p-6 rounded-xl shadow bg-white dark:bg-[#1E293B] hover:bg-gray-50 dark:hover:bg-[#334155]">
<h3 class="text-lg text-gray-800 dark:text-white font-semibold mb-2">📊 Tracking Status</h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Pantau perkembangan laporan.</p>
</div>

</div>
</div>
</div>

<!-- CARA KERJA -->
<div class="py-16 bg-gray-50 dark:bg-[#1E293B]">
<div class="max-w-6xl mx-auto px-4 text-center">

<h2 class="text-xl text-gray-800 dark:text-white md:text-2xl font-bold mb-10">⚙️ Cara Kerja</h2>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-6">

<div><div class="text-3xl">1️⃣</div><p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Login</p></div>
<div><div class="text-3xl">2️⃣</div><p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Isi Form</p></div>
<div><div class="text-3xl">3️⃣</div><p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Diproses</p></div>
<div><div class="text-3xl">4️⃣</div><p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Selesai</p></div>

</div>
</div>
</div>

<!-- STATISTIK -->
<div class="py-16 bg-white dark:bg-[#0F172A]">
<div class="max-w-6xl mx-auto px-4 text-center">

<h2 class="text-xl text-gray-800 dark:text-white md:text-2xl font-bold mb-10">📊 Statistik</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

<div class="p-6 rounded-xl shadow bg-blue-50 dark:bg-blue-900/20">
<h3 class="text-2xl md:text-3xl font-bold text-blue-600"><?= $total ?></h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Total</p>
</div>

<div class="p-6 rounded-xl shadow bg-yellow-50 dark:bg-yellow-900/20">
<h3 class="text-2xl md:text-3xl font-bold text-yellow-600"><?= $pending ?></h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Pending</p>
</div>

<div class="p-6 rounded-xl shadow bg-purple-50 dark:bg-purple-900/20">
<h3 class="text-2xl md:text-3xl font-bold text-purple-600"><?= $ditinjau ?></h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Ditinjau</p>
</div>

<div class="p-6 rounded-xl shadow bg-indigo-50 dark:bg-indigo-900/20">
<h3 class="text-2xl md:text-3xl font-bold text-indigo-600"><?= $proses ?></h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Diproses</p>
</div>

<div class="p-6 rounded-xl shadow bg-green-50 dark:bg-green-900/20">
<h3 class="text-2xl md:text-3xl font-bold text-green-600"><?= $selesai ?></h3>
<p class="text-sm text-gray-600 dark:text-[#CBD5E1]">Selesai</p>
</div>

</div>
</div>
</div>

<!-- CTA -->
<div class="py-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center px-4">

<h2 class="text-xl md:text-2xl font-bold mb-4">
🚀 Laporkan Masalah Sekarang!
</h2>

<p class="mb-6 text-sm md:text-base">
Bantu kami meningkatkan pelayanan dengan pengaduan Anda.
</p>

<a href="index.php?menu=form"
class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 w-full sm:w-auto inline-block">
Buat Pengaduan
</a>

</div>

</body>
</html>