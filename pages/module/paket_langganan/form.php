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
        $max_fields = filter($_POST['max_fields']);
        $max_branches = filter($_POST['max_branches']);
        $price = filter($_POST['price']);
        $duration_days = filter($_POST['duration_days']);
        $description = filter($_POST['description']);
        $is_trial = isset($_POST['is_trial']) ? 1 : 0;
        $is_recommended = isset($_POST['is_recommended']) ? 1 : 0;
        $is_visible = isset($_POST['is_visible']) ? 1 : 0;
        
        $created_by = $_SESSION['id_user'];
        $updated_by = $_SESSION['id_user'];

        if (isset($_POST['Simpan'])) {
            $query = "INSERT INTO tb_packages 
                    (name, max_fields, max_branches, price, duration_days, description, is_trial, is_recommended, is_visible, created_at, created_by, updated_by)
                    VALUES ('$name', '$max_fields', '$max_branches', '$price', '$duration_days', '$description', '$is_trial', '$is_recommended', '$is_visible', NOW(), '$created_by', '$updated_by')";

            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil disimpan');
            } else {
                save_alert_swall('error', 'Data gagal disimpan');
            }
        } elseif (isset($_POST['Update'])) {
            
            $query = "UPDATE tb_packages SET 
                    name='$name', 
                    max_fields='$max_fields', 
                    max_branches='$max_branches', 
                    price='$price', 
                    duration_days='$duration_days', 
                    description='$description', 
                    is_trial='$is_trial', 
                    is_recommended='$is_recommended', 
                    is_visible='$is_visible', 
                    updated_by='$updated_by' WHERE id='$idb'";

            $exec = $conn->query($query);

            if ($exec) {
                save_alert_swall('save', 'Data berhasil diubah');
            } else {
                save_alert_swall('error', 'Data gagal diubah');
            }
        }
    } elseif (isset($_POST['Hapus'])) {
        $id = filter($_POST['id']);
        $delete = $conn->query("DELETE FROM tb_packages WHERE id='$id'");

        if ($delete) {
            save_alert_swall('save', 'Data berhasil dihapus');
        } else {
            save_alert_swall('error', 'Data gagal dihapus');
        }
    } else {
        if ($_GET['act'] != "new") {
            $idb = base64_decrypt($_GET['id'], $key);
            $data = $conn->query("SELECT * FROM tb_packages WHERE id='$idb'")->fetch_assoc();

            $name = $data['name'];
            $max_fields = $data['max_fields'];
            $max_branches = $data['max_branches'];
            $price = $data['price'];
            $duration_days = $data['duration_days'];
            $description = $data['description'];
            $is_trial = $data['is_trial'];
            $is_recommended = $data['is_recommended'];
            $is_visible = $data['is_visible'];
        } else {
            $idb = "";
            $name = "";
            $max_fields = 0;
            $max_branches = 0;
            $price = 0;
            $duration_days = 30;
            $description = '';
            $is_trial = 0;
            $is_recommended = 0;
            $is_visible = 1;

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
                            <label>Nama Paket</label>
                            <input type="text" name="name" class="form-control" value="<?= $name ?>" required <?= $readonly ?>>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Harga</label>
                                <input type="number" name="price" class="form-control" value="<?= $price ?>" required <?= $readonly ?>>
                            </div>
                            <div class="col-md-6">
                                <label>Durasi (Hari)</label>
                                <input type="number" name="duration_days" class="form-control" value="<?= $duration_days ?>" required <?= $readonly ?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Maksimal Cabang</label>
                                <input type="number" name="max_branches" class="form-control" value="<?= $max_branches ?>" required <?= $readonly ?>>
                            </div>
                            <div class="col-md-6">
                                <label>Maksimal Lapangan</label>
                                <input type="number" name="max_fields" class="form-control" value="<?= $max_fields ?>" required <?= $readonly ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" <?= $readonly ?>><?= $description ?></textarea>
                        </div>
                        <div class="row form-group d-flex align-items-center">
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" name="is_trial" value="1" <?= $is_trial ? 'checked' : '' ?>>
                                <label class="form-check-label">Trial</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="checkbox" name="is_recommended" value="1" <?= $is_recommended ? 'checked' : '' ?>>
                                <label class="form-check-label">Rekomendasi</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="checkbox" name="is_visible" value="1" <?= $is_visible ? 'checked' : '' ?>>
                                <label class="form-check-label">Tampilkan</label>
                            </div>
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
