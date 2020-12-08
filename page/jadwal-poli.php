<?php 
require '../utility/function.php';
session_start();
define("root",true);
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
            <h3>Jadwal Poli</h3>
        </div>
        <div class="content">
        <?php
        $jadwalPoliKlinik = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_biodata_user.nama as nama_dokter FROM tb_jadwal JOIN tb_unit
                            ON tb_jadwal.id_unit = tb_unit.id JOIN tb_akun_user ON tb_unit.id_akun_dokter = tb_akun_user.id 
                            JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_jadwal.id_unit>1 ORDER BY tb_unit.nama_unit");
        $no = 1;
        ?>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Poli</th>
                    <th>Hari Praktek</th>
                    <th>Waktu Praktek</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($jadwalPoliKlinik as $jadwalPoli)  :?>
                  <tr>
                    <td style="text-align:center"><?= $no; ?></td>
                    <td><?= $jadwalPoli['nama_unit']; ?> (<?= $jadwalPoli['nama_dokter']; ?>)</td>
                    <td><?= $jadwalPoli['hari_praktek']; ?></td>
                    <td><?= date("H:i",strtotime($jadwalPoli['waktu_praktek'])); ?> WIB</td>
                    <td style="text-align:center"><?= $jadwalPoli['status_jadwal']; ?></td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
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