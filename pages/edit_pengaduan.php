<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../config/koneksi.php';

$id = intval($_GET['id']);
$user_id = $_SESSION['id'];

$data = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id='$id' AND user_id='$user_id'");
$d = mysqli_fetch_assoc($data);

if(!$d){
    die("Data tidak ditemukan / bukan milik anda");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pengaduan</title>

<!-- DARK MODE INIT -->
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

<body class="bg-gray-100 dark:bg-[#0F172A] text-gray-800 dark:text-[#E2E8F0] transition">

<div class="max-w-xl mx-auto mt-10 
bg-white dark:bg-[#1E293B] 
p-6 rounded-2xl shadow-xl">

<h2 class="text-xl font-bold mb-4">✏️ Edit Pengaduan</h2>

<form action="pages/update_pengaduan.php" method="POST" enctype="multipart/form-data" class="space-y-4">

<input type="hidden" name="id" value="<?= $d['id'] ?>">

<!-- JUDUL -->
<div>
<label class="block mb-1 text-sm">Judul</label>
<input type="text" name="judul" value="<?= $d['judul'] ?>"
class="w-full border p-2 rounded 
bg-white dark:bg-[#0F172A] 
border-gray-300 dark:border-[#334155]" required>
</div>

<!-- ISI -->
<div>
<label class="block mb-1 text-sm">Isi</label>
<textarea name="isi" rows="4"
class="w-full border p-2 rounded 
bg-white dark:bg-[#0F172A] 
border-gray-300 dark:border-[#334155]" required><?= $d['isi'] ?></textarea>
</div>

<!-- GAMBAR LAMA -->
<?php if(!empty($d['bukti'])){ ?>
<div>
<label class="block mb-1 text-sm">Gambar Saat Ini</label>
<img src="../assets/upload/<?= $d['bukti'] ?>" 
class="rounded-lg max-h-40">
</div>
<?php } ?>

<!-- UPLOAD GAMBAR BARU -->
<div>
<label class="block mb-1 text-sm">Ganti Gambar (opsional)</label>
<input type="file" name="bukti" 
class="w-full text-sm">
</div>

<!-- BUTTON -->
<div class="flex justify-between items-center">

<a href="index.php?menu=tracking"
class="text-gray-500 hover:underline">← Kembali</a>

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Simpan Perubahan
</button>

</div>

</form>

</div>

</body>
</html>