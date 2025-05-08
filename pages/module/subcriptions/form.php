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
        

        $id_owner = filter($_POST['id_owner']);
        $id_package = filter($_POST['id_package']);
        $start_date = date('Y-m-d');
        $end_date = filter($_POST['end_date']);
        $is_active = filter($_POST['is_active']);
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];


        if (isset($_POST['Simpan'])) {
            // Mulai transaksi
            $conn->begin_transaction();

            try {
                // Simpan user
               

                $data = $conn->query("SELECT duration_days FROM tb_packages 
                                     WHERE id='$id_package'")->fetch_assoc();

                $end_date = getExpiredDate($data['duration_days']);

                $query = "INSERT INTO tb_subscriptions
                                (id_owner, id_package, end_date, start_date, is_active, created_by, updated_by)
                        VALUES ('$id_owner', '$id_package', '$end_date', '$start_date', '$is_active', '$created_by', '$updated_by')";

                if (!$conn->query($query)) {
                    throw new Exception("Gagal menyimpan subscriptions: " . $conn->error);
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
                // Update tb_users
                $data = $conn->query("SELECT duration_days FROM tb_packages 
                WHERE id='$id_package'")->fetch_assoc();

                $end_date = getExpiredDate($data['duration_days']); 

                $query = "UPDATE tb_subscriptions 
                        SET id_owner='$id_owner', id_package='$id_package', start_date='$start_date', end_date='$end_date', is_active='$is_active', updated_by='$updated_by' 
                        WHERE id='$idb'";
                
                if (!$conn->query($query)) {
                    throw new Exception("Gagal update subcriptions: " . $conn->error);
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
        $delete = $conn->query("DELETE FROM tb_subscriptions WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_subscriptions 
                                     WHERE id='$idb'")->fetch_assoc();

            $id_owner = $data['id_owner'];
            $id_package = $data['id_package'];
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
            $is_active = $data['is_active'];
        } else {
            $id_owner = "";
            $id_package = "";
            $start_date = "";
            $end_date = "";
            $is_active = 1;
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
                            <label>Nama Business</label>
                            <select name="id_owner" class="form-control"  <?= $readonly ?>>
                                <?php
                                    $query = "SELECT * from tb_owners";
                                    $exec = $conn->query($query);
                                    while($row = $exec->fetch_assoc()){
                                        if($id_owner == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['business_name'].'</option>';
                                        }else{
                                        echo '<option value="'.$row['id'].'">'.$row['business_name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Package</label>
                            <select name="id_package" class="form-control" <?= $readonly ?>>
                                <?php
                                    $query = "SELECT * from tb_packages";
                                    $exec = $conn->query($query);
                                    while($row = $exec->fetch_assoc()){
                                        if($id_package == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                                        }else{
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
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
    </div>
<?php
    }
}
?>
