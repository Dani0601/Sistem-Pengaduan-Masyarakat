<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../config/koneksi.php';

// VALIDASI ID
if(!isset($_GET['id'])){
    echo "ID tidak ditemukan";
    exit;
}

$id = intval($_GET['id']);
$from = $_GET['from'] ?? 'daftar';

// QUERY JOIN
$data = mysqli_query($conn, "
SELECT 
    p.*, 
    k.nama AS nama_kecamatan,
    d.nama AS nama_desa
FROM pengaduan p
LEFT JOIN kecamatan k ON p.kecamatan = k.id
LEFT JOIN desa d ON p.desa = d.id
WHERE p.id='$id'
");

$d = mysqli_fetch_assoc($data);

if(!$d){
    echo "<div class='p-6 text-red-500'>Data tidak ditemukan</div>";
    exit;
}

// session
$user_id_login = $_SESSION['id'] ?? 0;
$role = $_SESSION['role'] ?? 'guest';

$isPemilik = $d['user_id'] == $user_id_login;
$isAdmin   = $role == 'admin';
?>

<div class="py-10 bg-white dark:bg-[#0F172A] text-gray-800 dark:text-[#E2E8F0]">
<div class="max-w-4xl mx-auto px-4">

<!-- CARD -->
<div class="rounded-xl shadow-lg overflow-hidden bg-white dark:bg-[#1E293B] border">

<?php if(!empty($d['bukti'])){ ?>
<img src="assets/upload/<?= $d['bukti']; ?>" class="w-full h-72 object-cover">
<?php } ?>

<div class="p-6">

<h2 class="text-2xl font-bold"><?= $d['judul']; ?></h2>

<!-- STATUS -->
<span class="px-3 py-1 text-xs rounded-full
<?= 
    $d['status']=='pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' :
    ($d['status']=='ditinjau' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' :
    ($d['status']=='diproses' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' :
    'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'))
?>">
<?= strtoupper($d['status']) ?>
</span>

<!-- 🔥 PROGRESS STEPPER -->
<div class="mt-6">
    <h3 class="text-sm font-semibold mb-3">📊 Progress Pengaduan</h3>

    <div id="progressBox">
        <p class="text-gray-400 text-sm">Loading progress...</p>
    </div>
</div>

<p class="mt-4"><?= nl2br($d['isi']); ?></p>
<p class="text-sm mt-2">📅 <?= date('d M Y', strtotime($d['tanggal'])); ?></p>

<!-- LOKASI -->
<p class="text-sm mt-2 flex items-center gap-2">
📍 
<span class="font-medium">
    <?= $d['nama_kecamatan'] ?? 'Tidak diketahui'; ?>
</span>, 
<span class="text-gray-500">
    <?= $d['nama_desa'] ?? 'Tidak diketahui'; ?>
</span>
</p>

</div>
</div>

<!-- =========================
     CHAT (TRACKING ONLY)
========================= -->
<?php if($from == 'tracking'){ ?>

<h3 class="mt-6 mb-2 font-semibold">💬 Percakapan</h3>

<div id="chatBox" 
class="space-y-3 max-h-72 overflow-y-auto p-3 bg-gray-50 dark:bg-[#0F172A] rounded-xl">
    <p class="text-gray-400 text-center">Loading...</p>
</div>

<script>
function loadChat(){
    fetch('pages/get_chat.php?id=<?= $id ?>')
    .then(res => res.text())
    .then(html => {
        document.getElementById('chatBox').innerHTML = html;

        let box = document.getElementById('chatBox');
        box.scrollTop = box.scrollHeight;
    });
}
loadChat();
setInterval(loadChat, 3000);
</script>

<?php if($isAdmin || $isPemilik){ ?>
<form action="pages/balas_komentar.php" method="POST" class="mt-3 flex gap-2">
    <input type="hidden" name="pengaduan_id" value="<?= $id ?>">

    <input type="text" name="komentar" required 
        class="w-full border p-2 rounded dark:bg-[#0F172A]"
        placeholder="Tulis komentar...">

    <button class="bg-blue-600 text-white px-4 rounded-lg">
        Kirim
    </button>
</form>
<?php } ?>

<?php } else { ?>

<p class="text-sm text-gray-400 mt-4 italic">
🔒 Percakapan hanya bisa dilihat melalui halaman tracking.
</p>

<?php } ?>

<?php
$backLink = ($from == 'tracking') 
    ? 'index.php?menu=tracking' 
    : 'index.php?menu=daftar';
?>

<a href="<?= $backLink ?>"
class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
← Kembali
</a>

</div>
</div>

<!-- 🔥 LOAD PROGRESS -->
<script>
function loadProgress(){
    fetch('pages/get_progress.php?id=<?= $id ?>')
    .then(res => res.text())
    .then(html => {
        document.getElementById('progressBox').innerHTML = html;
    });
}

loadProgress();
setInterval(loadProgress, 5000);
</script>