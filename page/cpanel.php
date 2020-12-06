<?php 
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
            <h3>Beranda</h3>
        </div>
        <div class="content">
            <h2>Jumat, 4 Desember 2020</h2>
            <h3>Antrian hari ini</h3>
            <div class="grid-widget">
                <div class="widget">
                    <div class="nomor">5</div>
                    Sedang Dilayani
                </div>
                <div class="widget">
                    <div class="nomor">75</div>
                    Total Antrian
                </div>
                <div class="widget">
                    <div class="nomor">45</div>
                    Antrian BPJS
                </div>
                <div class="widget">
                    <div class="nomor">30</div>
                    Antrian Umum
                </div>
            </div>
            <div class="grid-form">
                <?php if(isset($_SESSION['login'])) :?>
                <div class="group-menu">
                    <h3>Antrian Anda</h3>
                    <div class="tabel">
                        <table>
                            <tr>
                                <th>Antrian</th>
                                <th>Untuk Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <td>O-004</td>
                                <td>Jumat, 4 Desember 2020</td>
                                <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                            </tr>
                            <tr>
                                <td>O-012</td>
                                <td>Senin, 7 Desember 2020</td>
                                <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <div class="group-menu" <?= isset($_SESSION['login'])?"style='width: 500px; margin:0 auto;'":''; ?>>
                    <h3>Ambil antrian</h3>
                    <div class="antri-btn">
                        <a href="pendaftaran-periksa.php">Ambil Sekarang</a>
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
    </script>
</body>
</html>