<?php 
define("BASEURL", 'http://localhost/web/webKlinik/');

if(!defined("root")){
    header("location:".BASEURL."index.php");die;
}

?>

<nav>
    <div class="logo">
        <a href="<?= BASEURL ?>/index.php"><h1>i-Clinic</h1></a>
    </div>
    <?php if(!isset($_SESSION['login'])) :?>
    <div class="user" style=" font-weight:500;">
        <a href="<?= BASEURL."login.php" ?>" style="color: #333; margin-right: 15px;">Masuk</a>
        <a href="<?= BASEURL."register.php" ?>" style="color: #333; border: 1px solid grey; border-radius: 10px; padding: 5px 10px;">Daftar</a>
    </div>
    <?php else :?>
    <div class="user">
        <i class="fas fa-user-circle"></i>
        Hallo, <?= $_SESSION['user_name']; ?> !
    </div>
    <?php endif; ?>
</nav>
<ul class="sidebar">
    <div class="close-icon">
        <i class="fas fa-times"></i>
    </div>
    <li><a href="<?= BASEURL."./index.php" ?>"><i class="fas fa-home"></i>Beranda</a></li>
    <li><a href="<?= BASEURL."page/jadwal-poli.php" ?>"><i class="fas fa-calendar"></i>Jadwal Poli Klinik</a></li>
    <?php if(isset($_SESSION['login'])) :?>
        <li><a href="<?= BASEURL."page/ubah-profil.php" ?>"><i class="fas fa-user"></i>Ubah Profil</a></li>
        <li><a href="<?= BASEURL."page/ubah-password.php" ?>"><i class="fas fa-lock"></i>Ubah Password</a></li>
        <li><a href="<?= BASEURL."page/riwayat-antrian.php" ?>"><i class="fas fa-history"></i>Riwayat Antrian</a></li>
    <?php else :?>
    <?php endif; ?>
    <li><a href="<?= BASEURL."page/hubungi-kami.php" ?>"><i class="fas fa-phone-alt"></i>Hubungi Kami</a></li>
    <?php if(isset($_SESSION['login'])) :?>
        <li><a href="<?= BASEURL."logout.php" ?>"><i class="fas fa-sign-out-alt"></i>Keluar</a></li>
    <?php else :?>
    <?php endif; ?>
</ul>