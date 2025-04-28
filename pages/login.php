<?php
session_start();
if(isset($_SESSION['login']) AND $_SESSION['login'] == 1){
    header("location:dashboard");
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$mod_view = "Login";
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
                    <img src="../dist/images/auth/auth-logo.webp" alt=""  width="50px" class="img-fluid"> <span class="font-weight-normal" style="font-size:20px">Booking Lapangan Online</span>
                    <h1 class="text-white my-4">Selamat Datang, Badminton Lovers!</h1>
                    <h4 class="text-white font-weight-normal">Pilih dan booking lapanganmu sekarang! <a href="https://bookingonline.com">bookingonline.com!</a></h4>
                </div>
            </div>
            <div class="auth-side-form">
                <div class=" auth-content">
                    <img src="../dist/images/auth/auth-logo.webp" alt="" class="img-fluid">
                    <form id="frmsignin" method="post" autocomplete="on">
                        <input type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <input type="hidden" id="url_awal" value="<?=$_SERVER['REQUEST_URI'];?>">
                        <h3 class="mb-4 f-w-400">Masuk</h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control password" placeholder="Password" required>
                            <span class="input-group-text reveal-password" data-target="#password"><i class="feather icon-eye"></i></span>
                        </div>
                        <button class="btn btn-block btn-primary mt-2 mb-0" type="submit" name="submit" value="login">Login</button>
                    </form>
                    <form id="frmreset"  method="post" autocomplete="on" class="d-none">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <h4 class="mb-3 f-w-400">Reset Password</h4>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <button class="btn btn-block btn-primary mb-4" type="submit" name="submit" value="reset">Reset</button>
                    </form>
                    <form id="frmsignup" method="post" autocomplete="on" class="d-none">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <h3 class="mb-3 f-w-400">Daftar </h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
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
                        <button class="btn btn-primary btn-block mt-2 mb-4" type="submit" name="submit" value="signup">Simpan</button>
                    </form>
										<form id="frmsignup_venue" method="post" autocomplete="on" class="d-none">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <h3 class="mb-3 f-w-400">Daftarkan Venuemu disini </h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
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
												<div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-card"></i></span>
                            <input type="text" name="business_name" class="form-control" placeholder="Nama Venue"
                                required>
                        </div>
                        <button class="btn btn-primary btn-block mt-2 mb-4" type="submit" name="submit" value="signup_venue">Simpan</button>
                    </form>
                    <div class="text-center">
                        <div class="saprator"><span>atau</span></div>
                        <button class="btn btn-block">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.3541 7.53113H15.75V7.5H9V10.5H13.2386C12.6203 12.2464 10.9586 13.5 9 13.5C6.51487 13.5 4.5 11.4851 4.5 9C4.5 6.51487 6.51487 4.5 9 4.5C10.1471 4.5 11.1908 4.93275 11.9854 5.63962L14.1068 3.51825C12.7673 2.26987 10.9755 1.5 9 1.5C4.85812 1.5 1.5 4.85812 1.5 9C1.5 13.1419 4.85812 16.5 9 16.5C13.1419 16.5 16.5 13.1419 16.5 9C16.5 8.49713 16.4482 8.00625 16.3541 7.53113Z" fill="#FFBB55"></path>
                                <path d="M2.36475 5.50912L4.82887 7.31625C5.49562 5.6655 7.11037 4.5 9 4.5C10.1471 4.5 11.1907 4.93275 11.9854 5.63962L14.1067 3.51825C12.7672 2.26987 10.9755 1.5 9 1.5C6.11925 1.5 3.621 3.12637 2.36475 5.50912Z" fill="#FF3D00"></path>
                                <path d="M8.99999 16.5C10.9372 16.5 12.6975 15.7586 14.0284 14.553L11.7071 12.5888C10.9288 13.1807 9.97779 13.5008 8.99999 13.5C7.04924 13.5 5.39287 12.2561 4.76887 10.5203L2.32312 12.4046C3.56437 14.8335 6.08512 16.5 8.99999 16.5Z" fill="#4CAF50"></path>
                                <path d="M16.3541 7.53113H15.75V7.5H9V10.5H13.2386C12.9428 11.3312 12.41 12.0574 11.706 12.5891L11.7071 12.5884L14.0284 14.5526C13.8641 14.7019 16.5 12.75 16.5 9C16.5 8.49713 16.4482 8.00625 16.3541 7.53113Z" fill="#1976D2"></path>
                            </svg> Masuk dengan Google
                        </button>
                        <p class="mb-2 mt-2 text-muted reset-link">Lupa Password? <a href="#reset"class="f-w-400">Reset</a></p>
                        <p class="mb-2 mt-2 text-muted signin-link d-none">Sudah punya akun? <a href="#signin"class="f-w-400">Login</a></p>
                        <p class="mb-2 mt-2 text-muted signup-link">Belum punya akun? <a href="#signup" class="f-w-400">Daftar</a></p>
												<p class="mb-2 mt-2 text-muted signup-link">Daftarkan venue kamu disini? <a href="#signup_venue" class="f-w-400">Daftar Venue</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../dist/js/plugins.min.js"></script>
    <script src="../dist/js/pages.min.js"></script>
</body>
</html>