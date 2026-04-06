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

<div class="max-w-6xl mx-auto">

    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        📋 Daftar Pengaduan
    </h2>
    <!-- FILTER -->
<form method="GET" class="mb-6 flex flex-wrap gap-4 ">

    <input type="hidden" name="menu" value="daftar">
    
    <!-- KECAMATAN -->
    <select name="kecamatan" id="kecamatan"
        class="p-2 rounded-lg border dark:bg-[#0F172A]">

        <option value="">Semua Kecamatan</option>

        <?php
        $kec = mysqli_query($conn, "SELECT * FROM kecamatan");
        while($k = mysqli_fetch_assoc($kec)){
            $selected = ($_GET['kecamatan'] ?? '') == $k['nama'] ? 'selected' : '';
            echo "<option $selected value='{$k['nama']}'>{$k['nama']}</option>";
        }
        ?>
    </select>

    <!-- DESA -->
    <select name="desa" id="desa"
        class="p-2 rounded-lg border dark:bg-[#0F172A]">

        <option value="">Semua Desa</option>
    </select>
    
    <button class="bg-blue-600 text-white px-4 rounded-lg">
        🔍 Filter
    </button>

</form>

<form method="GET" class="flex gap-2 mb-4">
    <input type="hidden" name="menu" value="daftar">

    <input type="text" name="search" placeholder="Cari judul pengaduan..."
        class="flex-1 border border-gray-300 dark:border-[#334155] 
        bg-white dark:bg-[#0F172A] 
        text-gray-800 dark:text-white
        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

    <button class="bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 transition">
        Cari
    </button>
</form>
    <div class="grid md:grid-cols-3 gap-6">

    <?php
    $where = [];

if(!empty($_GET['kecamatan'])){
    $kecamatan = mysqli_real_escape_string($conn, $_GET['kecamatan']);
    $where[] = "kecamatan = '$kecamatan'";
}

if(!empty($_GET['desa'])){
    $desa = mysqli_real_escape_string($conn, $_GET['desa']);
    $where[] = "desa = '$desa'";
}
if(!empty($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where[] = "(judul LIKE '%$search%' OR isi LIKE '%$search%')";
}
$where_sql = '';
if(count($where) > 0){
    $where_sql = "WHERE " . implode(" AND ", $where);
}

$data = mysqli_query($conn, "
    SELECT * FROM pengaduan 
    $where_sql
    ORDER BY id DESC
");

    if(mysqli_num_rows($data) == 0){
        echo "<p class='text-gray-500'>Belum ada pengaduan</p>";
    }

    while($d = mysqli_fetch_array($data)){
    ?>
        <!-- CARD -->
        <a href="index.php?menu=detail&id=<?= $d['id']; ?>&from=daftar" 
           class="group bg-white/80 dark:bg-[#1E293B]/80 backdrop-blur-md 
           border border-gray-200 dark:border-[#334155] 
           rounded-2xl overflow-hidden shadow-lg 
           hover:shadow-2xl hover:-translate-y-1 transition duration-300">

            <!-- GAMBAR -->
            <?php if($d['bukti']){ ?>
            <img src="assets/upload/<?= $d['bukti']; ?>" 
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
            <?php } ?>

            <!-- CONTENT -->
            <div class="p-4">

                <h3 class="font-semibold text-gray-800 dark:text-white mb-1">
                    <?= $d['judul']; ?>
                </h3>

                <p class="text-sm text-gray-500 dark:text-[#CBD5E1] mb-2">
                    <?= substr($d['isi'],0,80); ?>...
                </p>

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

            </div>

            <!-- FOOTER -->
            <div class="px-4 pb-3 text-xs text-gray-400 dark:text-[#94A3B8]">
                📅 <?= date('d M Y', strtotime($d['tanggal'])); ?>
            </div>

        </a>
    <?php } ?>

    </div>

</div>
</div>
<script>
document.getElementById('kecamatan').addEventListener('change', function(){
    let kec = this.value;

    fetch('pages/get_desa.php?kecamatan=' + encodeURIComponent(kec))
    .then(res => res.text())
    .then(data => {
        document.getElementById('desa').innerHTML = data;
    });
});
</script>