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
        
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        if (isset($_POST['Simpan'])) {
            $query = "INSERT INTO tb_roles (name, created_at,created_by, updated_by)
                    VALUES ('$name', NOW() ,'$created_by', '$updated_by')";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil disimpan');
            } else {
                save_alert_swall('error', 'Data gagal disimpan');
            }
        } elseif (isset($_POST['Update'])) {
            
            $query = "UPDATE tb_roles SET name='$name' WHERE id='$idb'";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil diubah');
            } else {
                save_alert_swall('error', 'Data gagal diubah');
            }
        }
    } elseif (isset($_POST['Hapus'])) {
        $id = filter($_POST['id']);
        $delete = $conn->query("DELETE FROM tb_roles WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_roles WHERE id='$idb'")->fetch_assoc();

            $name = $data['name'];
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
                            <label>Nama Roles</label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
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
