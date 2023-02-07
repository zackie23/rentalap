<?php
// error_reporting(0);
session_start();
defined('_NOT_DIRECT') || define('_NOT_DIRECT', 1);

include '../../ch0npi9/koneksi.php';

$sql = $conn->query("SELECT wilayah_id as id_provinsi, nama as provinsi FROM tb_provinsi ORDER BY wilayah_id");

while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    
    $sql2 = $conn->query("SELECT wilayah_id as id_kabkota, nama as kabkota FROM tb_kabkota where parent=".$row['id_provinsi']);

    while($row2 = $sql2->fetch(PDO::FETCH_ASSOC)){
           

        $sql3 = $conn->query("SELECT wilayah_id as id_kecamatan, nama as nama_kecamatan FROM tb_kecamatan where parent=".$row2['id_kabkota']." ORDER BY wilayah_id");

        while($row3 = $sql3->fetch(PDO::FETCH_ASSOC)){
            $row2['kecamatan'][] = $row3;   
        }

        $row['kabupaten_kota'][] = $row2; 
    }

    $output['wilayah'][] = $row;
}

// echo json_encode($output);
$file = 'wilayah.json';
file_put_contents($file, json_encode($output));
?>