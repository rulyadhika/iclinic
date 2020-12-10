<?php 
require 'utility/function.php';
session_start();
define("root",true);

//untuk merubah counter antrian pasien
if(isset($_POST['refresh'])){
    $dilayani = select("SELECT nomor_antrian FROM tb_counter WHERE id_unit = 1 AND tanggal_pengoperasian = CURRENT_DATE()");

    if($dilayani == NULL){
        $dilayani = 0;
    }else{
        $dilayani = (int) $dilayani[0]['nomor_antrian'];
    }

    $pasienBPJSOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = CURRENT_DATE() AND jenis_pembiayaan = 'BPJS'")[0]['COUNT(id)'];
    $pasienBPJSOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = CURRENT_DATE() AND no_bpjs IS NOT NULL")[0]['COUNT(id)'];
    $pasienBPJS = $pasienBPJSOffline + $pasienBPJSOnline;

    $pasienUmumOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = CURRENT_DATE() AND jenis_pembiayaan = 'Umum'")[0]['COUNT(id)'];
    $pasienUmumOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = CURRENT_DATE() AND no_bpjs IS NULL")[0]['COUNT(id)'];
    $pasienUmum = $pasienUmumOffline + $pasienUmumOnline;

    $qTotalOffline = $pasienBPJSOffline + $pasienUmumOffline;
    $qTotalOnline = $pasienBPJSOnline + $pasienUmumOnline;
    $qTotal = $qTotalOffline + $qTotalOnline;

    $time_now = date("H:i:s",time());

    echo json_encode(["dilayani"=>$dilayani,"qTotal"=>$qTotal,"pasienBPJS"=>$pasienBPJS,"pasienUmum"=>$pasienUmum,"time_now"=>$time_now]);die;
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Online</title>
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./src/plugins/jquery/jquery.min.js"></script>

    <style>
        .loading{
            width: 50px;
        }
    </style>
</head>
<body>

    <?php require_once 'components/nav-side-bar.php' ?>
    
    <div class="main">
        <div class="bar">
            <div class="bar-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h3>Beranda</h3>
        </div>
        <div class="content">
            <?php
            function tglIndonesia($str){
                $tr   = trim($str);
                $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
                return $str;
            }  
            ?>
            <h2 style="margin-bottom: 5px;"><?php echo tglIndonesia(date('D, d F Y')); ?><span class="display_clock"></span></h2>
            <h6 style="text-align: center; margin-top:0">Angka otomatis berubah jika ada antrian baru</h6>
            <h3>Antrian hari ini</h3>
            <div class="grid-widget">
                <div class="widget">
                    <div class="nomor active_queue"><img src="./src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                    Sedang Dilayani
                </div>
                <div class="widget">
                    <div class="nomor total_queue"><img src="./src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                    Total Antrian
                </div>
                <div class="widget">
                    <div class="nomor bpjs_patient"><img src="./src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                    Pasien BPJS
                </div>
                <div class="widget">
                    <div class="nomor umum_patient"><img src="./src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                    Pasien Umum
                </div>
            </div>
            <div class="grid-form">
                <?php if(isset($_SESSION['login'])) :?>
                <div class="group-menu">
                    <h3>Antrian Aktif Anda <a href="./page/riwayat-antrian.php" style="color: #008000; float:right;">Lihat Semua</a></h3>
                    <?php
                    $id_user = $_SESSION['user_id'];
                    $riwayat_antri = select("SELECT tb_unit.nama_unit,tb_pendaftaran_online.* FROM tb_unit JOIN tb_jadwal ON tb_unit.id = tb_jadwal.id_unit JOIN tb_pendaftaran_online ON tb_jadwal.id = tb_pendaftaran_online.id_jadwal WHERE id_user = $id_user AND tanggal_periksa >= CURDATE() ORDER BY tb_pendaftaran_online.tanggal_periksa ASC LIMIT 0,3");
                    ?>
                    <div class="tabel">
                    <?php if($riwayat_antri == NULL): ?>
                    Antrian anda tidak ada yang aktif!
                    <?php else :?>
                    <table>
                        <tr> 
                            <!-- <th>No</th> -->
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Antrian Admins</th>
                            <th>Aksi</th>
                        </tr>
                        <?php foreach($riwayat_antri as $riwayat) :?>
                        <tr>
                            <td><?= strftime("%d-%m-%Y",strtotime($riwayat['tanggal_periksa'])); ?></td>
                            <td><?= $riwayat['nama_unit']; ?></td>
                            <td style="text-align:center"><?= $riwayat['no_antrian_administrasi']; ?></td>
                            <td style="text-align:center"><a style="color:#008000;" href="utility/print.php?reg=online&data-id=<?= $riwayat['id']; ?>">Cetak Pdf</a></td>
                        </tr>
                        <?php endforeach; ?>  
                    </table>
                    <?php endif ;?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="group-menu">
                    <h3>Ambil antrian</h3>
                    <div class="antri-btn">
                        <a href="page/pendaftaran-periksa.php">Ambil Sekarang</a>
                    </div>
                </div>
            </div>
            
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


        setInterval(()=>{
            //refresh counter antrian
            $.ajax({
            url: "index.php",
            type : "POST",
            data : { 
                    refresh : true,
                },
            dataType : "JSON",
            success: function(result){
                console.log(result);
                $(".active_queue").text(result.dilayani);
                $(".total_queue").text(result.qTotal);
                $(".bpjs_patient").text(result.pasienBPJS);
                $(".umum_patient").text(result.pasienUmum);
                $(".display_clock").text(" | "+result.time_now+" WIB");
            }});

        },7000)
    </script>
</body>
</html>