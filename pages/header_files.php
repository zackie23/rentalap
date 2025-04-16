<div class="m-header">
    <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
    <a href="#" class="b-brand">
        <img src="../dist/images/logo.webp" alt="" class="logo" />
        <img src="../dist/images/logo-icon.webp" alt="" class="logo-thumb" />
    </a>
    <a href="#" class="mob-toggler">
        <i class="feather icon-more-vertical"></i>
    </a>
</div>
<div class="collapse navbar-collapse">
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a href="#" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                    class="feather icon-maximize"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown"><i
                        class="icon feather icon-bell"></i><span class="badge bg-danger"><span
                            class="sr-only"></span></span></a>
                <div class="dropdown-menu dropdown-menu-end notification">
                    <div class="noti-head">
                        <h6 class="d-inline-block m-b-0">Notif</h6>
                        <div class="float-end">
                            <a href="#" class="m-r-10">mark as read</a>
                            <a href="#">clear all</a>
                        </div>
                    </div>
                    <ul class="noti-body">
                        <li class="n-title">
                            <p class="m-b-0">NEW</p>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="../dist/images/user/avatar-1.webp"
                                    alt="Generic placeholder image" />
                                <div class="media-body">
                                    <p>
                                        <strong>John Doe</strong><span class="n-time text-muted"><i
                                                class="icon feather icon-clock m-r-10"></i>5
                                            min</span>
                                    </p>
                                    <p>New ticket Added</p>
                                </div>
                            </div>
                        </li>
                        <li class="n-title">
                            <p class="m-b-0">EARLIER</p>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="../dist/images/user/avatar-2.webp"
                                    alt="Generic placeholder image" />
                                <div class="media-body">
                                    <p>
                                        <strong>Joseph William</strong><span class="n-time text-muted"><i
                                                class="icon feather icon-clock m-r-10"></i>10
                                            min</span>
                                    </p>
                                    <p>Prchace New Theme and make payment</p>
                                </div>
                            </div>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="../dist/images/user/avatar-1.webp"
                                    alt="Generic placeholder image" />
                                <div class="media-body">
                                    <p>
                                        <strong>Sara Soudein</strong><span class="n-time text-muted"><i
                                                class="icon feather icon-clock m-r-10"></i>12
                                            min</span>
                                    </p>
                                    <p>currently login</p>
                                </div>
                            </div>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="../dist/images/user/avatar-2.webp"
                                    alt="Generic placeholder image" />
                                <div class="media-body">
                                    <p>
                                        <strong>Joseph William</strong><span class="n-time text-muted"><i
                                                class="icon feather icon-clock m-r-10"></i>30
                                            min</span>
                                    </p>
                                    <p>Prchace New Theme and make payment</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="noti-footer">
                        <a href="#">show all</a>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="dropdown drp-user">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="../dist/images/user/avatar-1.webp" class="img-radius wid-40" alt="User-Profile-Image" />
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-notification">
                    <div class="pro-head">
                        <img src="../dist/images/user/avatar-1.webp" class="img-radius" alt="User-Profile-Image" />
                        <small><?=$_SESSION['namapengguna'];?></small>
                        <a href="logout.php" class="dud-logout" title="Logout">
                            <i class="feather icon-log-out"></i>
                        </a>
                    </div>
                    <ul class="pro-body">
                        <li>
                            <a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i>
                                Profile</a>
                        </li>
                        <li>
                            <a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i>
                                My Messages</a>
                        </li>
                        <li>
                            <a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i>
                                Lock Screen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>