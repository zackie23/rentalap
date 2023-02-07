<?php
session_start();
error_reporting(0);
include '../ch0npi9/koneksi.php';
include '../ch0npi9/library.php';
include '../ch0npi9/function.php';

function anti_injection($data) {
    $filter = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
    return $filter;
}



if(isset($_SESSION['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
    //Token Valid

    $username = anti_injection($_POST['email']);
    $pass = anti_injection($_POST['password']);
    $url_awal = anti_injection($_POST['url_awal']);
    $pasacak = md5($acak1 . md5($pass) . $acak2);
    $token = anti_injection($_POST['csrf_token']);

    $link = apache_getenv("REQUEST_URI");


    if(isset($_POST['submit']) && $_POST['submit'] == "login"){

        
        $sql = "SELECT * FROM tb_user WHERE email='$username' AND password='$pasacak' AND status=1";
        $hasil = $conn->query($sql);
        $ketemu = $hasil->rowCount();
        
        $r = $hasil->fetch(PDO::FETCH_ASSOC);

        if ($ketemu > 0) {
            
            include "timeout.php";
            
            if ($r['status'] == 1) {
                $_SESSION['namastatus'] = "Aktif";
            }

            $_SESSION['id_user'] = $r['email'];
            $_SESSION['email'] = $r['email'];
            $_SESSION['namapengguna'] = $r['nama_lengkap'];
            $_SESSION['passuser'] = $r['password'];
            $_SESSION['idlevel'] = $r['id_level'];
            $_SESSION['status'] = $r['status'];
            $_SESSION['namalevel'] = getUserLevel($r['id_level']);
            // session timeout
            $_SESSION['login'] = 1;
            timer();

            $sid_lama = session_id();
            session_regenerate_id();
            $sid_baru = session_id();

            $_SESSION['name_session'] = $sid_baru;
            $tgl_skrg = DATE("Y-m-d");
            $time_skrg = DATE("H:i:s");
            
            $conn->query("INSERT INTO tb_data_login (name_session,email,time_login,ip_address,type_browser) VALUES ('$sid_baru','$_SESSION[id_user]','$date_time','$ip','$browser')");

            $success = "Loading..";
        } else {
            
            $conn->query("INSERT INTO tb_data_error (email,waktu,url,ip_address) VALUES ('$username','$date_time','$link $username;$pass','$ip;$browser') ");
            
            $error = "Maaf, User/password tidak sesuai ";
        }
    }elseif(isset($_POST['submit']) && $_POST['submit'] == "signup"){
        //mengecek apakah email sudah terdaftar atau belum.
        $sql = "SELECT * FROM tb_user WHERE email='$username'";

        $hasil = $conn->query($sql);
        $ketemu = $hasil->rowCount();
        $r = $hasil->fetch(PDO::FETCH_ASSOC);

        if ($ketemu > 0) {
            //email terdaftar arahkan user untuk login /auth
            $error = "Maaf! Email sudah terdaftar, silahkan login.  ";
        }else{
            if (isset($_COOKIE['referral'])) {
                $referral = $_COOKIE['referral'];
            }else{
                $referral = "";
            }
            $nama_lengkap = anti_injection($_POST['nama_lengkap']);
            $no_handphone = anti_injection($_POST['no_handphone']);

            $insert = $conn->query("INSERT into tb_user (email,password,nama_lengkap,no_handphone,token,referral) 
                                 VALUES ('$username','$pasacak','$nama_lengkap','$no_handphone','$token','$referral')");
            
            if($insert){
                //Kirim Email Konfirmasi Ke User!
                
                $success = "Registrasi berhasil, Link konfirmasi email berhasil dikirim ke ".$username;
            }else{
                $conn->query("INSERT INTO tb_data_error (email,waktu,url,ip_address) VALUES ('$username',NOW(),'$link;Registration Failed!','$ip;$browser') ");
                $error = "Maaf, proses registrasi tidak berhasil!";
            }
        }

    }elseif(isset($_POST['submit']) && $_POST['submit'] == "reset"){

    }
    
    pg_close($conn);
}else{
    $error = "Token tidak valid.";
}

header('Content-Type: application/json');
if (!empty($error)) {
    echo json_encode(array("error" => $error,"url" => $url_awal));
} else {
    echo json_encode(array("success" => $success,"url" => $url_awal));
}

exit;

?>