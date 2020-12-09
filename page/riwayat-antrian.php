<?php 
require '../utility/function.php';
session_start();
define("root",true);
if (!isset($_SESSION['login'])){
    header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Online</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php require_once '../components/nav-side-bar.php' ?>
    <div class="main">
        <div class="bar">
            <div class="bar-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h3>Riwayat Antrian</h3>
        </div>
        <div class="content">
        <?php
            $id_user = $_SESSION['user_id'];
            $riwayat_antri = select("SELECT * FROM tb_unit JOIN tb_jadwal ON tb_unit.id = tb_jadwal.id_unit JOIN tb_pendaftaran_online  ON tb_jadwal.id = tb_pendaftaran_online.id_jadwal WHERE id_user = $id_user order by tanggal_periksa DESC");
            $no = 1;
            ?>
            <?php if($riwayat_antri == NULL): ?>
            <h2>Riwayat antrian anda masih kosong!</h2>
            <?php else :?>
            <table style="font-weight: bold;">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Poli</th>
                    <th>Antrian Administrasi</th>
                    <th>Antrian Poli</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach($riwayat_antri as $riwayat)  :?>
                <tr>
                    <td style="text-align:center"><?= $no; ?></td>
                    <td><?= strftime("%A, %d-%m-%Y",strtotime($riwayat['tanggal_periksa'])); ?></td>
                    <td style="text-align:center"><?= $riwayat['nama_unit']; ?></td>
                    <td style="text-align:center"><?= $riwayat['no_antrian_administrasi']; ?></td>
                    <td style="text-align:center"><?= $riwayat['no_antrian_poli']; ?></td>
                    <td style="text-align:center">
                        <?php if($riwayat['tanggal_periksa']>=date("Y-m-d",time())) :?>
                            <a href="../utility/print.php?reg=online">Cetak Pdf</a>
                        <?php else :?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $no++ ?>
                <?php endforeach; ?>
            </table>
            <?php endif ;?>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".bar-icon, .close-icon").click(function(){
                $(".sidebar").toggleClass("pull");
                $(".main").toggleClass("pull");
            });
            $("a").each(function(){
                if ((window.location.pathname.indexOf($(this).attr('href'))) > -1 ){
                    $(this).addClass('selected');
                }
            });
        });
    </script>
</body>
</html>