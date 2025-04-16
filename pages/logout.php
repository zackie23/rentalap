<?php

session_start();
include "../ch0npi9/koneksi.php";
include "../ch0npi9/library.php";
$sid_baru = session_id();
$conn->query("UPDATE tb_data_login SET time_logout ='$date_time' WHERE name_session ='$sid_baru'");

session_destroy();

echo "<script>alert('Anda telah keluar dari halaman administrator');</script>";
header('location:media.php?module=dashboard');
?>