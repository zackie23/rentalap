<?php
session_start();

if ($_SESSION['login'] == 1) {
    header('location:pages/dashboard');
}else{
    header('location:pages/auth');
}

?>