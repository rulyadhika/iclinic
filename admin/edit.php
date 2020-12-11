<?php 
require '../utility/function.php';
session_start();

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

//menerima request parameter dari url
$data = $_GET['data'];
$id = $_GET['id'];

    //submit handler
    if(isset($_POST['update'])){
      if($data=='poli klinik'){
        $result = updatePoliKlinik($_POST);
      }elseif($data=='jadwal poli klinik'){
        $result = updateJadwalPoliKlinik($_POST);
      }elseif($data=='user'){
        $result = updateDataUser($_POST);
      }
    }

    //data handler
    if($data == 'poli klinik'){
        $poliKlinik = select("SELECT tb_unit.*,tb_akun_user.id as id_akun_dokter,tb_biodata_user.nama FROM tb_unit JOIN tb_akun_user
                      ON tb_unit.id_akun_dokter = tb_akun_user.id JOIN tb_biodata_user 
                      ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_unit.id=$id")[0];

        //mengambil seluruh nama2 dokter
        $dokter = select("SELECT tb_akun_user.id as id_akun,tb_biodata_user.nama FROM tb_akun_user JOIN tb_biodata_user 
                  ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_akun_user.user_role = 'dokter'");

    }elseif($data == 'jadwal poli klinik'){
        $jadwalPoliKlinik = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_biodata_user.nama as nama_dokter FROM tb_jadwal JOIN tb_unit
                            ON tb_jadwal.id_unit = tb_unit.id JOIN tb_akun_user ON tb_unit.id_akun_dokter = tb_akun_user.id 
                            JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_jadwal.id=$id")[0];
        $hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
    }elseif($data == 'user'){
        $user_id = $_GET['id'];

        $data_user = select("SELECT tb_akun_user.id as id_akun_user,tb_akun_user.email,tb_akun_user.user_role,tb_biodata_user.*
                    FROM tb_akun_user JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_akun_user.id = $user_id")[0];
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

  <!-- Select2 -->
  <link rel="stylesheet" href="../src/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
            <?php if($data=='poli klinik') :?>
              <h1 class="m-0 text-dark">Poli Klinik</h1>
            <?php elseif($data=='user') :?>
              <h1 class="m-0 text-dark">Kelola User</h1>
            <?php endif; ?>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <?php if($data=='poli klinik') :?>
                <li class="breadcrumb-item active">Edit Poli Klinik</li>
              <?php elseif($data=='jadwal poli klinik') :?>
                <li class="breadcrumb-item active">Edit Jadwal Poli Klinik</li>
              <?php elseif($data=='user') :?>
                <li class="breadcrumb-item active">Edit Data User</li>
              <?php endif; ?>
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
              <?php if($data=='poli klinik') :?>
                <h5 class="m-0">Edit Poli Klinik</h5>
              <?php elseif($data=='jadwal poli klinik') :?>
                <h5 class="m-0">Edit Jadwal Poli Klinik</h5>
              <?php elseif($data=='user') :?>
                <h5 class="m-0">Edit Data User</h5>
              <?php endif; ?>
              </div>
              <div class="card-body">

                <!-- edit form poli klinik -->
                <?php if($data == 'poli klinik') :?>
                <form class="form-horizontal" action="" method="POST">
                  <input type="hidden" name="id_unit" value="<?= $poliKlinik['id']; ?>">
                    <div class="form-group row">
                        <label for="nama_poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <input type="text" class="form-control" id="nama_poli" name="nama_poli" placeholder="Masukan Nama Poli Klinik" value="<?= $poliKlinik['nama_unit']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-10">
                          <select class="form-control select2" style="width: 100%;" id="dokter" name="dokter" required>
                            <option value="" selected disabled>-- Pilih Dokter --</option>
                            <?php foreach($dokter as $dok) :?>
                              <option value="<?= $dok['id_akun']; ?>" <?= ($poliKlinik['id_akun_dokter'] == $dok['id_akun'])?'selected':''; ?>><?= $dok['nama']; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="max_kuota" class="col-sm-2 col-form-label">Max Kuota</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control" id="max_kuota" name="max_kuota" placeholder="Masukan Kuota Maksimal Pasien" value="<?= $poliKlinik['max_kuota']; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Pasien</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status_poli" class="col-sm-2 col-form-label">Status Poli Klinik</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status_poli" name="status_poli">
                                <option hidden >-- Pilih Status --</option>
                                <option <?= $poliKlinik['unit_status']=="Aktif"?'Selected':''; ?> value="Aktif">Aktif</option>
                                <option <?= $poliKlinik['unit_status']=="Non-Aktif"?'Selected':''; ?> value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                      </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" class="btn btn-info" name="update">Edit Data</button>
                        </div>
                    </div>   
                </form>

                <!-- edit form adata user -->
                <?php elseif($data == "user") :?>
                  <form class="form-horizontal" action="" method="POST">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                              </div>
                              <input type="email" class="form-control" id="email" placeholder="Masukan Email" value="<?= $data_user['email']; ?>" readonly required>
                          </div>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="text" class="form-control" id="nama" name="nama_pasien" placeholder="Masukan Nama" value="<?= $data_user['nama']; ?>" required>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="number" class="form-control" id="nik" name="nik_pasien" placeholder="Masukan NIK" value="<?= $data_user['nik']; ?>" required>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="no_bpjs" class="col-sm-2 col-form-label">No BPJS</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="number" class="form-control" id="no_bpjs" name="nomor_bpjs" value="<?= $data_user['no_bpjs']; ?>" placeholder="Kosongkan bila tidak ada">
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                          <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data_user['tanggal_lahir']; ?>" required>
                          <div class="input-group-append">
                              <div class="input-group-text">Bulan / Hari / Tahun</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Jenis Kelamin </label>
                      <div class="col-sm-10 d-flex flex-row">
                          <div class="form-check my-auto mx-2">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki - laki" value="Laki - laki" <?= $data_user['jenis_kelamin']=='Laki - laki'?'checked':''; ?> required>
                            <label class="form-check-label" for="laki - laki">Laki - laki</label>
                          </div>
                          <div class="form-check my-auto mx-2">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?= $data_user['jenis_kelamin']=='Perempuan'?'checked':''; ?>>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="gol_darah" class="col-sm-2 col-form-label">Gol. Darah</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <select class="form-control" id="gol_darah" name="gol_darah" required>
                            <option hidden="" value="">-- Pilih Golongan Darah --</option>
                            <option value=="Belum Tahu" <?= $data_user['gol_darah']=='Belum Tahu'?'selected':''; ?> >Belum Tahu</option>
                            <option value="A" <?= $data_user['gol_darah']=='A'?'selected':''; ?> >A</option>
                            <option value="B" <?= $data_user['gol_darah']=='B'?'selected':''; ?> >B</option>
                            <option value="AB" <?= $data_user['gol_darah']=='AB'?'selected':''; ?> >AB</option>
                            <option value="O" <?= $data_user['gol_darah']=='0'?'selected':''; ?> >O</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Pasien" required><?= $data_user['alamat']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="no_hp" class="col-sm-2 col-form-label">No Hp</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan No Hp" value="0<?= $data_user['no_hp']; ?>" required></input>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="role" class="col-sm-2 col-form-label">Role</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-user-tag"></i></div>
                          </div>
                          <select class="form-control" id="role" name="role" required>
                            <option hidden="" value="">-- Pilih Role --</option>
                            <option value="kepala klinik" <?= $data_user['user_role']=='kepala klinik'?'selected':''; ?> >Kepala Klinik</option>
                            <option value="petugas administrasi" <?= $data_user['user_role']=='petugas administrasi'?'selected':''; ?>>Petugas Administrasi</option>
                            <option value="dokter" <?= $data_user['user_role']=='dokter'?'selected':''; ?>>Dokter</option>
                            <option value="pasien" <?= $data_user['user_role']=='pasien'?'selected':''; ?>>Pasien</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" name="update" class="btn btn-info">Edit Data</button>
                        </div>
                    </div>   
                  </form>

                <!-- edit form jadwal poli klinik -->
                <?php elseif($data == 'jadwal poli klinik') :?>
                <form class="form-horizontal" action="" method="POST">
                  <input type="hidden" name="id_jadwal" value="<?= $jadwalPoliKlinik['id']; ?>">
                    <div class="form-group row">
                        <label for="nama_poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <input type="text" class="form-control" id="nama_poli" value="<?= $jadwalPoliKlinik['nama_unit']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dokter" value="<?= $jadwalPoliKlinik['nama_dokter']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hari_praktek" class="col-sm-2 col-form-label">Hari Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <select class="form-control" id="hari_praktek" name="hari_praktek">
                                    <option hidden >-- Pilih Hari --</option>
                                    <?php for($i=0; $i<count($hari);$i++) :?>
                                       <option <?= $hari[$i]==$jadwalPoliKlinik['hari_praktek']?'selected':''; ?> value="<?= $hari[$i]; ?>"><?= $hari[$i]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu_praktek" class="col-sm-2 col-form-label">Waktu Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group date" id="timepicker" data-target-input="nearest">
                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                                <input type="time" class="form-control" id="waktu_praktek" name="waktu_praktek" placeholder="Masukan Waktu Praktek" value="<?= $jadwalPoliKlinik['waktu_praktek']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status_jadwal" class="col-sm-2 col-form-label">Status Jadwal</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status_jadwal" name="status_jadwal">
                                <option hidden >-- Pilih Status --</option>
                                <option <?= $jadwalPoliKlinik['status_jadwal']=="Aktif"?'Selected':''; ?> value="Aktif">Aktif</option>
                                <option <?= $jadwalPoliKlinik['status_jadwal']=="Non-Aktif"?'Selected':''; ?> value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                      </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" class="btn btn-info" name="update">Edit Data</button>
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
<!-- Select2 -->
<script src="../src/plugins/select2/js/select2.full.min.js"></script>
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- alert popUp area -->
<?php if(isset($result)):?>
      
  <?php if($_GET['data']=='poli klinik') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Data Poli Klinik Berhasil Diupdate', 'success')
              .then((value) => {
                  window.location.href = 'unit.php?data=poli%20klinik';
              });
          <?php else :?>
              swal('Error!', 'Data Poli Klinik Gagal Diupdate', 'error');
          <?php endif; ?>
      </script> 

  <?php elseif($_GET['data']=='jadwal poli klinik') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Data Jadwal Berhasil Diupdate', 'success')
              .then((value) => {
                  window.location.href = 'unit.php?data=jadwal%20poli%20klinik';
              });
          <?php else :?>
              swal('Error!', 'Data Jadwal Gagal Diupdate', 'error');
          <?php endif; ?>
      </script> 

  <?php elseif($_GET['data']=='user') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Data User Berhasil Diupdate', 'success')
              .then((value) => {
                  window.location.href = 'list.php?data=user';
              });
          <?php else :?>
              swal('Error!', 'Data User Gagal Diupdate', 'error');
          <?php endif; ?>
      </script> 

  <?php endif; ?>

<?php endif; ?>
<!-- end of alert popup area -->



<?php if($data == 'poli klinik'):?>
  <script>
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });
  </script>
<?php endif; ?>
</body>
</html>