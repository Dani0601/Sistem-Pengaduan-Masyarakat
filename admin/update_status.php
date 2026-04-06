<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$status_baru = $_POST['status'];

// ambil status lama
$q = mysqli_query($conn, "SELECT status FROM pengaduan WHERE id='$id'");
$d = mysqli_fetch_assoc($q);
$status_lama = $d['status'];

// urutan status
$urutan = [
    'pending' => 1,
    'ditinjau' => 2,
    'diproses' => 3,
    'selesai' => 4
];

// validasi harus urut
if($urutan[$status_baru] == $urutan[$status_lama] + 1){

    // update status utama
    mysqli_query($conn, "UPDATE pengaduan SET status='$status_baru' WHERE id='$id'");

    // simpan riwayat
    mysqli_query($conn, "
        INSERT INTO riwayat_status (pengaduan_id, status)
        VALUES ('$id', '$status_baru')
    ");

} else {
    echo "<script>alert('Status harus berurutan!');history.back();</script>";
}
header("Location: index.php?menu=pengaduan");
?>
