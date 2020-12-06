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
    <link rel="stylesheet" href="../../src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php require_once '../../components/nav-side-bar.php' ?>
    <div class="main">
        <div class="bar">
            <div class="bar-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h3>Riwayat Antrian</h3>
        </div>
        <div class="content">
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Poli</th>
                    <th>Antrian</th>
                    <th>Aksi</th>
                </tr>
                <tr>
                    <td>Senin, 7 Desember 2020</td>
                    <td>Poli Gigi</td>
                    <td>O-012</td>
                    <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                </tr>
                <tr>
                    <td>Jumat, 4 Desember 2020</td>
                    <td>Poli Umum</td>
                    <td>O-004</td>
                    <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                </tr>
                <tr>
                    <td>Rabu, 17 November 2020</td>
                    <td>Poli Umum</td>
                    <td>O-051</td>
                    <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                </tr>
                <tr>
                    <td>Kamis, 1 Oktober 2020</td>
                    <td>Poli Gigi</td>
                    <td>O-001</td>
                    <td><a href="#">Lihat</a> <a href="#">Cetak</a></td>
                </tr>
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