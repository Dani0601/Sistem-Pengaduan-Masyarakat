<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// buat captcha
$text = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz'), 0, 2);
$_SESSION['captcha'] = $text;

// buat gambar
$width = 120;
$height = 40;
$image = imagecreate($width, $height);

// warna
$bg = imagecolorallocate($image, 240, 240, 240);
$textColor = imagecolorallocate($image, 0, 0, 0);
$lineColor = imagecolorallocate($image, 100, 100, 100);

// garis gangguan
for($i=0;$i<5;$i++){
    imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $lineColor);
}

// tulis teks captcha
imagestring($image, 5, 30, 10, $text, $textColor);

// header
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>