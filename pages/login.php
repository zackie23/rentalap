<?php
session_start();
if($_SESSION['login'] == 1){
    header("location:dashboard");
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        require_once "css_files.php";
    ?>

<body>
    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="h-100 d-md-flex align-items-center auth-side-img">
                <div class="col-sm-10 auth-content w-auto">
                    <img src="../dist/images/auth/auth-logo.webp" alt="" class="img-fluid">
                    <h1 class="text-white my-4">Selamat Datang, Caleg!</h1>
                    <h4 class="text-white font-weight-normal">Masuk dan menangkan pemilumu<br />Manage tim sukses dan
                        konstituen yang valid hanya di <a href="https://suaracaleg.com">suaracaleg.com!</a></h4>

                </div>
            </div>
            <div class="auth-side-form">
                <div class=" auth-content">
                    <h4 class="mb-5">
                        <div id="timer" style="height:80px"></div>
                    </h4>
                    <img src="../dist/images/auth/auth-logo-dark.webp" alt=""
                        class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                    <form id="frmsignin" method="post" autocomplete="on">
                        <input type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <input type="hidden" id="url_awal" value="<?=$_SERVER['REQUEST_URI'];?>">
                        <h3 class="mb-4 f-w-400">Signin</h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control password" placeholder="Password" required>
                            <span class="input-group-text reveal-password" data-target="#password"><i class="feather icon-eye"></i></span>
                        </div>
                        <button class="btn btn-block btn-primary mt-2 mb-0" type="submit" name="submit" value="login">Signin</button>
                    </form>
                    <form id="frmreset"  method="post" autocomplete="on" class="d-none">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <h4 class="mb-3 f-w-400">Reset your password</h4>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" class="form-control" placeholder="Email address" required>
                        </div>
                        <button class="btn btn-block btn-primary mb-4" type="submit" name="submit" value="reset">Reset password</button>
                    </form>
                    <form id="frmsignup" method="post" autocomplete="on" class="d-none">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <h3 class="mb-3 f-w-400">Sign up</h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email address" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap"
                                required>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                            <input type="password" name="password" id="password_signup" class="form-control password" placeholder="Password" required>
                            <span class="input-group-text reveal-password"  data-target="#password_signup"><i class="feather icon-eye"></i></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-phone"></i></span>
                            <input type="text" name="no_handphone" class="form-control" placeholder="No. Handphone"
                                required>
                        </div>
                        <button class="btn btn-primary btn-block mt-2 mb-4" type="submit" name="submit" value="signup">Daftar</button>
                    </form>
                    <div class="text-center">
                        <div class="saprator"><span>atau</span></div>
                        <button class="btn text-white bg-facebook mb-2 me-2  wid-40 px-0 hei-40 rounded-circle">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="btn text-white bg-danger mb-2  wid-40 px-0 hei-40 rounded-circle">
                            <i class="fab fa-google"></i>
                        </button>
                        <p class="mb-2 mt-2 text-muted reset-link">Lupa Password? <a href="#reset"
                                class="f-w-400">Reset</a></p>
                        <p class="mb-2 mt-2 text-muted signin-link d-none">Sudah punya akun? <a href="#signin"
                                class="f-w-400">Login</a></p>
                        <p class="mb-2 mt-2 text-muted signup-link">Belum punya akun? <a href="#signup"
                                class="f-w-400">Daftar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../dist/js/plugins.min.js"></script>
    <script src="../dist/js/pages.min.js"></script>
</body>

</html>