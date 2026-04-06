<?php
include 'config/koneksi.php';

$kota_ids = ['3209','3274'];

foreach($kota_ids as $kota_id){

    echo "<h3>Load Kecamatan $kota_id</h3>";

    $json = file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/districts/$kota_id.json");
    $data = json_decode($json, true);

    if(!$data){
        echo "❌ gagal kecamatan <br>";
        continue;
    }

    foreach($data as $k){

        $kec_id = $k['id'];
        $nama_kec = $k['name'];

        // simpan kecamatan
        mysqli_query($conn,"INSERT IGNORE INTO kecamatan VALUES('$kec_id','$nama_kec')");
        echo "✔ Kecamatan: $nama_kec <br>";

        // ======================
        // 🔥 LOAD DESA
        // ======================
        $json2 = file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/villages/$kec_id.json");
        $desa = json_decode($json2, true);

        if(!$desa){
            echo "❌ gagal desa ($nama_kec)<br>";
            continue;
        }

        foreach($desa as $d){

            $desa_id = $d['id'];
            $nama_desa = $d['name'];

            mysqli_query($conn,"
                INSERT IGNORE INTO desa (id, kecamatan_id, nama)
                VALUES('$desa_id','$kec_id','$nama_desa')
            ");
        }

        echo "→ ✔ Desa masuk <br>";
    }
}

echo "<h2>✅ PRELOAD SELESAI (KECAMATAN + DESA)</h2>";