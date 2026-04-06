<?php
include '../config/koneksi.php';

$id = $_GET['id'];

// ambil data
$q = mysqli_query($conn, "
SELECT status, tanggal 
FROM riwayat_status 
WHERE pengaduan_id='$id'
ORDER BY tanggal ASC
");

$data = [];
while($d = mysqli_fetch_assoc($q)){
    $data[$d['status']] = $d['tanggal'];
}

$steps = ['pending', 'ditinjau', 'diproses', 'selesai'];

// cari step aktif
$current_step = 0;
foreach($steps as $i => $s){
    if(isset($data[$s])){
        $current_step = $i;
    }
}

// icon tiap step
$icons = [
    'pending'   => '⏳',
    'ditinjau'  => '🔍',
    'diproses'  => '⚙️',
    'selesai'   => '✅'
];

echo "<div class='flex items-center justify-between w-full'>";

foreach($steps as $i => $step){

    // kondisi
    if($i < $current_step){
        $circle = "bg-green-500 text-white step-done";
        $line   = "bg-green-500";
    } elseif($i == $current_step){
        $circle = "bg-blue-500 text-white step-active";
        $line   = "step-line";
    } else {
        $circle = "bg-gray-300 text-gray-500";
        $line   = "bg-gray-300";
    }

    echo "<div class='flex-1 flex flex-col items-center relative'>";

    // garis
    if($i != count($steps)-1){
        echo "<div class='absolute top-4 left-1/2 w-full h-1 $line z-0'></div>";
    }

    // circle + icon
    echo "<div class='w-10 h-10 flex items-center justify-center rounded-full text-lg $circle transition-step z-10'>
            ".$icons[$step]."
          </div>";

    // label
    echo "<p class='text-xs mt-2 font-medium'>".strtoupper($step)."</p>";

    // tanggal
    if(isset($data[$step])){
        echo "<p class='text-[10px] text-gray-400'>"
        .date('d M H:i', strtotime($data[$step]))."</p>";
    } else {
        echo "<p class='text-[10px] text-gray-300'>-</p>";
    }

    echo "</div>";
}

echo "</div>";
?>