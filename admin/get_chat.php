<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$chat = mysqli_query($conn, "
SELECT * FROM komentar 
WHERE pengaduan_id='$id'
ORDER BY tanggal ASC
");

while($c = mysqli_fetch_assoc($chat)){
?>

<div class="<?= $c['role']=='admin' ? 'text-right' : 'text-left' ?> mb-2">

    <div class="<?= $c['role']=='admin' 
        ? 'bg-blue-600 text-white ml-auto' 
        : 'bg-gray-200 text-black' ?> 
        inline-block px-3 py-2 rounded-lg max-w-xs break-words">

        <b><?= $c['role']=='admin' ? 'Admin' : 'User' ?></b><br>
        <?= $c['komentar'] ?>
    </div>

</div>

<?php } ?>