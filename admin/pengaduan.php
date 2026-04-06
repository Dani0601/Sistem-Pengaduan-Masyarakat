<?php

include '../config/koneksi.php';

// QUERY JOIN
$data = mysqli_query($conn, "
SELECT 
    p.*, 
    k.nama AS nama_kecamatan,
    d.nama AS nama_desa
FROM pengaduan p
LEFT JOIN kecamatan k ON p.kecamatan = k.id
LEFT JOIN desa d ON p.desa = d.id
ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Kelola Pengaduan</title>

<!-- DARK MODE -->
<script>
if(localStorage.getItem('theme') === 'dark'){
    document.documentElement.classList.add('dark');
}
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<!-- 🔥 DATATABLE -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
.dataTables_wrapper {
    color: inherit;
}
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: transparent;
}
.dark .dataTables_wrapper .dataTables_filter input,
.dark .dataTables_wrapper .dataTables_length select {
    border: 1px solid #334155;
    color: #E2E8F0;
}
</style>

</head>

<body class="bg-gray-100 dark:bg-[#0F172A] transition text-gray-800 dark:text-[#E2E8F0]">

<?php include '../includes/sidebar.php'; ?>

<div class="ml-64 p-6 space-y-6">

<h1 class="text-2xl font-bold">📋 Kelola Pengaduan</h1>

<div class="backdrop-blur-md bg-white/70 dark:bg-[#1E293B]/70 
border border-gray-200 dark:border-[#334155] 
rounded-2xl shadow-xl overflow-hidden">

<table id="myTable" class="w-full text-sm">

<thead class="bg-gray-100 dark:bg-[#0F172A]">
<tr>
<th class="p-4">No</th>
<th>Judul</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php $no=1; while($d = mysqli_fetch_assoc($data)){ ?>

<tr class="border-t dark:border-[#334155] hover:bg-gray-50 dark:hover:bg-[#0F172A]">

<td class="p-4"><?= $no++ ?></td>

<td><?= $d['judul'] ?></td>

<td>
<span class="px-3 py-1 text-xs rounded-full
<?= 
$d['status']=='pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' :
($d['status']=='ditinjau' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' :
($d['status']=='diproses' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' :
'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'))
?>">
<?= strtoupper($d['status']) ?>
</span>
</td>

<td class="flex gap-2">

<!-- DETAIL -->
<button 
onclick='openModal(<?= json_encode($d, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' 
class="bg-gray-500 text-white px-3 py-1 rounded hover:scale-105">
Detail
</button>

<!-- UPDATE -->
<form action="update_status.php" method="POST" class="flex gap-1">

<input type="hidden" name="id" value="<?= $d['id'] ?>">

<?php
$urutan = [
    'pending' => 1,
    'ditinjau' => 2,
    'diproses' => 3,
    'selesai' => 4
];

$current = $d['status'];
?>

<select name="status" class="border p-1 rounded dark:bg-[#0F172A]">
<?php foreach($urutan as $key => $val): ?>
<option value="<?= $key ?>"
<?= $current == $key ? 'selected' : '' ?>
<?= ($urutan[$key] != $urutan[$current] + 1) ? 'disabled' : '' ?>>
<?= ucfirst($key) ?>
</option>
<?php endforeach; ?>
</select>

<button class="bg-blue-600 text-white px-2 rounded">
✔
</button>

</form>

</td>

</tr>

<?php } ?>
</tbody>

</table>

</div>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

<div class="bg-white dark:bg-[#1E293B] w-full max-w-lg p-6 rounded-2xl shadow-xl relative max-h-[90vh] overflow-y-auto">

<button onclick="closeModal()" class="absolute top-2 right-3 text-xl">✖</button>

<h2 class="text-xl font-bold mb-4">📋 Detail Pengaduan</h2>

<div class="space-y-3 text-sm">
<p><b>Judul:</b> <span id="m_judul"></span></p>
<p><b>Isi:</b> <span id="m_isi"></span></p>
<p><b>Status:</b> <span id="m_status"></span></p>
<p><b>Lokasi:</b> <span id="m_lokasi"></span></p>
<div class="mt-4">
    <h3 class="font-semibold mb-2">📊 Progres Pengaduan</h3>
    <div id="progressBox" class="space-y-2"></div>
</div>
<div id="m_gambar"></div>

<h3 class="font-semibold mt-3">💬 Percakapan</h3>
<div id="chatBox" class="max-h-48 overflow-y-auto"></div>
</div>

<form id="formKomentar" class="mt-3">
<input type="hidden" id="m_id">

<textarea id="komentar" required class="w-full border p-2 rounded dark:bg-[#0F172A]"></textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Kirim</button>
</form>

</div>
</div>

<script>
// DATATABLE
$(document).ready(function() {
    $('#myTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            zeroRecords: "Data tidak ditemukan"
        }
    });
});

// MODAL
function openModal(data){
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('m_id').value = data.id;
    document.getElementById('m_judul').innerText = data.judul;
    document.getElementById('m_isi').innerText = data.isi;
    document.getElementById('m_status').innerText = data.status;

    document.getElementById('m_lokasi').innerText =
        (data.nama_kecamatan ?? '-') + ', ' + (data.nama_desa ?? '-');
// LOAD PROGRESS
fetch('get_progres.php?id=' + data.id)
.then(res => res.text())
.then(html => {
    let box = document.getElementById('progressBox');

    box.innerHTML = html;

    // 🔥 paksa animasi ulang
    setTimeout(() => {
        let lines = box.querySelectorAll('.step-line');

        lines.forEach(el => {
            el.style.animation = 'none';
            el.offsetHeight; // trigger reflow
            el.style.animation = 'moveLine 2s linear infinite';
        });
    }, 50);
});

    fetch('get_chat.php?id=' + data.id)
    .then(res => res.text())
    .then(html => {
        document.getElementById('chatBox').innerHTML = html;
    });

    if(data.bukti){
        document.getElementById('m_gambar').innerHTML =
        `<img src="../assets/upload/${data.bukti}" class="mt-2 rounded">`;
    } else {
        document.getElementById('m_gambar').innerHTML = "";
    }
}

function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}

// KOMENTAR
document.getElementById('formKomentar').addEventListener('submit', function(e){
    e.preventDefault();

    let id = document.getElementById('m_id').value;
    let komentar = document.getElementById('komentar').value;

    fetch('tambah_komentar.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'pengaduan_id=' + id + '&komentar=' + encodeURIComponent(komentar)
    })
    .then(() => {
        fetch('get_chat.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('chatBox').innerHTML = html;
        });

        document.getElementById('komentar').value = '';
    });
});
</script>

</body>
</html>