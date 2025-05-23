<?php
date_default_timezone_set('Asia/Hong_Kong');

// Deteksi hanya bisa diinclude, tidak bisa langsung dibuka (direct open)
// if (count(get_included_files()) == 1) {
//     echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]'>";
//     exit("Direct access not permitted.");
// }
// panggil fungsi validasi xss dan injection
require_once("fungsi_validasi.php");

define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "db_rentalapp");

$acak1 = "rental";
$acak2 = "lapangan";

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($conn->connect_error) {
    trigger_error("Koneksi ke database gagal: " . $conn->connect_error, E_USER_ERROR);
}

$inactive = 600; // Set timeout period in seconds
if (isset($_SESSION['timeout'])) {
   $session_life = time() - $_SESSION['timeout'];
   if ($session_life > $inactive) {
       header("Location: logout.php");
   }
}

function url_origin($s, $use_forwarded_host = false) {
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url($s, $use_forwarded_host = false) {
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

$absolute_url = full_url($_SERVER);

$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];



?>