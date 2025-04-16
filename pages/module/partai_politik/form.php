<?php
error_reporting(0);
session_start();
//Deteksi hanya bisa diinclude, tidak bisa langsung dibuka (direct open)
if (count(get_included_files()) == 1) {
    echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]'>";
    exit("Direct access not permitted.");
}

if (empty($_SESSION['id_user']) AND empty($_SESSION['passuser'])) {
    header('location:../index.php');
} else {
    

    if(isset($_POST['Update']) OR isset($_POST['Simpan'])){
        //INSER UPDATE
        $idb = filter($_POST['id']);
        $id_key = base64_encrypt($idb, $key);
        $user_created = $_SESSION['email'];

        $nama_partai = filter(ucwords($_POST['nama_partai']));
        $singkatan = filter(strtoupper($_POST['singkatan']));
        $color = filter(strtoupper($_POST['color']));
        $status = filter($_POST['status']);
        $filename = $_FILES["file"]["name"];
        $uploads = uploadFile($filename, "image", 1000000, $module."/");
        
        if(isset($_POST['Simpan'])){

        }elseif(isset($_POST['Update'])){
            if($uploads["code"] == 0){
                $whr .= "lambang = '$filename',"; 
                exec("gulp webpImage:uploads");
            }

            $update = $conn->query("UPDATE tb_partai_politik SET ".$whr." nama_partai='$nama_partai', singkatan = '$singkatan', color = '$color', status = '$status'  
            WHERE id_partai = '$idb'");
            $conn->close();
            if ($update) {
                save_alert_swall('save', "Data berhasil diubah");
            } else {
                save_alert_swall('error', "Data tidak berhasil diubah ".$conn->error);
            }
        }
    }elseif(isset($_POST['Hapus'])){
        //DELETE
        $id = filter($_POST['id']);
        $delete = $conn->Query("DELETE FROM tb_partai_politik where id_partai=".$id);
        $conn->close();
        if ($delete) {
            save_alert_swall('save', "Data berhasil dihapus");
        } else {
            save_alert_swall('error', "Data tidak berhasil dihapus");
        }
    }else{
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $sql = $conn->query("SELECT * FROM tb_partai_politik WHERE id_partai='$idb'");
            $data = $sql->fetch_assoc();
            $nama_partai = $data['nama_partai'];
            $singkatan = $data['singkatan'];
            $color = $data['color'];
            $status = $data['status'];
            $lambang = explode(".",$data['lambang']);
            $lambang = ($lambang[0] !="") ? "../dist/pictures/partai_politik/".$lambang[0].".webp" : "https://via.placeholder.com/150";
        } else {
            $nama_partai = "";
            $singkatan = "";
            $color = "";
            $status = "";
            $lambang = "https://via.placeholder.com/150";
        }
    }
    ?>
    <div class="row">
        
            <div class="col-9">
                <form method="POST" action="<?=$url_action?>" enctype="multipart/form-data">
                <input type="hidden" name="token_csrf" value="<?=$_SESSION['token_csrf']?>">
                <input type="hidden" name="id" value="<?=$idb?>">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-muted"><?=$title?></h5>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Nama Partai</label>
                                <input type="text" class="form-control" id="nama_partai" name="nama_partai" value="<?=$nama_partai?>" placeholder="Nama Partai" required <?=$readonly?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Singkatan</label>
                                <input type="text" class="form-control" id="singkatan" name="singkatan" value="<?=$singkatan?>" placeholder="Singkatan"  required <?=$readonly?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Warna</label>
                                <input type="text" class="form-control" id="color" name="color" value="<?=$color?>" placeholder="Warna Partai"  required <?=$readonly?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Logo Partai</label>
                                <input type="file" class="form-control" id="file" name="file" placeholder="Logo Partai" <?=$readonly?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" placeholder="Tampilkan/Sembunyikan" required <?=$readonly?>>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                                <script type="text/javascript">
                                    var status = <?= json_encode($status);?>;
                                    document.getElementById("status").value = status;
                                </script>
                            </div>     
                        </div>
                        <div class="card-footer">
                            <a href="?module=<?= $module; ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" name="<?=$btn_name?>" class="btn <?=$btn_color?>"><?=$btn_name?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-muted">Lambang Partai Politik</h5>
                        <hr>
                    </div>
                    <div class="card-body">
                        <img src="<?=$lambang?>" width="100%" alt="">
                    </div>
                </div>
            </div>
    </div>
    
    <?php
}