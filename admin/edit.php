<?php 

require '../utility/function.php';

$data = $_GET['data'];
$id = $_GET['id'];

    if($data == 'poli klinik'){
        $poliKlinik = select("SELECT tb_unit.*,tb_akun_user.id as id_akun_dokter,tb_biodata_user.nama FROM tb_unit JOIN tb_akun_user
                      ON tb_unit.id_akun_dokter = tb_akun_user.id JOIN tb_biodata_user 
                      ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_unit.id=$id")[0];

        $dokter = select("SELECT tb_akun_user.id as id_akun,tb_biodata_user.nama FROM tb_akun_user JOIN tb_biodata_user 
                  ON tb_akun_user.id = tb_biodata_user.id_akun");
    }elseif($data == 'jadwal poli klinik'){
        $jadwalPoliKlinik = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_unit.dokter FROM tb_jadwal JOIN tb_unit
                            ON tb_jadwal.id_unit = tb_unit.id WHERE tb_jadwal.id=$id")[0];
        $hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../src/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="../src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


<?php require '../components/admin/navbar.php' ?>
<?php require '../components/admin/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Poli Klinik</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $data=='poli klinik'? 'Edit Poli Klinik':'Edit Jadwal Poli Klinik'; ?></li>
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
          <div class="col">
            <div class="card ">
              <div class="card-header">
                <h5 class="m-0"><?= $data=='poli klinik'? 'Edit Poli Klinik':'Edit Jadwal Poli Klinik'; ?></h5>
              </div>
              <div class="card-body">

                <!-- edit form poli klinik -->
                <?php if($data == 'poli klinik') :?>
                <form class="form-horizontal">
                  <input type="hidden" name="id_unit" value="<?= $poliKlinik['id']; ?>">
                    <div class="form-group row">
                        <label for="nama poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <input type="text" class="form-control" id="nama poli" placeholder="Masukan Nama Poli Klinik" value="<?= $poliKlinik['nama_unit']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-10">
                          <select class="form-control select2" style="width: 100%;" id="dokter" name="dokter" required>
                            <option value="" selected disabled>-- Pilih Dokter --</option>
                            <?php foreach($dokter as $dok) :?>
                              <option value="<?= $dok['id']; ?>" <?= ($poliKlinik['id_akun_dokter'] == $dok['id_akun'])?'selected':''; ?>><?= $dok['nama']; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="max kuota" class="col-sm-2 col-form-label">Max Kuota</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control" id="max kuota" placeholder="Masukan Kuota Maksimal Pasien" value="<?= $poliKlinik['max_kuota']; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Pasien</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status poli" class="col-sm-2 col-form-label">Status Poli Klinik</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status poli" name="status_poli">
                                <option hidden >-- Pilih Status --</option>
                                <option <?= $poliKlinik['unit_status']=="Aktif"?'Selected':''; ?> value="Aktif">Aktif</option>
                                <option <?= $poliKlinik['unit_status']=="Non-Aktif"?'Selected':''; ?> value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                      </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" class="btn btn-info">Edit Data</button>
                        </div>
                    </div>   
                </form>

                <!-- edit form jadwal poli klinik -->
                <?php elseif($data == 'jadwal poli klinik') :?>
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="nama poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <input type="text" class="form-control" id="nama poli" placeholder="Masukan Nama Poli Klinik" value="<?= $jadwalPoliKlinik['nama_unit']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dokter" placeholder="Masukan Nama Dokter" value="<?= $jadwalPoliKlinik['dokter']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hari praktek" class="col-sm-2 col-form-label">Hari Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <select class="form-control" id="hari praktek" name="hari_praktek">
                                    <option hidden >-- Pilih Hari --</option>
                                    <?php for($i=0; $i<count($hari);$i++) :?>
                                       <option <?= $hari[$i]==$jadwalPoliKlinik['hari_praktek']?'selected':''; ?> value="<?= $hari[$i]; ?>"><?= $hari[$i]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu praktek" class="col-sm-2 col-form-label">Waktu Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group date" id="timepicker" data-target-input="nearest">
                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                                <input type="time" class="form-control" id="waktu praktek" placeholder="Masukan Waktu Praktek" value="<?= $jadwalPoliKlinik['waktu_praktek']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status jadwal" class="col-sm-2 col-form-label">Status Jadwal</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status jadwal" name="status_jadwal">
                                <option hidden >-- Pilih Status --</option>
                                <option <?= $jadwalPoliKlinik['status_jadwal']=="Aktif"?'Selected':''; ?> value="Aktif">Aktif</option>
                                <option <?= $jadwalPoliKlinik['status_jadwal']=="Non-Aktif"?'Selected':''; ?> value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                      </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" class="btn btn-info">Edit Data</button>
                        </div>
                    </div>   
                </form>
                <?php endif; ?>
              </div>
            </div> 
          </div>
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

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../src/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../src/js/adminlte.min.js"></script>
</body>
</html>