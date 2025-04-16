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
    $idb = filter($_POST['id']);
    $id_key = base64_encrypt($idb, $key);
    
    if (isset($_POST['Update']) || isset($_POST['Simpan'])) {
        

        $name = filter($_POST['name']);
        $email = filter($_POST['email']);
        $phone = filter($_POST['phone']);
        $google_id = filter($_POST['google_id']);
        $is_active = filter($_POST['is_active']);
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        // Hash password jika ada
        $password = md5($acak1 . md5($filter($_POST['password'])) . $acak2);

        // Upload avatar
        $filename = $_FILES["avatar"]["name"];
        $uploads = uploadFile($filename, "image", 1000000, $module . "/");
        $avatar_url = ($uploads["code"] == 0) ? $uploads["file_url"] : "";

        if (isset($_POST['Simpan'])) {
            $query = "INSERT INTO tb_users (name, email, password, phone, google_id, avatar_url, is_active, created_by, updated_by)
                VALUES ('$name', '$email', " . ($password ? "'$password'" : "NULL") . ", '$phone', '$google_id', '$avatar_url', '$is_active', '$created_by', '$updated_by')";
            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil disimpan');
            } else {
                save_alert_swall('error', 'Data gagal disimpan');
            }
        } elseif (isset($_POST['Update'])) {
            $q_password = $password ? ", password='$password'" : "";
            $q_avatar = !empty($avatar_url) ? ", avatar_url='$avatar_url'" : "";

            $query = "UPDATE tb_users SET name='$name', email='$email', phone='$phone', google_id='$google_id', is_active='$is_active', updated_by='$updated_by' $q_password $q_avatar WHERE id='$idb'";
            $exec = $conn->query($query);

            echo $query;
            // if ($exec) {
            //     save_alert_swall('save', 'Data berhasil diubah');
            // } else {
            //     save_alert_swall('error', 'Data gagal diubah');
            // }
        }
    } elseif (isset($_POST['Hapus'])) {
        $id = filter($_POST['id']);
        $delete = $conn->query("DELETE FROM tb_users WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_users WHERE id='$idb'")->fetch_assoc();

            $name = $data['name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $google_id = $data['google_id'];
            $is_active = $data['is_active'];
            $avatar_url = $data['avatar_url'];
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
        <div class="col-md-9">
            <form method="POST" action="<?= $url_action ?>" enctype="multipart/form-data">
                <input type="hidden" name="token_csrf" value="<?= $_SESSION['token_csrf'] ?>">
                <input type="hidden" name="id" value="<?= $idb ?>">
                <div class="card">
                    <div class="card-header"><h5 class="text-muted"><?= $title ?></h5><hr></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $email ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="phone" class="form-control" value="<?= $phone ?>" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" class="form-control" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Google ID</label>
                            <input type="text" name="google_id" class="form-control" value="<?= $google_id ?>" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Foto / Avatar</label>
                            <input type="file" name="avatar" class="form-control" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control" <?= $readonly ?>>
                                <option value="1" <?= $is_active == 1 ? "selected" : "" ?>>Aktif</option>
                                <option value="0" <?= $is_active == 0 ? "selected" : "" ?>>Tidak Aktif</option>
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
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h5 class="text-muted">Foto Profil</h5><hr></div>
                <div class="card-body text-center">
                    <img src="<?= $avatar_url ?: 'https://via.placeholder.com/150' ?>" class="img-thumbnail" width="100%">
                </div>
            </div>
        </div>
    </div>
<?php
    }
}
?>
