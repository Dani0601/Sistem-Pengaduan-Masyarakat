<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

// BELUM VERIFIKASI
$pending = mysqli_query($conn, "SELECT * FROM users WHERE verified=0");

// SUDAH VERIFIKASI
$verified = mysqli_query($conn, "SELECT * FROM users WHERE verified=1");
?>

<div class="ml-64 p-6 space-y-6 text-gray-800 dark:text-white">

<h1 class="text-2xl font-bold">👥 Manajemen User</h1>

<!-- =======================
    TABEL VERIFIKASI USER
======================= -->
<div class="bg-white dark:bg-[#1E293B] p-5 rounded-xl shadow">

<h2 class="text-lg font-semibold mb-4">⏳ User Belum Diverifikasi</h2>

<div class="overflow-x-auto">
<table class="w-full text-sm border rounded-xl overflow-hidden">

<thead class="bg-gray-200 dark:bg-[#334155]">
<tr>
<th class="p-2">NIK</th>
<th class="p-2">Nama</th>
<th class="p-2">Email</th>
<th class="p-2">Aksi</th>
</tr>
</thead>

<tbody>
<?php if(mysqli_num_rows($pending) == 0){ ?>
<tr>
<td colspan="4" class="text-center p-3 text-gray-400">Tidak ada data</td>
</tr>
<?php } ?>

<?php while($d = mysqli_fetch_assoc($pending)){ ?>
<tr class="border-b dark:border-[#334155]">

<td class="p-2"><?= $d['nik'] ?></td>
<td class="p-2"><?= $d['nama'] ?></td>
<td class="p-2"><?= $d['email'] ?></td>

<td class="p-2 flex gap-2">

<a href="verifikasi_aksi.php?id=<?= $d['id'] ?>"
class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
✅ Verifikasi
</a>

<a href="tolak_user.php?id=<?= $d['id'] ?>"
class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
❌ Tolak
</a>

</td>

</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>

<!-- =======================
    TABEL USER VERIFIED
======================= -->
<div class="bg-white dark:bg-[#1E293B] p-5 rounded-xl shadow">

<h2 class="text-lg font-semibold mb-4">✅ User Sudah Diverifikasi</h2>

<div class="overflow-x-auto">
<table class="w-full text-sm border rounded-xl overflow-hidden">

<thead class="bg-gray-200 dark:bg-[#334155]">
<tr>
<th class="p-2">NIK</th>
<th class="p-2">Nama</th>
<th class="p-2">Email</th>
<th class="p-2">Aksi</th>
</tr>
</thead>

<tbody>
<?php if(mysqli_num_rows($verified) == 0){ ?>
<tr>
<td colspan="4" class="text-center p-3 text-gray-400">Tidak ada data</td>
</tr>
<?php } ?>

<?php while($u = mysqli_fetch_assoc($verified)){ ?>
<tr class="border-b dark:border-[#334155]">

<td class="p-2"><?= $u['nik'] ?></td>
<td class="p-2"><?= $u['nama'] ?></td>
<td class="p-2"><?= $u['email'] ?></td>

<td class="p-2">

<a href="hapus_user.php?id=<?= $u['id'] ?>"
onclick="return confirm('Yakin hapus user ini?')"
class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
🗑 Hapus
</a>

</td>

</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>

</div>