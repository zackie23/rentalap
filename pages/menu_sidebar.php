<div class="navbar-wrapper">
    <div class="navbar-content scroll-div">
        <ul class="nav pcoded-inner-navbar">
            <li data-username="Dashboard" class="nav-item">
                <a href="dashboard" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-home"></i>
                    </span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <?php
                //ADMIN 
                if($_SESSION['idlevel'] == 1){
                    ?>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu Utama</label>
                    </li>

                    <!-- Manajemen Owner -->
                    <li class="nav-item">
                        <a href="owner" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Manajemen Owner</span>
                        </a>
                    </li>

                    <!-- Paket & Langganan -->
                    <li class="nav-item">
                        <a href="paket" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-package"></i></span>
                            <span class="pcoded-mtext">Paket & Langganan</span>
                        </a>
                    </li>

                    <!-- Transaksi & Pembayaran -->
                    <li class="nav-item">
                        <a href="transaksi" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                            <span class="pcoded-mtext">Transaksi</span>
                        </a>
                    </li>

                    <!-- Statistik Penggunaan -->
                    <li class="nav-item">
                        <a href="statistik" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-bar-chart-2"></i></span>
                            <span class="pcoded-mtext">Statistik</span>
                        </a>
                    </li>

                    <!-- Pusat Bantuan / Tiket Support -->
                    <li class="nav-item">
                        <a href="support" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-message-square"></i></span>
                            <span class="pcoded-mtext">Pusat Bantuan</span>
                        </a>
                    </li>

                    <!-- Pengaturan Platform -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                            <span class="pcoded-mtext">Pengaturan</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="pengaturan_umum">Pengaturan Umum</a></li>
                            <li><a href="roles">Manajemen Hak Akses</a></li>
                            <li><a href="pengguna">Manajemen Pengguna</a></li>
                            <li><a href="notifikasi">Pengaturan Notifikasi</a></li>
                        </ul>
                    </li>
                    <?php
                    //OWNER
                }elseif($_SESSION['idlevel'] == 2){
                    ?>
                    <!-- Cabang & Lapangan -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-map-pin"></i></span>
                            <span class="pcoded-mtext">Master Data</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="cabang">Cabang</a></li>
                            <li><a href="lapangan">Lapangan</a></li>
                        </ul>
                    </li>

                    <!-- Jadwal & Booking -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                            <span class="pcoded-mtext">Jadwal & Booking</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="kalender">Kalender Booking</a></li>
                            <li><a href="riwayat_booking">Riwayat Booking</a></li>
                        </ul>
                    </li>

                    <!-- Customer / Member -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Customer / Member</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="member">Daftar Member</a></li>
                            <li><a href="riwayat_sewa">Riwayat Sewa</a></li>
                        </ul>
                    </li>

                    <!-- Pegawai / Operator -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
                            <span class="pcoded-mtext">Pegawai / Operator</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="pegawai">Tambah/Edit Pegawai</a></li>
                            <li><a href="role_akses">Role & Akses</a></li>
                        </ul>
                    </li>

                    <!-- Langganan & Paket -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                            <span class="pcoded-mtext">Langganan & Paket</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="paket_saat_ini">Paket Saat Ini</a></li>
                            <li><a href="upgrade_paket">Upgrade Paket</a></li>
                            <li><a href="invoice">Invoice & Tagihan</a></li>
                        </ul>
                    </li>

                    <!-- Laporan & Transaksi -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                            <span class="pcoded-mtext">Laporan & Transaksi</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="riwayat_transaksi">Riwayat Transaksi</a></li>
                            <li><a href="export_laporan">Export Laporan</a></li>
                        </ul>
                    </li>

                    <!-- QR Check-in Log -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-smartphone"></i></span>
                            <span class="pcoded-mtext">QR Check-in Log</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="scan_log">Daftar Scan</a></li>
                            <li><a href="aktivitas_log">Log Aktivitas</a></li>
                        </ul>
                    </li>

                    <!-- Pengaturan Cabang & Branding -->
                    <li class="nav-item">
                        <a href="pengaturan_cabang" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
                            <span class="pcoded-mtext">Pengaturan Cabang & Branding</span>
                        </a>
                    </li>
                    <?php
                }elseif($_SESSION['idlevel'] == 3){
                    //Operator
                    ?>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Operasional Harian</label>
                    </li>

                    <!-- Booking Lapangan -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                            <span class="pcoded-mtext">Booking Lapangan</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="booking_baru">Walk-in Booking</a></li>
                            <li><a href="lihat_booking">Lihat Booking</a></li>
                        </ul>
                    </li>

                    <!-- Pembayaran -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                            <span class="pcoded-mtext">Pembayaran</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="cod">COD</a></li>
                            <li><a href="konfirmasi_transfer">Konfirmasi Transfer</a></li>
                        </ul>
                    </li>

                    <!-- Check-in Member -->
                    <li class="nav-item">
                        <a href="scan_qr" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-smartphone"></i></span>
                            <span class="pcoded-mtext">Scan QR Code</span>
                        </a>
                    </li>

                    <!-- Data Member -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Data Member</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="cari_member">Cari Member</a></li>
                            <li><a href="riwayat_booking_member">Riwayat Booking</a></li>
                        </ul>
                    </li>

                    <!-- Laporan Harian -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-bar-chart-2"></i></span>
                            <span class="pcoded-mtext">Laporan Harian</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="pemasukan_harian">Pemasukan Harian</a></li>
                            <li><a href="cetak_nota">Cetak Nota</a></li>
                        </ul>
                    </li>

                    <?php
                }else{
                    //User 
                    ?>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu Member</label>
                    </li>

                    <!-- Booking -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                            <span class="pcoded-mtext">Booking</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="cari_lapangan">Cari Lapangan</a></li>
                            <li><a href="pilih_jadwal">Pilih Jam & Tanggal</a></li>
                            <li><a href="checkout_bayar">Checkout & Bayar</a></li>
                        </ul>
                    </li>

                    <!-- Tiket Saya -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-ticket"></i></span>
                            <span class="pcoded-mtext">Tiket Saya</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="riwayat_booking">Riwayat Booking</a></li>
                            <li><a href="qr_checkin">QR Check-in</a></li>
                        </ul>
                    </li>

                    <!-- Tim Saya -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Tim Saya</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="buat_tim">Buat Tim / Grup</a></li>
                            <li><a href="invite_anggota">Invite Anggota</a></li>
                        </ul>
                    </li>

                    <!-- Langganan Bulanan -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-repeat"></i></span>
                            <span class="pcoded-mtext">Langganan Bulanan</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="paket_langganan">Paket Langganan</a></li>
                            <li><a href="jadwal_tetap">Jadwal Tetap</a></li>
                        </ul>
                    </li>

                    <!-- Notifikasi -->
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-bell"></i></span>
                            <span class="pcoded-mtext">Notifikasi</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="pengingat_booking">Pengingat Booking</a></li>
                            <li><a href="promo_event">Promo / Event</a></li>
                        </ul>
                    </li>

                    <!-- Profil & Akun -->
                    <li class="nav-item">
                        <a href="profil_akun" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                            <span class="pcoded-mtext">Profil & Akun</span>
                        </a>
                    </li>

                    <?php
                }
            ?>
        </ul>
        <div class="card text-center">
            <div class="card-block">
                <i class="feather icon-package f-40 text-danger"></i>
                <!-- <img src="../dist/images/kotak_pemilu.webp" width="75" alt="">
                <h6 class="mt-3" id="timer" style="height:60px">
                    <div class="spinner-border mt-2" style="width: 2rem; height: 2rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </h6> -->
            </div>
        </div>
    </div>
</div>