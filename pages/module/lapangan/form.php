<?php
error_reporting(0);
session_start();

if (count(get_included_files()) == 1) {
    echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]'>";
    exit("Direct access not permitted.");
}

if (empty($_SESSION['id_user']) && empty($_SESSION['passuser'])) {
    header('location:../index.php');
} else {
    
    
    if (isset($_POST['Update']) || isset($_POST['Simpan'])) {
        $idb = filter($_POST['id']);
        $id_key = base64_encrypt($idb, $key);

        $name = filter($_POST['name']);
        $sport_type = filter($_POST['sport_type']);
        $hourly_price = filter($_POST['hourly_price']);
        $image_url = filter($_POST['image_url']);
        $active = filter($_POST['active']);
        $branch_id = filter($_POST['branch_id']);
        
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

          // === UPLOAD IMAGE ===
        $uploadDir   = '../uploads/';  
            if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
            }

            if (!empty($_FILES['image_url']['name']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $tmpName   = $_FILES['image_url']['tmp_name'];
                $origName  = basename($_FILES['image_url']['name']);
                $ext       = pathinfo($origName, PATHINFO_EXTENSION);
                // Buat nama unik
                $newName   = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext; 
                $destPath  = $uploadDir . $newName;
        
                if (move_uploaded_file($tmpName, $destPath)) {
                    // Simpan hanya relative path ke database, misal "uploads/12345_abcdef.jpg"
                    $image_url = 'uploads/' . $newName;
                } else {
                    save_alert_swall('error', 'Gagal memindahkan file gambar.');
                    // fallback, bisa set $image_url = NULL atau biarkan $image_url lama
                }
            }


        

        if (isset($_POST['Simpan'])) {
            $query = "INSERT INTO tb_fields (name, sport_type, hourly_price, image_url, active, branch_id)
                    VALUES ('$name','$sport_type','$hourly_price','$image_url','$active','$branch_id')";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil disimpan');
            } else {
                save_alert_swall('error', 'Data gagal disimpan');
            }
            
        } elseif (isset($_POST['Update'])) {
            $query = "UPDATE tb_fields SET 
            name='$name', 
            sport_type='$sport_type', 
            hourly_price='$hourly_price', 
            image_url='$image_url',  
            active = '$active',
            branch_id= '$branch_id'  WHERE id='$idb'";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil diubah');
            } else {
                save_alert_swall('error', 'Data gagal diubah');
            }
        }
    } elseif (isset($_POST['Hapus'])) {
        $id = filter($_POST['id']);
        $delete = $conn->query("DELETE FROM tb_fields WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_fields WHERE id='$idb'")->fetch_assoc();

            $name = $data['name'];
            $sport_type = $data['sport_type'];
            $hourly_price = $data['hourly_price'];
            $active= $data['active'];
            $branch_id= $data['branch_id'];
            $image_url = '../'.$data['image_url'];
            $created_by = $data['created_by'];
        } else {
            $idb = "";
            $name = "";
            $email = "";
            $phone = "";
            $google_id = "";
            $is_active = 1;
            $avatar_url = "";
        }
?>
    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="<?= $url_action ?>" enctype="multipart/form-data">
                <input type="hidden" name="token_csrf" value="<?= $_SESSION['token_csrf'] ?>">
                <input type="hidden" name="id" value="<?= $idb ?>">
                <div class="card">
                    <div class="card-header"><h5 class="text-muted"><?= $title ?></h5><hr></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Cabang</label>
                            <select name="branch_id" class="form-control" <?= $readonly ?>>
                            <?php
                                    $query = "SELECT * from tb_branches";
                                    $exec = $conn->query($query);
                                    while($row = $exec->fetch_assoc()){
                                        if($branch_id == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                                        }else{
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama </label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Sport type </label>
                            <input type="text" name="sport_type" class="form-control" value="<?= $sport_type ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Hourly price </label>
                            <input type="text" name="hourly_price" class="form-control" value="<?= $hourly_price ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>upload gambar </label>
                            <input type="file" name="image_url" class="form-control" value="<?= $image_url ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>active </label>
                            <select name="active" class="form-control" value="<?= $active?>" <?= $readonly ?>>
                                    <option value="Active" <?= $active == 'Active' ? "selected" : "" ?>>Active</option>
                                    <option value="Tidak Active" <?= $active == 'Tidak Active' ? "selected" : "" ?>>Tidak Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="?module=<?= $module ?>" class="btn btn-default">Batal</a>
                        <button type="submit" name="<?= $btn_name ?>" class="btn <?= $btn_color ?>"><?= $btn_name ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
        <?php if (!empty($image_url) && file_exists($image_url)): ?>
            <img src="<?= $image_url ?>" alt="Preview Gambar" style="width:100%;">
        <?php endif; ?>
        </div>    
    </div>
<?php
    }
}
?>
