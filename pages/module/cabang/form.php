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
        $address = filter($_POST['address']);
        $city = filter($_POST['city']);
        $phone = filter($_POST['phone']);
        
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        if (isset($_POST['Simpan'])) {
            $query = "INSERT INTO tb_branches (name, address, city, phone)
                    VALUES ('$name','$address','$city','$phone')";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil disimpan');
            } else {
                save_alert_swall('error', 'Data gagal disimpan');
            }
        } elseif (isset($_POST['Update'])) {
            
            $query = "UPDATE tb_branches SET 
            name='$name', 
            address='$address', 
            city='$city', 
            phone='$phone'  WHERE id='$idb'";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil diubah');
            } else {
                save_alert_swall('error', 'Data gagal diubah');
            }
        }
    } elseif (isset($_POST['Hapus'])) {
        $id = filter($_POST['id']);
        $delete = $conn->query("DELETE FROM tb_branches WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_branches WHERE id='$idb'")->fetch_assoc();

            $name = $data['name'];
            $address = $data['address'];
            $city = $data['city'];
            $phone = $data['phone'];
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
                            <label>Nama </label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Address </label>
                            <input type="text" name="address" class="form-control" value="<?= $address ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>City </label>
                            <input type="text" name="city" class="form-control" value="<?= $city ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Phone </label>
                            <input type="text" name="phone" class="form-control" value="<?= $phone ?>" required <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="?module=<?= $module ?>" class="btn btn-default">Batal</a>
                        <button type="submit" name="<?= $btn_name ?>" class="btn <?= $btn_color ?>"><?= $btn_name ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    }
}
?>
