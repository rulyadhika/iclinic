<?php 

require '../utility/function.php';
session_start();

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

$data = $_GET['data'];

    //submit handler

    if(isset($_POST['submit'])){
      if($data == 'poli klinik'){
        $result = insertPoliKlinik($_POST);
      }elseif($data == 'jadwal poli klinik'){
        $result = insertJadwalPoliKlinik($_POST);
      }elseif($data == 'user'){
        $result = registerAkun($_POST);
      }else{
        $result = insertLoketAdministrasi($_POST);
      }
    }

    //data handler
    if($data == 'jadwal poli klinik'){
        $poliKlinik = select("SELECT tb_unit.*,tb_biodata_user.nama as nama_dokter FROM tb_unit JOIN tb_akun_user
                      ON tb_unit.id_akun_dokter = tb_akun_user.id JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun
                      WHERE tb_unit.unit_status = 'Aktif'");
        $hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
    }elseif($data == 'poli klinik'){
        $dokter = select("SELECT tb_akun_user.id,tb_biodata_user.nama FROM tb_akun_user JOIN tb_biodata_user
                  ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_akun_user.user_role LIKE '%dokter%'");
    }else{
        $akun_petugas_adm = select("SELECT id,email FROM tb_akun_user WHERE user_role = 'petugas administrasi'
                            AND id NOT IN (SELECT id_assigned_user FROM tb_loket_administrasi)");
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
              <?php else :?>
                <h1 class="m-0 text-dark">Administrasi</h1>
              <?php endif; ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <?php if($data=='poli klinik') :?>
                <li class="breadcrumb-item active">Tambah Poli Klinik</li>
              <?php elseif($data=='jadwal poli klinik') :?>
                <li class="breadcrumb-item active">Tambah Jadwal Poli Klinik</li>
              <?php elseif($data=='user') :?>
                <li class="breadcrumb-item active">Tambah User</li>
              <?php else :?>
                <li class="breadcrumb-item active">Tambah Loket Administrasi</li>
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
                  <h5 class="my-auto">Tambah Poli Klinik</h5>
                <?php elseif($data=='jadwal poli klinik') :?>
                  <h5 class="my-auto">Tambah Jadwal Poli Klinik</h5>
                  <?php elseif($data=='user') :?>
                  <h5 class="my-auto">Tambah User</h5>
                <?php else :?>
                  <h5 class="my-auto">Tambah Loket Administrasi</h5>
                <?php endif; ?>
              </div>
              <div class="card-body">

                <!-- insert form poli klinik -->
                <?php if($data == 'poli klinik') :?>
                <form class="form-horizontal" action="" method="POST">
                    <div class="form-group row">
                        <label for="nama_poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <input type="text" class="form-control" id="nama_poli" name="nama_poli" placeholder="Masukan Nama Poli Klinik" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" style="width: 100%;" id="dokter" name="dokter" required>
                          <option value="" selected disabled>-- Pilih Dokter --</option>
                          <?php foreach($dokter as $dok) :?>
                            <option value="<?= $dok['id']; ?>"><?= $dok['nama']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="max_kuota" class="col-sm-2 col-form-label">Max Kuota</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control" id="max_kuota" name="max_kuota" placeholder="Masukan Kuota Maksimal Pasien" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Pasien</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" name="submit" class="btn btn-info">Tambah Data</button>
                        </div>
                    </div>   
                </form>

                <!-- insert form jadwal poli klinik -->
                <?php elseif($data == 'jadwal poli klinik') :?>
                <form class="form-horizontal" action="" method="POST">
                  <input type="hidden" name="id_unit" value="">
                    <div class="form-group row">
                        <label for="nama poli" class="col-sm-2 col-form-label">Nama Poli Klinik</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Poli</span>
                                </div>
                                <select class="form-control" id="nama poli" name="nama_poli" required>
                                    <option hidden value="">-- Pilih Poli Klinik --</option>
                                    <?php foreach($poliKlinik as $poli) :?>
                                       <option value="<?= $poli['id']; ?>"><?= $poli['nama_unit']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dokter" name="dokter" placeholder="Masukan Nama Dokter" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hari praktek" class="col-sm-2 col-form-label">Hari Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <select class="form-control" id="hari praktek" name="hari_praktek" required>
                                    <option hidden value="" >-- Pilih Hari --</option>
                                    <?php for($i=0; $i<count($hari);$i++) :?>
                                       <option value="<?= $hari[$i]; ?>"><?= $hari[$i]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu_praktek" class="col-sm-2 col-form-label">Waktu Praktek</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                                <input type="time" class="form-control" id="waktu_praktek" name="waktu_praktek" placeholder="Masukan Waktu Praktek" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" name="submit" class="btn btn-info">Tambah Data</button>
                        </div>
                    </div>   
                </form>

                <!-- insert user -->
                <?php elseif($data == 'user') :?>
                <form class="form-horizontal" action="" method="POST">
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                              </div>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email" required>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                              </div>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
                          </div>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="text" class="form-control" id="nama" name="nama_pasien" placeholder="Masukan Nama" required>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="number" class="form-control" id="nik" name="nik_pasien" placeholder="Masukan NIK" required>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="no_bpjs" class="col-sm-2 col-form-label">No BPJS</label>
                      <div class="col-sm-10">
                          <div class="input-group">
                              <input type="number" class="form-control" id="no_bpjs" name="nomor_bpjs" placeholder="Kosongkan bila tidak ada">
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
                          <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
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
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki - laki" value="Laki - laki" required>
                            <label class="form-check-label" for="laki - laki">Laki - laki</label>
                          </div>
                          <div class="form-check my-auto mx-2">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
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
                            <option value="Belum Tahu">Belum Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Pasien" required></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="no_hp" class="col-sm-2 col-form-label">No Hp</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan No Hp" required></input>
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
                            <option value="kepala klinik">Kepala Klinik</option>
                            <option value="petugas administrasi">Petugas Administrasi</option>
                            <option value="dokter">Dokter</option>
                            <option value="pasien">Pasien</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" name="submit" class="btn btn-info">Tambah Data</button>
                        </div>
                    </div>   
                </form>

                <!-- insert loket administrasi -->
                <?php else :?>

                <form class="form-horizontal" action="" method="POST">
                    <div class="form-group row">
                        <label for="no_loket" class="col-sm-2 col-form-label">Nomor Loket</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="no_loket" name="no_loket" placeholder="Masukan Nomor Loket" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assign_akun" class="col-sm-2 col-form-label">Assign Ke Akun</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="assign_akun" name="assign_akun" required>
                                  <option hidden value="" >-- Pilih Akun --</option>
                                    <?php foreach($akun_petugas_adm as $akun) :?>              
                                      <option value="<?= $akun['id']; ?>"><?= $akun['email']; ?></option>
                                    <?php endforeach; ?>

                                    <?php if(count($akun_petugas_adm)== 0) :?>
                                      <option value="" disabled>Tidak ada akun petugas administrasi yang tersedia</option>
                                    <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12 justify-content-end d-flex mb-0">
                            <button type="submit" name="submit" class="btn btn-info">Tambah Data</button>
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
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Select2 -->
<script src="../src/plugins/select2/js/select2.full.min.js"></script>

<!-- alert popUp area -->
<?php if(isset($result)):?>
      
  <?php if($_GET['data']=='poli klinik') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Data Poli Klinik Berhasil Ditambahkan', 'success')
              .then((value) => {
                  window.location.href = 'unit.php?data=poli%20klinik';
              });
          <?php else :?>
              swal('Error!', 'Data Poli Klinik Gagal Ditambahkan', 'error')
              .then((value) => {
                  window.location.href = 'insert.php?data=poli%20klinik';
              });
          <?php endif; ?>
      </script> 

  <?php elseif($_GET['data']=='jadwal poli klinik') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Data Jadwal Berhasil Ditambahkan', 'success')
              .then((value) => {
                  window.location.href = 'unit.php?data=jadwal%20poli%20klinik';
              });
          <?php else :?>
              swal('Error!', 'Data Jadwal Gagal Ditambahkan', 'error')
              .then((value) => {
                  window.location.href = 'insert.php?data=jadwal%20poli%20klinik';
              });
          <?php endif; ?>
      </script> 

  <?php elseif($_GET['data']=='user') :?>
      <script>
          <?php if($result==(1)) :?>
              swal('Berhasil!', 'Akun User Berhasil Ditambahkan', 'success')
              .then((value) => {
                  window.location.href = 'list.php?data=user';
              });
          <?php elseif($result=='email sudah pernah didaftarkan') :?>
              swal('Gagal!', 'Email sudah pernah didaftarkan! Silahkan gunakan alamat email lain', 'error')
              .then((value) => {
                  window.location.href = 'insert.php?data=user';
              });
          <?php elseif($result=='password minimal 8 karakter') :?>
              swal('Perhatian!', 'Password minimal 8 karakter!', 'warning')
              .then((value) => {
                  window.location.href = 'insert.php?data=user';
              });
          <?php else :?>
              swal('Error!', 'Akun User Gagal Ditambahkan', 'error')
              .then((value) => {
                  window.location.href = 'insert.php?data=user';
              });
          <?php endif; ?>
      </script> 
    
    <!-- $data = administrasi -->
    <?php else :?>
    <script>
        <?php if($result==(1)) :?>
            swal('Berhasil!', 'Data Loket Administrasi Berhasil Ditambahkan', 'success')
            .then((value) => {
                  window.location.href = 'unit.php?data=administrasi';
              });
        <?php else :?>
            swal('Error!', 'Terjadi kesalahan, silahkan tunggu beberapa saat lalu coba lagi', 'error')
            .then((value) => {
                  window.location.href = 'insert.php?data=administrasi';
              });
        <?php endif; ?>
    </script>

  <?php endif; ?>

<?php endif; ?>

<!-- end of alert popup area -->

<?php if($data=='jadwal poli klinik') :?>
    <script>
        $("select[name=nama_poli]").on("input",function(){
            const poliKlinik = <?= json_encode($poliKlinik) ?>;
            let poliSelected = poliKlinik.filter(poli=>poli.id==this.value)[0];
            $("input[name=dokter]").val(poliSelected.nama_dokter);
            $("input[name=id_unit]").val(poliSelected.id);
        })
    </script>
<?php elseif($data == 'poli klinik'):?>
  <script>
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });
  </script>
<?php endif; ?>
</body>
</html>