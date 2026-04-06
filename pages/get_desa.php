<?php
include '../config/koneksi.php';

$kecamatan_id = isset($_GET['kecamatan_id']) ? intval($_GET['kecamatan_id']) : null;
$kecamatan    = isset($_GET['kecamatan']) ? mysqli_real_escape_string($conn, $_GET['kecamatan']) : null;

echo "<option value=''>-- Pilih Desa --</option>";

// kalau kirim ID langsung
if($kecamatan_id){

    $data = mysqli_query($conn, "
        SELECT * FROM desa 
        WHERE kecamatan_id='$kecamatan_id'
        ORDER BY nama ASC
    ");

    while($d = mysqli_fetch_assoc($data)){
        echo "<option value='{$d['id']}'>{$d['nama']}</option>";
    }

}

// kalau kirim nama kecamatan
else if($kecamatan){

    $kec = mysqli_query($conn, "
        SELECT id FROM kecamatan 
        WHERE nama='$kecamatan'
    ");

    $k = mysqli_fetch_assoc($kec);

    if($k){
        $data = mysqli_query($conn, "
            SELECT * FROM desa 
            WHERE kecamatan_id='{$k['id']}'
            ORDER BY nama ASC
        ");

        while($d = mysqli_fetch_assoc($data)){
            echo "<option value='{$d['id']}'>{$d['nama']}</option>";
        }
    }
}
?>