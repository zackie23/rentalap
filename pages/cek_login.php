<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
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

    $link = getenv("REQUEST_URI");


    if(isset($_POST['submit']) && $_POST['submit'] == "login"){

        
        $sql = "SELECT email,t1.name,password,is_active,role_id, t3.name as role_name
        FROM tb_users t1 left join tb_user_roles t2 on t1.id = t2.user_id 
        left join tb_roles t3 on t2.role_id=t3.id
        WHERE email='$username' AND password='$pasacak' AND is_active=1";
        $hasil = $conn->query($sql);
        $ketemu = $hasil->num_rows;
        
        $r = $hasil->fetch_assoc();

        if ($ketemu > 0) {
            
            include "timeout.php";
            
            if ($r['status'] == 1) {
                $_SESSION['namastatus'] = "Aktif";
            }

            $_SESSION['id_user'] = $r['email'];
            $_SESSION['email'] = $r['email'];
            $_SESSION['namapengguna'] = $r['name'];
            $_SESSION['passuser'] = $r['password'];
            $_SESSION['idlevel'] = $r['role_id'];
            $_SESSION['status'] = $r['is_active'];
            $_SESSION['namalevel'] = $r['is_active'];
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
        $ketemu = $hasil->num_rows;
        $r = $hasil->fetch_assoc();

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
                $to      = $username; // Send email to our user
                $subject = 'Signup | Verification'; // Give the email a subject 
                $message = '

                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

                ------------------------
                Username: '.$username.'
                Password: '.$pass.'
                ------------------------

                Please click this link to activate your account:
                http://apps.bookingonline.com/pages/verify?email='.$username.'&hash='.$token.'

                '; // Our message above including the link
                                    
                $headers = 'From:noreply@bookingonline.com' . "\r\n"; // Set from headers
                $kirim = mail($to, $subject, $message, $headers);

                if($kirim){
                    $success = "Registrasi berhasil, Link konfirmasi email berhasil dikirim ke ".$username;
                }else{
                    $error = "Maaf, proses registrasi tidak berhasil!";
                }

                // $success = "Registrasi berhasil, Link konfirmasi email berhasil dikirim ke ".$username;
            }else{
                $conn->query("INSERT INTO tb_data_error (email,waktu,url,ip_address) VALUES ('$username',NOW(),'$link;Registration Failed!','$ip;$browser') ");
                $error = "Maaf, proses registrasi tidak berhasil!";
            }
        }

    }elseif(isset($_POST['submit']) && $_POST['submit'] == "signup_venue"){
        //mengecek apakah email sudah terdaftar atau belum.
        $sql = "SELECT * FROM tb_users WHERE email='$username'";
        $hasil = $conn->query($sql);
        $ketemu = $hasil->num_rows;
        $r = $hasil->fetch_assoc();

        if ($ketemu > 0) {
            // Email terdaftar arahkan user untuk login /auth
            $error = "Maaf! Email sudah terdaftar, silahkan login.";
        } else {
            if (isset($_COOKIE['referral'])) {
                $referral = $_COOKIE['referral'];
            } else {
                $referral = "";
            }

            $nama_lengkap   = anti_injection($_POST['nama_lengkap']);
            $business_name  = anti_injection($_POST['business_name']);
            $no_handphone   = anti_injection($_POST['no_handphone']);
            $username       = anti_injection($username);
            $pasacak        = anti_injection($pasacak);

            $conn->begin_transaction();

            try {
                // Simpan user
                $query = "INSERT INTO tb_users (email, password, name, phone) 
                        VALUES ('$username', '$pasacak', '$nama_lengkap', '$no_handphone')";
                if (!$conn->query($query)) {
                    throw new Exception("Gagal mendaftarkan user: " . $conn->error);
                }

                // Ambil ID user baru
                $new_user_id = $conn->insert_id;

                // Simpan data owner
                $query_owner = "INSERT INTO tb_owners (user_id, business_name) 
                                VALUES ('$new_user_id', '$business_name')";
                if (!$conn->query($query_owner)) {
                    throw new Exception("Gagal menyimpan data owner: " . $conn->error);
                }

                // Commit transaksi
                $conn->commit();
                $success = "Loading..";

            } catch (Exception $e) {
                // Rollback jika gagal
                $conn->rollback();
                $conn->query("INSERT INTO tb_data_error (email, waktu, url, ip_address) 
                            VALUES ('$username', NOW(), '$link;Registration Failed!', '$ip;$browser')");
                $error = "Maaf, proses registrasi tidak berhasil!";
            }
        }

    }elseif(isset($_POST['submit']) && $_POST['submit'] == "reset"){

    }
}else{
    $error = "Token tidak valid.";
}

ob_clean();
header('Content-Type: application/json');
if (!empty($error)) {
    echo json_encode(array("error" => $error,"url" => $url_awal));
} else {
    echo json_encode(array("success" => $success,"url" => $url_awal));
}

exit;

?>