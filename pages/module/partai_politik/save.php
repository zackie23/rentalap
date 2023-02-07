<?php

//error_reporting(0);
session_start();
if (empty($_SESSION['nama_partai']) AND empty($_SESSION['passuser'])) {
    header('location:../index.php');
} else {
    // deklarasikan variabel

    $idb = filter($_POST['id']);
    $id_key = base64_encrypt($idb, $key);
    $user_created = $_SESSION['email'];

    $nama_partai = filter(ucwords($_POST['nama_partai']));
    $singkatan = filter(strtoupper($_POST['singkatan']));
    $color = filter(strtoupper($_POST['color']));
    $status = filter($_POST['status']);
    $filename = $_FILES["file"]["name"];
    $uploads = uploadFile($singkatan, "image", 1000000, $module."/");

    if(isset($_GET['act']) && $_GET['act'] == "hapus"){
        $id = base64_decrypt(filter($_GET['id']), $key);
        $delete = $conn->Query("DELETE FROM tb_partai_politik where id_partai=".$id);
        pg_close($conn);
        if ($delete) {
            save_alert_swall('save', "Data berhasil dihapus");
        } else {
            save_alert_swall('error', "Data tidak berhasil dihapus");
        }
    }else{
        if ($idb == "") {
            //jika ada file yang diupload
            if($uploads["code"] == 0){
                $insert = $conn->query("INSERT INTO tb_partai_politik (nama_partai,singkatan,color,lambang,status,date_created,user_created) "
                . "VALUES ('$nama_partai','$singkatan','$color','$filename','$status',NOW(),'$user_created')");

                exec("gulp images:uploads");
                exec("gulp webpImage:uploads");
            }else{
                $insert = $conn->query("INSERT INTO tb_partai_politik (nama_partai,singkatan,color,status,date_created,user_created) "
                . "VALUES ('$nama_partai','$singkatan','$color','$status',NOW(),'$user_created')");
            }
            
            pg_close($conn);
            if ($insert) {
                save_alert_swall('save', "Data berhasil ditambahkan-");
                //htmlRedirect($module);
            } else {
                save_alert('error', "Data tidak berhasil ditambahkan");
                htmlRedirect($module . '?act=new');
            }
            
        } else {
            //jika ada file yang diupload
            if($uploads["code"] == 0){
                $whr .= "lambang = '$filename',"; 
                exec("gulp images:uploads");
                exec("gulp webpImage:uploads");
            }

            $update = $conn->query("UPDATE tb_partai_politik SET ".$whr." nama_partai='$nama_partai', singkatan = '$singkatan', color = '$color', status = '$status'  
            WHERE id_partai = '$idb'");
            pg_close($conn);
            if ($update) {
                save_alert('save', "Data berhasil diubah");
                htmlRedirect($module);
            } else {
                save_alert('error', "Data tidak berhasil diubah".$conn->error);

                htmlRedirect($module . '&act=edit&id=' . $id_key);
            }
        } 
    }
     
}
?>