<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../config/koneksi.php';
?>

<div class="min-h-screen 
    bg-gradient-to-br from-blue-50 via-white to-blue-100 
    dark:from-[#0F172A] dark:via-[#1E293B] dark:to-[#0F172A] 
    py-10 px-4 text-gray-800 dark:text-[#E2E8F0]">

<div class="max-w-4xl mx-auto">

<!-- =========================
     FORM TRACKING
========================= -->
<div class="bg-white/80 dark:bg-[#1E293B]/80 backdrop-blur-md 
    border border-gray-200 dark:border-[#334155] 
    p-6 rounded-2xl shadow-xl mb-6">

    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
        🔍 Tracking Pengaduan
    </h2>

    <form method="GET" class="flex gap-2">
    <input type="hidden" name="menu" value="tracking">

    <input type="text" name="judul" placeholder="Cari berdasarkan judul..."
        class="flex-1 border border-gray-300 dark:border-[#334155] 
        bg-white dark:bg-[#0F172A] 
        text-gray-800 dark:text-white
        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

    <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700 transition">
        Cari
    </button>
</form>
</div>

<!-- =========================
     HASIL PENCARIAN
========================= -->
<?php
if(isset($_GET['judul']) && $_GET['judul'] != ''){
    $judul = mysqli_real_escape_string($conn, $_GET['judul']);
    $user_id = $_SESSION['id']; // ambil user login

    $data = mysqli_query($conn, "
        SELECT * FROM pengaduan 
        WHERE user_id='$user_id' 
        AND judul LIKE '%$judul%'
        ORDER BY id DESC
    ");

    if(mysqli_num_rows($data) > 0){
        while($d = mysqli_fetch_assoc($data)){
?>
    <a href="index.php?menu=detail&id=<?= $d['id']; ?>&from=tracking"
       class="block bg-white/80 dark:bg-[#1E293B]/80 backdrop-blur-md 
       p-6 rounded-2xl shadow-xl mb-6 hover:shadow-2xl transition">

        <h3 class="font-bold text-lg text-gray-800 dark:text-white">
            <?= $d['judul']; ?>
        </h3>

        <p class="text-gray-500 dark:text-[#CBD5E1] mt-2">
            <?= substr($d['isi'],0,120); ?>...
        </p>

        <span class="inline-block mt-3 px-3 py-1 rounded-full text-sm
            <?= $d['status']=='pending' ? 'bg-yellow-100 text-yellow-600' : 
               ($d['status']=='diproses' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'); ?>">
            <?= strtoupper($d['status']); ?>
        </span>

    </a>
<?php 
        }
    } else {
        echo "<div class='text-red-500 mb-4'>❌ Data tidak ditemukan</div>";
    }
}
?>

<!-- =========================
     PENGADUAN SAYA
========================= -->
<?php if(isset($_SESSION['login'])){ ?>

<div class="bg-white/80 dark:bg-[#1E293B]/80 backdrop-blur-md 
    border border-gray-200 dark:border-[#334155] 
    p-6 rounded-2xl shadow-xl">

    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
        📋 Pengaduan Saya
    </h2>

    <div class="space-y-4">

    <?php
    $user_id = $_SESSION['id'];
    $data = mysqli_query($conn, "SELECT * FROM pengaduan WHERE user_id='$user_id' ORDER BY id DESC");

    if(mysqli_num_rows($data) == 0){
        echo "<p class='text-gray-500 dark:text-[#CBD5E1]'>Belum ada pengaduan</p>";
    }

    while($d = mysqli_fetch_array($data)){
    ?>
      <div class="bg-white dark:bg-[#0F172A] p-4 rounded-xl border 
hover:shadow-xl hover:-translate-y-1 transition duration-300">

    <!-- AREA DETAIL (klik ke detail) -->
    <a href="index.php?menu=detail&id=<?= $d['id']; ?>&from=tracking" class="block">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-white">
                    <?= $d['judul']; ?>
                </h3>

                <p class="text-sm text-gray-500 dark:text-[#CBD5E1]">
                    <?= date('d M Y', strtotime($d['tanggal'])); ?>
                </p>
            </div>

            <span class="px-3 py-1 text-xs rounded-full
<?= 
    $d['status']=='pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' :
    ($d['status']=='ditinjau' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' :
    ($d['status']=='diproses' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' :
    'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'))
?>">
    <?= strtoupper($d['status']) ?>
</span>
        </div>
    </a>

    <!-- BUTTON (tidak ikut link) -->
    <div class="mt-3 flex gap-2">
        <a href="index.php?menu=edit_pengaduan&id=<?= $d['id']; ?>"
           class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
           ✏️ Edit
        </a>

        <a href="pages/hapus_pengaduan.php?id=<?= $d['id']; ?>"
           onclick="return confirm('Yakin hapus?')"
           class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
           🗑 Hapus
        </a>
    </div>

</div>
    <?php } ?>

    </div>
</div>

<?php } else { ?>

<div class="text-center text-gray-500 dark:text-[#CBD5E1] mt-6">
    Silakan login untuk melihat pengaduan Anda
</div>

<?php } ?>

</div>
</div>