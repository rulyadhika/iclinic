<?php 
session_start();

// redirect handler
if(!isset($_SESSION['login'])){
  header("Location:../login.php");die;
}else{
  if($_SESSION['role']=='dev' || $_SESSION['role']=='antrian adm'){
  }else{
    header("Location:../index.php");die;
  }
}

require '../utility/function.php';

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

//untuk merubah counter antrian pasien
if(isset($_POST['refresh'])){
    $hari_ini = date("Y-m-d",time());

    $dilayani = select("SELECT nomor_antrian FROM tb_counter WHERE id_unit = 1 AND tanggal_pengoperasian ='$hari_ini'");

    if($dilayani == NULL){
        $dilayani = 0;
    }else{
        $dilayani = (int) $dilayani[0]['nomor_antrian'];
    }

    $pasienBPJSOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa ='$hari_ini' AND jenis_pembiayaan = 'BPJS'")[0]['COUNT(id)'];
    $pasienBPJSOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa ='$hari_ini' AND no_bpjs IS NOT NULL")[0]['COUNT(id)'];
    $pasienBPJS = $pasienBPJSOffline + $pasienBPJSOnline;

    $pasienUmumOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa ='$hari_ini' AND jenis_pembiayaan = 'Umum'")[0]['COUNT(id)'];
    $pasienUmumOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa ='$hari_ini' AND no_bpjs IS NULL")[0]['COUNT(id)'];
    $pasienUmum = $pasienUmumOffline + $pasienUmumOnline;

    $qTotal = select("SELECT COUNT(id) FROM tb_antrian_administrasi WHERE tanggal_antrian ='$hari_ini'")[0]['COUNT(id)'];

    $time_now = date("H:i:s",time());

    echo json_encode(["dilayani"=>$dilayani,"qTotal"=>$qTotal,"pasienBPJS"=>$pasienBPJS,"pasienUmum"=>$pasienUmum,"time_now"=>$time_now]);die;
}elseif(isset($_GET['takeAntrian'])){
    // ambil antrian tombol handler
    $hari_ini = date("Y-m-d",time());
    $result = insertAntrianAdministrasi($hari_ini);

    echo json_encode(["no_antrian"=>$result]);die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ambil Antrian - I Clinic Unsoed</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../src/css/adminlte.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
      /* navigation bar */
        .content nav {
            height: 65px;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            width: 100%;
            z-index: 1;
        }
        .logo h1 {
            font-size: 30px;
            color: green;
        }
        .content nav .user {
            display: flex;
            align-items: center;
        }
        .content nav .user i{
            font-size: 25px;
            padding: 0 10px;
        }
      /* main */
        .main {
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;  
            background-color: #ECEDF0;
            transition: margin 0.3s ease-out;
            min-height: 100vh;
            color: #333;
        }

        .main .content {
            padding: 45px;
        }
        .main .content .center {
            width: 300px;
            margin: auto;
        }

        /*widget */
        .main .content h4 {
            text-align: center;
            margin-top: 0;
            font-weight: bold;
        }
        .main .content h5 {
            padding-top: 20px;
            font-weight: bold;
        }
        .main .grid-widget {
            display: grid;
            gap: 30px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .main .widget{
            text-align: center;
            font-size: 14px;
            padding: 25px;
            background-color: white;
            border-radius: 15px;
        }
        .main .widget .nomor {
            font-size: 40px;
            font-weight: 500;
        }

        .main .content .antri-btn {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
        }
        .main .antri-btn a {
            display: block;
            padding: 20px;
            color: white;
            background-color: green;
            border-radius: 15px;
        }
        .main .antri-btn a:hover{
            background-color: rgb(6, 150, 6);
        }

        .loading{
            width: 50px;
        }
  </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


<?php require '../components/admin/navbar.php' ?>
<?php require '../components/admin/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content" style="padding: 0;">
        <nav>
            <div class="logo">
                <a href=""><h1>i-Clinic</h1></a>
            </div>
            <div class="user">
                <i class="fas fa-user-circle"></i>
                Hallo !
            </div>
        </nav>
        <div class="main">
            <div class="content">
                <?php
                function tglIndonesia($str){
                    $tr   = trim($str);
                    $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
                    return $str;
                }  
                ?>
                <h4 style="margin-bottom: 5px;"><?php echo tglIndonesia(date('D, d F Y')); ?><span class="display_clock"></span></h4>
                <h6 style="text-align: center; margin-top:0;margin-bottom:40px; font-weight:bold;font-size:12px">Angka otomatis berubah jika ada antrian baru</h6>
                <h5 style="margin-bottom: 15px;">Antrian Hari ini</h5>
                <div class="grid-widget">
                    <div class="widget">
                        <div class="nomor active_queue"><img src="../src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                        Sedang Dilayani
                    </div>
                    <div class="widget">
                        <div class="nomor total_queue"><img src="../src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                        Total Antrian
                    </div>
                    <div class="widget">
                        <div class="nomor bpjs_patient"><img src="../src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                        Pasien BPJS
                    </div>
                    <div class="widget">
                        <div class="nomor umum_patient"><img src="../src/images/Spinner-1s-200px.svg" alt="" class="loading"></div>
                        Pasien Umum
                    </div>
                </div>
                <div class="grid-form" style="margin-top: 50px;">
                    <div class="group-menu">
                        <h5>Ambil Antrian</h5>
                        <div class="antri-btn">
                            <a href="javascript:void(0)" class="ambil_antrian">Ambil Sekarang</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <?php require '../components/admin/footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../src/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../src/js/adminlte.min.js"></script>

<script>
    function refresh(){
        //refresh counter antrian
        $.ajax({
        url: "ambilantrian.php",
        type : "POST",
        data : { 
                refresh : true,
            },
        dataType : "JSON",
        success: function(result){
            $(".active_queue").text(result.dilayani);
            $(".total_queue").text(result.qTotal);
            $(".bpjs_patient").text(result.pasienBPJS);
            $(".umum_patient").text(result.pasienUmum);
            $(".display_clock").text(" | "+result.time_now+" WIB");
        }});
    }

    refresh();
    setInterval(refresh,7000);

    // untuk ambil nomor antrian
    $(".ambil_antrian").on("click",()=>{
        $.ajax({
            url: "ambilantrian.php",
            type : "GET",
            data : { 
                    takeAntrian : true,
                },
            dataType : "JSON",
            success: function(result){
                window.open("../utility/print.php?reg=adm&data-id="+result.no_antrian);
                window.location.href = 'ambilantrian.php';
        }});
    })
    
</script>
</body>
</html>