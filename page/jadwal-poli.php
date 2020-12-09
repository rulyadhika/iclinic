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
    <!-- DataTables -->
    <link rel="stylesheet" href="../src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <style>
        #jadwal_wrapper{
            font-size: 14px;
        }

        #jadwal_wrapper input , #jadwal_wrapper select{
            padding: 5px 10px;
            height: auto !important;
        }
        
        #jadwal_wrapper .row:first-child,
        #jadwal_wrapper .row:nth-child(3){
            display: flex;
            justify-content: space-between;
        }

        #jadwal_wrapper ul li{
            display: inline-block;
            margin-top: 5px;
        }

        #jadwal_wrapper ul li a{
            padding: 5px 10px;
            color: #008000;
            background :#ffff;
            border :1px solid #008000;
            outline: none;
        }

        #jadwal_wrapper ul .previous a:hover,
        #jadwal_wrapper ul .next a:hover{
            background :rgb(246,246,246);
        }

        #jadwal_wrapper ul .previous a{
            border-radius: 5px 0 0 5px;
        }

        #jadwal_wrapper ul .next a{
            border-radius: 0 5px 5px 0;
        }

        #jadwal_wrapper ul .active a{
            color: white;
            background :#008000;
        }

        .libur{
            background: #C9312D;
            color : white;
        }

    </style>
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
        //select data yang aktif
        $unitPoli = select("SELECT tb_unit.id,tb_unit.nama_unit,tb_biodata_user.nama FROM tb_unit JOIN tb_akun_user
                            ON tb_unit.id_akun_dokter = tb_akun_user.id JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE unit_status ='Aktif'");
        
        $jadwalPoliKlinik = select("SELECT * FROM tb_jadwal WHERE status_jadwal = 'Aktif'");

        $days = ['Senin',"Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        $dataJadwalLengkap = [];

        //filtering untuk menyatukan data poli dan data jadwal
        for($i=0 ; $i<count($unitPoli);$i++){
            $dataJadwalLengkap[$i]["nama_unit"] = $unitPoli[$i]['nama_unit'];
            $dataJadwalLengkap[$i]["dokter"] = $unitPoli[$i]['nama'];
            $count = 0;
            foreach($jadwalPoliKlinik as $jadwalPoli){
                if($unitPoli[$i]['id']==$jadwalPoli['id_unit']){
                    $count++;
                    $dataJadwalLengkap[$i]["jadwal"][$count]["hari"]= $jadwalPoli['hari_praktek'];
                    $dataJadwalLengkap[$i]["jadwal"][$count]["jam"]= $jadwalPoli['waktu_praktek'];
                }
            }
        }

        $no = 1;
        ?>
            <table id="jadwal" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>No.</th>
                <th>Nama Poli</th>
                <th>Senin</th>
                <th>Selasa</th>
                <th>Rabu</th>
                <th>Kamis</th>
                <th>Jumat</th>
                <th>Sabtu</th>
                <th>Minggu</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($dataJadwalLengkap as $dataJadwal)  :?>
                    <tr style="font-weight: bold;">
                        <td style="text-align:center"><?= $no; ?></td>
                        <td><?= $dataJadwal['nama_unit']; ?> 
                            <span style="font-size: 10px;">(<?= $dataJadwal['dokter']; ?>)</span>
                        </td>

                        <?php foreach($days as $day) :?>
                            <?php $available = false; $tempt = [];  ?>

                            <?php foreach($dataJadwal['jadwal'] as $jadwal){
                                if($jadwal['hari']==$day){
                                    $available=true;
                                    $tempt['hari']=$jadwal['hari'];
                                    $tempt['waktu']=$jadwal['jam'];
                                }
                            }?>

                            <?php if($available) :?>
                                <td style=" text-align:center;"><?= date("H:i",strtotime($tempt['waktu'])); ?> WIB</td>
                            <?php else: ?>
                                <td class="libur" style=" text-align:center;">Libur</td>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    
                    </tr>
                <?php $no++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- DataTables -->
    <script src="../src/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
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

        $(document).ready(function() {
                $("#jadwal").DataTable({
                    "language":{
                    "emptyTable":"Maaf data tidak tersedia...",
                    "info":"Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                    "infoEmpty":"Maaf, Data tidak tersedia..",
                    "infoFiltered": "",
                    "search":"Pencarian",
                    "lengthMenu":"Menampilkan _MENU_ data",
                    "zeroRecords":"Maaf, Data tidak tersedia.",
                    "paginate":{
                            "first":"Pertama",
                            "last":"Terakhir",
                            "next":"Berikutnya",
                            "previous":"Sebelumnya"
                        },
                    "searchPlaceholder" : "Masukan kata kunci"
                    }
                });
            } );
    </script>
</body>
</html>