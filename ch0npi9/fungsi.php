<?php

//Deteksi hanya bisa diinclude, tidak bisa langsung dibuka (direct open)
if (count(get_included_files()) == 1) {
    echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]'>";
    exit("Direct access not permitted.");
}

//status informasi pada saat eksekusi database
function alert($type, $text = null) {
    if ($type == 'info') {
        echo "<font color='white'><div class='infofly go-front' id='status'>$text</div></font>";
    } else if ($type == 'error') {
        echo "<font color='white'><div class='errorfly go-front' id='status'>$text</div></font>";
    } else if ($type == 'download') {
        echo "<font color='black'><center>$text</center></font>";
    } else if ($type == 'loading')
        echo "<div id='loading'><center>$text</center></div>";
}

function login_alert($type, $text = null) {
    if ($type == 'info') {
        echo "<font color='black'><div class='infofly info_login' id='status'>$text</div></font>";
    } else if ($type == 'error') {
        echo "<font color='black'><div class='errorfly error_login' id='status'>$text</div></font>";
    } else if ($type == 'loading')
        echo "<div id='loading'><center>$text</center></div>";
}

function save_alert($type, $text = null) {
    if ($type == 'save') {
        echo"<div class='box-body'><div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><b> BERHASIL!</b> $text</div></div>";
    } else if ($type == 'error') {
        echo"<div class='box-body'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><b> ERROR!</b> $text</div></div>";
    } else if ($type == 'delete') {
        echo"<div class='box-body'><div class='alert alert-danger alert-dismissable'><i class='fa fa-warning'></i><b> BERHASIL!</b> $text</div></div>";
    } else if ($type == 'update')
        echo"<div class='box-body'><div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><b> BERHASIL!</b> $text</div></div>";
}

function save_alert_swall($type, $text = null) {
    if ($type == 'save') {
        echo '<div id="notif_save" class="d-none">'.$text.'</div>';
    } else if ($type == 'error') {
        echo '<div id="notif_error" class="d-none">'.$text.'</div>';
    } else if ($type == 'image') {
        echo '<div id="notif_uploading" class="d-none">'.$text.'</div>';
    }
        
}

//fungsi redirect menggunakan php
function redirect($url) {
    header("location:" . $url);
}

//fungsi redirect menggunakan html
function htmlRedirect($link, $time = null) {
    if ($time)
        $time = $time;
    else
        $time = 1;
    echo "<meta http-equiv='REFRESH' content='$time; url=$link'>";
}

//fungsi redirect menggunakan html
function LongRedirect($link, $time = null) {
    if ($time)
        $time = $time;
    else
        $time = 5;
    echo "<meta http-equiv='REFRESH' content='$time; url=$link'>";
}

//fungsi redirect menggunakan html
function Redirect_Login($link, $time = null) {
    if ($time)
        $time = $time;
    else
        $time = 2;
    echo "<meta http-equiv='REFRESH' content='$time; url=$link'>";
}

//fungsi redirect menggunakan html
function dlRedirect($link, $time = null) {
    if ($time)
        $time = $time;
    else
        $time = 5;
    echo "<meta http-equiv='REFRESH' content='$time; url=$link'>";
}

function antiinjection($data) {
    $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter_sql;
}

function filter($data) {
    $data = trim(htmlentities(strip_tags($data)));

    if (get_magic_quotes_gpc())
        $data = stripslashes($data);

    //$data = mysql_real_escape_string($data);

    return $data;
}

$magic = array("bounce", "pulse",
    "bounceInRight", "bounceInDown", "fadeIn", "fadeInRightBig");
$rand_magic = array_rand($magic);
?>
