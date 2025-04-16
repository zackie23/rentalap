<?php
error_reporting(0);
session_start();
require_once '../ch0npi9/function.php';

$module = trim($_GET['module']);
$sub_module = trim($_GET['sub_module']);
$mod_view = ($_SESSION['login'] == 1) ? strtoupper(strtolower(str_replace("_", " ", $module))) : "Login";

$queryString = $_SERVER['QUERY_STRING'];

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if($_SESSION['login'] != 1){
    header("location:auth");
}else{
    require_once '../ch0npi9/koneksi.php';
    require_once '../ch0npi9/enkripsi.php';
    require_once '../ch0npi9/fungsi.php';
    require_once '../ch0npi9/library.php';

    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <?php
        require_once "css_files.php";
    ?>
    </head>
    <body class="">
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>

        <nav class="pcoded-navbar menupos-fixed menu-light">
            <?php
                include "menu_sidebar.php";
            ?>
        </nav>

        <header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-blue">
            <?php
                include "header_files.php"
            ?>
        </header>

        <div class="pcoded-main-container">
            <div class="pcoded-content">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if($_GET['act'] == "new"){
                                $title = "Tambah Data";
                                $btn_name = "Simpan";
                                $btn_color = "btn-primary";
                                $url_action = "?act=save";
                            }elseif($_GET['act'] == "edit"){
                                $title = "Ubah Data";
                                $btn_name = "Update";
                                $btn_color = "btn-warning";
                                $url_action = "?act=edit";
                            }elseif($_GET['act'] == "hapus"){
                                $title = "Hapus Data";
                                $btn_name = "Hapus";
                                $btn_color = "btn-danger";
                                $readonly = "readonly";
                                $url_action = "?act=hapus";
                            }

                            include "breadcumb_files.php";
                            $pathFile = 'module/' . $module . '/index.php';
                            $pathFileLaporan = 'module/report/' . $module . '/index.php';
                            $pathMasterData = 'module/master_data/' . $module . '/index.php';
                            if (file_exists($pathFile)) {
                                include 'module/' . $module . '/index.php';
                            } elseif (file_exists($pathFileLaporan)) {
                                include 'module/report/' . $module . '/index.php';
                            } elseif (file_exists($pathMasterData)) {
                                include 'module/master_data/' . $module . '/index.php';
                            } else {
                                ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Halaman tidak ditemukan!</h5>
                                    <hr>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img src="../dist/images/auth/404.webp" style="width:30%">
                                        <p class="lead text-gray-800 mb-5">The page you are looking for has not been found!</p>
                                        <p class="text-gray-500 mb-0">The page you are looking for might have been removed, or unavailable.</p>
                                        <a href="dashboard">&larr; Back to Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="p-10 bg-white sc-footer">
                <div class="container my-auto">
                    <div>
                        <small class="text-muted">Copyright &copy; bookingonline.com <?=DATE('Y')?></small>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="../dist/js/plugins.min.js"></script>
        <script src="../dist/js/scripts.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../dist/js/main_datatables_local/jquery.dataTables.min.js"></script>
        <script src="../dist/js/main_datatables_local/dataTables.bootstrap5.min.js"></script>
        <script src="../dist/js/main_datatables_local/buttons.colVis.min.js"></script>
        <script src="../dist/js/main_datatables_local/buttons.print.min.js"></script>
        <script src="../dist/js/main_datatables_local/pdfmake.min.js"></script>
        <script src="../dist/js/main_datatables_local/jszip.min.js"></script>
        <script src="../dist/js/main_datatables_local/dataTables.buttons.min.js"></script>
        <script src="../dist/js/main_datatables_local/vfs_fonts.js"></script>
        <script src="../dist/js/main_datatables_local/buttons.html5.min.js"></script>
        <script src="../dist/js/main_datatables_local/buttons.bootstrap5.min.js"></script>
        <script src="../dist/js/pages.min.js"></script>
        <script>
            $(window).on('hashchange', function() {
                history.replaceState ("", document.title, window.location.pathname);
            });
        </script>
    </body>
    </html>
    <?php
}
?>
