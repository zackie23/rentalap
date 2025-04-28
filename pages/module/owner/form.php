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
        $roles = filter($_POST['roles']);

        $is_active = filter($_POST['is_active']);
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        // Hash password jika ada
        $password = md5($acak1 . md5(filter($_POST['password'])) . $acak2);

        // Upload avatar
        $filename = $_FILES["avatar"]["name"];
        $uploads = uploadFile($filename, "image", 1000000, $module . "/");
        $avatar_url = ($uploads["code"] == 0) ? $uploads["file_url"] : "";

        if (isset($_POST['Simpan'])) {
            // Mulai transaksi
            $conn->begin_transaction();

            try {
                // Simpan user
                $query = "INSERT INTO tb_users (name, email, password, phone, google_id, avatar_url, is_active, created_by, updated_by)
                        VALUES ('$name', '$email', '$password', '$phone', '$google_id', '$avatar_url', '$is_active', '$created_by', '$updated_by')";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal menyimpan user: " . $conn->error);
                }

                // Ambil ID user
                $new_user_id = $conn->insert_id;


                $query_role = "INSERT INTO tb_user_roles (user_id, role_id, created_by, updated_by)
                            VALUES ('$new_user_id', '$roles', '$created_by', '$updated_by')";

                if (!$conn->query($query_role)) {
                    throw new Exception("Gagal menyimpan role: " . $conn->error);
                }

                // Commit transaksi jika semua berhasil
                $conn->commit();
                save_alert_swall('save', 'Data berhasil disimpan');

            } catch (Exception $e) {
                // Rollback jika terjadi kesalahan
                $conn->rollback();
                save_alert_swall('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }

        } elseif (isset($_POST['Update'])) {
            // Mulai transaksi
            $conn->begin_transaction();

            try {
                $q_password = ($_POST['password'] != "") ? ", password='$password'" : "";
                $q_avatar   = !empty($avatar_url) ? ", avatar_url='$avatar_url'" : "";

                // Update tb_users
                $query = "UPDATE tb_users 
                        SET name='$name', email='$email', phone='$phone', google_id='$google_id', is_active='$is_active', updated_by='$updated_by'
                        $q_password $q_avatar 
                        WHERE id='$idb'";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal update user: " . $conn->error);
                }

                // Update tb_user_roles (asumsi kamu ingin ganti role-nya juga)
                $query_check_role = "SELECT id FROM tb_user_roles WHERE user_id = '$idb'";
                $result_check = $conn->query($query_check_role);

                if ($result_check->num_rows > 0) {
                    // Sudah ada -> update role
                    $query_role = "UPDATE tb_user_roles 
                                SET role_id = '$roles', updated_by = '$updated_by' 
                                WHERE user_id = '$idb'";
                } else {
                    // Belum ada -> insert baru
                    $query_role = "INSERT INTO tb_user_roles (user_id, role_id, created_by, updated_by)
                                VALUES ('$idb', '$role_id', '$updated_by', '$updated_by')";
                }

                if (!$conn->query($query_role)) {
                    throw new Exception("Gagal update/insert role: " . $conn->error);
                }

                // Commit transaksi
                $conn->commit();
                save_alert_swall('save', 'Data berhasil diupdate');

            } catch (Exception $e) {
                // Rollback jika ada error
                $conn->rollback();
                save_alert_swall('error', 'Gagal update data: ' . $e->getMessage());
            }

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
                            <label>Roles</label>
                            <select name="roles" class="form-control" <?= $readonly ?>>
                                <?php
                                    $query = "SELECT * from tb_roles";
                                    $exec = $conn->query($query);
                                    while($row = $exec->fetch_assoc()){
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    }
                                ?>
                            </select>
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
