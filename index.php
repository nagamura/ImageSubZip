<?php
error_reporting(E_ALL);

// スキャンするディレクトリ名
$scan_dir = "./data/";
//zipファイル出力先
$zip_dir = "./zip/";
// スキャンするディレクトリ
$files = glob($scan_dir . "*.jpg");
// 50MBまで
$max_filesize = 52428800;
// 5MBまで(テスト)
//$max_filesize = 5242880;

// init filesize
$filesize = 0;

$i = 0;
$j = 1;

$zip = new ZipArchive();
$zip_file_name = 'img-';
$img_dir = "img-" . $j;
mkdir($zip_dir . $img_dir, 0777);
$zip_file = "img.zip";
$zip->open($zip_dir . $img_dir . '/' . $zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$count = count($files);

foreach ($files as $file) {
    $tmp_filesize = filesize($file);
    if (($filesize + $tmp_filesize) < $max_filesize) {
        $filesize += filesize($file);
        $zip->addFile($file, basename($file));
        echo $file . " " . $filesize . "\n";
    } else {
        echo $file . " " . ($filesize + $tmp_filesize) . "\n";
        $filesize = $tmp_filesize;
        $j++;
        $zip->close();
        $img_dir = "img-" . $j;
        mkdir($zip_dir . $img_dir, 0777);
        $zip = new ZipArchive();
        $zip->open($zip_dir . $img_dir . '/' .$zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile($file, basename($file));
    }
    $i++;
    if ($count == $i) {
        $zip->close();
    }
}