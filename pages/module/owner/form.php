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
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $business_name = $_POST['business_name'];
        $status = $_POST['status'];
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        // Hash password jika ada
        $password = md5($acak1 . md5(filter($_POST['password'])) . $acak2);


        if (isset($_POST['Simpan'])) {
            // Mulai transaksi
            $conn->begin_transaction();

            try {
                // Simpan user
                $query = "INSERT INTO tb_users
                                (name, email, password, phone, is_active, created_by, updated_by)
                        VALUES ('$name', '$email', '$password', '$phone', 1, '$created_by', '$updated_by')";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal menyimpan user: " . $conn->error);
                }

                // Ambil ID user
                $new_user_id = $conn->insert_id;


                $query_role = "INSERT INTO tb_user_roles (user_id, role_id , created_by, updated_by)
                            VALUES ('$new_user_id', 2, '$created_by', '$updated_by')";

                if (!$conn->query($query_role)) {
                    throw new Exception("Gagal menyimpan role: " . $conn->error);
                }
                $query_role = "INSERT INTO tb_owners (user_id, business_name, status, created_by, updated_by)
                            VALUES ('$new_user_id', '$business_name','pending', '$created_by', '$updated_by')";

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

                // Update tb_users
                $query = "UPDATE tb_users 
                        SET name='$name', email='$email', phone='$phone', updated_by='$updated_by'
                        $q_password
                        WHERE id='$idb'";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal update user: " . $conn->error);
                }
                if($status == "Active"){
                    $activated = "verified_at = NOW(),";
                }
                // Update tb_users
                $query = "UPDATE tb_owners
                        SET business_name='$business_name', status='$status', $activated updated_by='$updated_by'
                        WHERE user_id='$idb'";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal update user: " . $conn->error);
                }
                

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
            $conn->query("DELETE FROM tb_owners where user_id='$id'");
            $conn->query("DELETE FROM tb_user_roles where user_id='$id'");
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_users t1
                                     join tb_owners  t2 on t1.id = t2.user_id
                                     WHERE t1.id='$idb'")->fetch_assoc();

            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $phone = $data['phone'];
            $business_name = $data['business_name'];
            $status = $data['status'];
        } else {
            $idb = "";
            $name = "";
            $email = "";
            $phone = "";
            $business_name = "";
            $status = "Pending";
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
                            <label>Nama Owner</label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $email ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= $phone?>" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Nama Business</label>
                            <input type="text" name="business_name" class="form-control" value="<?= $business_name ?>" <?= $readonly ?>>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" value="<?= $status ?>" <?= $readonly ?>>
                                <option value="Active" <?= $status == 'Active' ? "selected" : "" ?>>Active</option>
                                <option value="Pending" <?= $status == 'Pending' ? "selected" : "" ?>>Pending</option>
                                <option value="Suspend" <?= $status == 'Suspend' ? "selected" : "" ?>>Suspend</option>
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
    </div>
<?php
    }
}
?>
