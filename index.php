<?php
error_reporting(E_ALL);
// スキャンするディレクトリ名
$scan_dir = "./data/";
//zipファイル出力先
$zip_dir = "./zip/";
// スキャンするディレクトリ
$files = scandir($scan_dir);
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
$zip_file = $zip_dir . $zip_file_name . $j . ".zip";
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$count = count($files);

foreach ($files as $file) {
    if ($file != '.' && $file != '..' && $file != '.DS_Store') {
        $tmp_filesize = filesize($scan_dir . $file);
        if (($filesize + $tmp_filesize) < $max_filesize) {
            $filesize += filesize($scan_dir . $file);
            $zip->addFile($scan_dir . $file, $file);
            echo $file . " " . $filesize . "\n";
        } else {
            echo $file . " " . ($filesize + $tmp_filesize) . "\n";
            //$filesize = 0;
            $filesize = $tmp_filesize;
            $j++;
            $zip->close();
            $zip_file = $zip_dir . $zip_file_name . $j . ".zip";
            $zip = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            $zip->addFile($scan_dir . $file, $file);
        }        
    }
    $i++;
    if ($count == $i) {
        $zip->close();
    }
}
?>