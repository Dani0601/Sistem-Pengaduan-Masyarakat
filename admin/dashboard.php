<?php

include '../config/koneksi.php';

// 🔒 PROTECT ADMIN
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

/* =========================
   FILTER
========================= */
$where = [];

if(!empty($_GET['tahun'])){
    $tahun = intval($_GET['tahun']);
    $where[] = "YEAR(tanggal) = $tahun";
}

if(!empty($_GET['bulan'])){
    $bulan = intval($_GET['bulan']);
    $where[] = "MONTH(tanggal) = $bulan";
}

if(!empty($_GET['kategori'])){
    $kategori_filter = mysqli_real_escape_string($conn, $_GET['kategori']);
    $where[] = "kategori = '$kategori_filter'";
}

$where_sql = "";
if(count($where) > 0){
    $where_sql = "WHERE " . implode(" AND ", $where);
}

$filter = $where_sql ? $where_sql . " AND" : "WHERE";

/* =========================
   STATISTIK
========================= */
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan $filter status='pending'"))['total'];

$proses  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan $filter status='diproses'"))['total'];

$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan $filter status='selesai'"))['total'];

$total = $pending + $proses + $selesai;

/* =========================
   TREND BULANAN
========================= */
$bulan_arr = [];
$total_per_bulan = [];

$q = mysqli_query($conn, "
    SELECT MONTH(tanggal) as bulan, COUNT(*) as total 
    FROM pengaduan 
    $where_sql
    GROUP BY MONTH(tanggal)
");

while($d = mysqli_fetch_assoc($q)){
    $bulan_arr[] = date('M', mktime(0,0,0,$d['bulan'],1));
    $total_per_bulan[] = $d['total'];
}

/* =========================
   KATEGORI
========================= */
$kategori_arr = [];
$total_kategori = [];

$q2 = mysqli_query($conn, "
    SELECT kategori, COUNT(*) as total 
    FROM pengaduan 
    $where_sql
    GROUP BY kategori
");

while($k = mysqli_fetch_assoc($q2)){
    $kategori_arr[] = $k['kategori'];
    $total_kategori[] = $k['total'];
}

/* =========================
   KECAMATAN (TOP 5)
========================= */
$kecamatan_arr = [];
$total_kecamatan = [];

$q3 = mysqli_query($conn, "
    SELECT k.nama as kecamatan, COUNT(*) as total 
    FROM pengaduan p
    LEFT JOIN kecamatan k ON p.kecamatan = k.id
    $where_sql
    GROUP BY p.kecamatan
    ORDER BY total DESC
    LIMIT 5
");

while($k = mysqli_fetch_assoc($q3)){
    $kecamatan_arr[] = $k['kecamatan'];
    $total_kecamatan[] = $k['total'];
}

/* =========================
   DESA (TOP 5)
========================= */
$desa_arr = [];
$total_desa = [];

$q4 = mysqli_query($conn, "
    SELECT d.nama as desa, COUNT(*) as total 
    FROM pengaduan p
    LEFT JOIN desa d ON p.desa = d.id
    $where_sql
    GROUP BY p.desa
    ORDER BY total DESC
    LIMIT 5
");

while($d = mysqli_fetch_assoc($q4)){
    $desa_arr[] = $d['desa'];
    $total_desa[] = $d['total'];
}

?>

<!DOCTYPE html>
<html lang="id" class="transition duration-300">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<script>
if(localStorage.getItem('theme') === 'dark'){
    document.documentElement.classList.add('dark');
}
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 dark:bg-[#0F172A] transition">

<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="ml-64 p-6 space-y-6 text-gray-800 dark:text-[#E2E8F0]">
<form method="GET" class="flex flex-wrap gap-3 items-center">

    <!-- TAHUN -->
    <select name="tahun" class="border p-2 rounded dark:bg-[#0F172A]">
        <option value="">Semua Tahun</option>
        <?php for($i = date('Y'); $i >= 2020; $i--): ?>
            <option value="<?= $i ?>" <?= ($_GET['tahun'] ?? '') == $i ? 'selected' : '' ?>>
                <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>

    <!-- BULAN -->
    <select name="bulan" class="border p-2 rounded dark:bg-[#0F172A]">
        <option value="">Semua Bulan</option>
        <?php 
        $bulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
        foreach($bulan as $num=>$nama): ?>
            <option value="<?= $num ?>" <?= ($_GET['bulan'] ?? '') == $num ? 'selected' : '' ?>>
                <?= $nama ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- KATEGORI -->
    <select name="kategori" class="border p-2 rounded dark:bg-[#0F172A]">
        <option value="">Semua Kategori</option>
        <option value="Infrastruktur">Infrastruktur</option>
        <option value="Kesehatan">Kesehatan</option>
        <option value="Pendidikan">Pendidikan</option>
        <option value="Keamanan">Keamanan</option>
        <option value="Lainnya">Lainnya</option>
    </select>

    <!-- BUTTON -->
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filter
    </button>

    <!-- RESET -->
    <a href="?" class="bg-gray-400 text-white px-4 py-2 rounded">
        Reset
    </a>

</form>
<!-- HEADER -->
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold flex items-center gap-2">
            📊 Dashboard Admin
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Ringkasan data pengaduan masyarakat
        </p>
    </div>

    <div class="text-sm text-gray-500 dark:text-gray-400">
        <?= date('l, d F Y') ?>
    </div>
</div>

<!-- CHART -->
<div class="grid md:grid-cols-2 gap-6">

<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 p-6 rounded-2xl shadow-xl">
<h3 class="mb-4 font-semibold">📊 Status Pengaduan</h3>
<canvas id="statusChart"></canvas>
</div>

<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 p-6 rounded-2xl shadow-xl">
<h3 class="mb-4 font-semibold">📈 Tren Bulanan</h3>
<canvas id="trendChart"></canvas>
</div>

</div>

<!-- KATEGORI (TIDAK DIUBAH, SIZE KECIL) -->
<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 p-6 rounded-2xl shadow-xl">
<h3 class="mb-4 font-semibold">📌 Kategori Pengaduan</h3>

<div class="flex justify-center">
    <div style="width:300px;">
        <canvas id="kategoriChart"></canvas>
    </div>
</div>
</div>

<!-- KECAMATAN & DESA -->
<div class="grid md:grid-cols-2 gap-6">

<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 p-6 rounded-2xl shadow-xl">
<h3 class="mb-4 font-semibold">🏙️ Top 5 Kecamatan</h3>
<canvas id="kecamatanChart"></canvas>
</div>

<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 p-6 rounded-2xl shadow-xl">
<h3 class="mb-4 font-semibold">🏡 Top 5 Desa</h3>
<canvas id="desaChart"></canvas>
</div>

</div>

</div>

<script>

const customTooltip = {
    plugins: {
        tooltip: {
            backgroundColor: 'rgba(15,23,42,0.9)', // dark glass
            titleColor: '#fff',
            bodyColor: '#e2e8f0',
            borderColor: '#334155',
            borderWidth: 1,
            padding: 12,
            cornerRadius: 10,
            displayColors: true,
            boxPadding: 4,

            callbacks: {
                label: function(context){
                    let value = context.raw;

                    // total untuk persen
                    let data = context.dataset.data;
                    let total = data.reduce((a,b)=>a+b,0);
                    let persen = ((value / total) * 100).toFixed(1);

                    return ` ${context.label}: ${value} (${persen}%)`;
                }
            }
        }
    }
};

// STATUS (TIDAK DIUBAH)
new Chart(document.getElementById('statusChart'), {
type: 'bar',
data: {
labels: ['Pending','Diproses','Selesai'],
datasets: [{
data: [<?= $pending ?>, <?= $proses ?>, <?= $selesai ?>],
backgroundColor: ['#facc15','#3b82f6','#22c55e']
}]
},
options: {
...customTooltip
}
});

// TREND (TIDAK DIUBAH)
new Chart(document.getElementById('trendChart'), {
type: 'line',
data: {
labels: <?= json_encode($bulan_arr) ?>,
datasets: [{
data: <?= json_encode($total_per_bulan) ?>,
borderColor: '#2563eb',
backgroundColor: 'rgba(37,99,235,0.2)',
fill: true,
tension: 0.4
}]
},
options: {
...customTooltip
}
});

// KATEGORI (TIDAK DIUBAH)
new Chart(document.getElementById('kategoriChart'), {
type: 'pie',
data: {
labels: <?= json_encode($kategori_arr) ?>,
datasets: [{
data: <?= json_encode($total_kategori) ?>,
backgroundColor: ['#3b82f6','#22c55e','#f59e0b','#ef4444','#8b5cf6']
}]
},
options: {
responsive: true,
maintainAspectRatio: false,
...customTooltip
}
});

// KECAMATAN (TOP 5)
new Chart(document.getElementById('kecamatanChart'), {
type: 'bar',
data: {
labels: <?= json_encode($kecamatan_arr) ?>,
datasets: [{
data: <?= json_encode($total_kecamatan) ?>,
backgroundColor: '#6366f1'
}]
},
options: {
...customTooltip
}
});

// DESA (TOP 5)
new Chart(document.getElementById('desaChart'), {
type: 'bar',
data: {
labels: <?= json_encode($desa_arr) ?>,
datasets: [{
data: <?= json_encode($total_desa) ?>,
backgroundColor: '#10b981'
}]
},
options: {
...customTooltip
}
});
</script>

</body>
</html>