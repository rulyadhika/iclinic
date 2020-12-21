<?php 
session_start();

// redirect handler
if(!isset($_SESSION['login'])){
  header("Location:../login.php");die;
}else{
  if($_SESSION['role']=='pasien' || $_SESSION['role']=='antrian adm'){
    header("Location:../index.php");die;
  }
}

require '../utility/function.php';

$hari_ini = date("Y-m-d",time());

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

// ambil data unit aktif
$unitAktif = select("SELECT COUNT(id) FROM tb_unit WHERE unit_status = 'Aktif'")[0]['COUNT(id)'];
// ambil data jadwal aktif
$jadwalAktif = select("SELECT COUNT(id) FROM tb_jadwal WHERE status_jadwal = 'Aktif'")[0]['COUNT(id)'];
// ambil data dokter
$jmlDokter = select("SELECT COUNT(id) FROM tb_akun_user WHERE user_role = 'dokter'")[0]['COUNT(id)'];
// ambil data user
$jmlUser = select("SELECT COUNT(id) FROM tb_akun_user")[0]['COUNT(id)'];

// ambil data pasien bpjs
$pasienBPJSOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = '$hari_ini' AND jenis_pembiayaan = 'BPJS'")[0]['COUNT(id)'];
$pasienBPJSOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = '$hari_ini' AND no_bpjs IS NOT NULL")[0]['COUNT(id)'];
$pasienBPJS = $pasienBPJSOffline + $pasienBPJSOnline;

// ambil data pasien umum
$pasienUmumOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = '$hari_ini' AND jenis_pembiayaan = 'Umum'")[0]['COUNT(id)'];
$pasienUmumOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = '$hari_ini' AND no_bpjs IS NULL")[0]['COUNT(id)'];
$pasienUmum = $pasienUmumOffline + $pasienUmumOnline;

// ambil data antrian administrasi
$qTotalAdministrasi = select("SELECT COUNT(id) FROM tb_antrian_administrasi WHERE tanggal_antrian = '$hari_ini'")[0]['COUNT(id)'];

// ambil data pasien terverifikasi
$pasienTerverifikasiOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = '$hari_ini' AND verifikasi_administrasi = 'Terverifikasi'")[0]['COUNT(id)'];
$pasienTerverifikasiOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = '$hari_ini' AND verifikasi_administrasi = 'Terverifikasi'")[0]['COUNT(id)'];
$pasienTerverifikasi = $pasienTerverifikasiOffline + $pasienTerverifikasiOnline;

// ambil data pasien belum terverifikasi
$pasienBelumVerifikasiOnline = select("SELECT COUNT(id) FROM tb_pendaftaran_online WHERE tanggal_periksa = '$hari_ini' AND verifikasi_administrasi = 'Belum Verifikasi'")[0]['COUNT(id)'];
$pasienBelumVerifikasiOffline = select("SELECT COUNT(id) FROM tb_pendaftaran_offline WHERE tanggal_periksa = '$hari_ini' AND verifikasi_administrasi = 'Belum Verifikasi'")[0]['COUNT(id)'];
$pasienBelumVerifikasi = $pasienBelumVerifikasiOffline + $pasienBelumVerifikasiOnline;

//ambil data pendaftar
$pendaftarOffline = $pasienUmumOffline + $pasienBPJSOffline;
$pendaftarOnline = $pasienUmumOnline + $pasienBPJSOnline;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Dashboard - I Clinic Unsoed</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../src/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../src/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../src/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">



<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item border-right">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
          class="fas fa-th-large"></i></a>
    </li> -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-cog"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="../index.php" class="dropdown-item">
          <i class="fa fa-home mr-2"></i> Homepage
        </a>
        <div class="dropdown-divider"></div>
        <a href="../logout.php" class="dropdown-item">
          <i class="fa fa-sign-out-alt mr-2"></i> Log out
        </a>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item dropdown-header">Setting</span>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
<?php require '../components/admin/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard I-Clinic Unsoed</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="row">

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
              <div class="inner">
                <h3><?= $unitAktif; ?></h3>

                <p>Unit Aktif</p>
              </div>
              <div class="icon">
                <i class="fa fa-clinic-medical"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-success">
              <div class="inner">
              <h3><?= $jadwalAktif; ?></h3>

                <p>Jadwal Aktif</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-info">
              <div class="inner">
              <h3><?= $jmlDokter; ?></h3>

                <p>Dokter</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-md"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-warning">
              <div class="inner">
              <h3><?= $jmlUser; ?></h3>

                <p>Pengguna</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>

          
        </div>

        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body text-center pt-5 pb-5" style="color:#858796;">
                <h2 class="font-weight-bold text-uppercase">SELAMAT <span class="waktu">Datang</span>, <?= $_SESSION['user_name']; ?></h2>
                <h1 class="clockDisplay font-weight-bold"></h1>
                <h5 class="dateDisplay"></h5>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <h5>Info Antrian Hari Ini</h5>
              </div>
              <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                  <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-clinic-medical"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Antrian Terdaftar</span>
                    <span class="info-box-number">
                      <?= $qTotalAdministrasi; ?>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
            
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-address-card"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pasien BPJS</span>
                  <span class="info-box-number">
                  <?= $pasienBPJS; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-hospital-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pasien Umum</span>
                  <span class="info-box-number">
                  <?= $pasienUmum; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-olive elevation-1"><i class="fa fa-user-check"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Terverifikasi</span>
                  <span class="info-box-number">
                  <?= $pasienTerverifikasi; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-user-times"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Belum Terverifikasi </span>
                  <span class="info-box-number">
                  <?= $pasienBelumVerifikasi; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-gray-dark elevation-1"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pendaftar Online</span>
                  <span class="info-box-number">
                  <?= $pendaftarOnline; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-navy elevation-1"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pendaftar Offline</span>
                  <span class="info-box-number">
                  <?= $pendaftarOffline; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>

          </div>
          <!-- col-lg-8 -->
        </div>  
        <!-- row -->
          
          <!-- /.col-md-6 -->
          <div class="col-lg-4">
            <!-- kalender -->
            <div class="card bg-gradient-white">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-l btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-white btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-white btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<!-- jQuery UI 1.11.4 -->
<script src="../src/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../src/js/adminlte.min.js"></script>
<!-- daterangepicker -->
<script src="../src/plugins/moment/moment.min.js"></script>
<script src="../src/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../src/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- The Calender -->
<script>
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })
</script>
<!-- clock -->
<script src="../src/js/clock.js"></script>
<!-- page script -->
<script>
  setInterval(()=>{
    location.reload();  
  },500000)
</script>
</body>
</html>