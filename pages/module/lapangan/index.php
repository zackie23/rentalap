<?php
//Deteksi hanya bisa diinclude, tidak bisa langsung dibuka (direct open)
if (count(get_included_files()) == 1) {
    echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]'>";
    exit("Direct access not permitted.");
}
error_reporting(0);
session_start();
if (empty($_SESSION['id_user']) AND empty($_SESSION['passuser'])) {
    header('location:../index.php');
} else {

    switch ($_GET['act']) {
        // Tampil List pengguna
        default:
            if ($_SESSION['idlevel'] != 2) {
                $conn->query("INSERT INTO tb_data_error (email,waktu,url,ip_address) VALUES ('$_SESSION[id_user]',NOW(),'$absolute_url','$ip') ");
                $conn->close();
                ?>
                <div id="restricted">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h1 class="text-danger">403</h1>
                                <p class="lead text-gray-800 mb-5">Unauthorized</p>
                                <p class="text-gray-500 mb-0">The page you are looking for might restricted.</p>
                                <a href="dashboard">&larr; Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5><a href="<?=$module."?act=new"?>" class="btn bt-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</a></h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table id="table-<?=$module?>" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>cabang</th>
                                        <th>Nama</th>
                                        <th>Sport type</th>
                                        <th>Hourly price</th>
                                        <th>image url</th>
                                        <th>active</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
            break;
        case "new":
            include "form.php";
            break;
        case "edit":
            include "form.php";
            break;
        case "save":
            include "form.php";
            break;
        case "hapus":
            include "form.php";
            break;
    }
}
?>