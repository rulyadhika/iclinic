<?php 
session_start();

// redirect handler
if(!isset($_SESSION['login'])){
  header("Location:../login.php");die;
}else{
  if($_SESSION['role']=='pasien' || $_SESSION['role']=='antrian adm' || $_SESSION['role']=='dokter'){
    header("Location:../index.php");die;
  }
}

require '../utility/function.php';

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

$data = $_GET['data'];

    if($data == 'poli klinik'){
        $poliKlinik = select("SELECT tb_unit.*,tb_biodata_user.nama FROM tb_unit JOIN tb_akun_user
                      ON tb_unit.id_akun_dokter = tb_akun_user.id JOIN tb_biodata_user 
                      ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_unit.id>1 ORDER BY tb_unit.nama_unit");
    }elseif($data == 'jadwal poli klinik'){
        $jadwalPoliKlinik = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_biodata_user.nama as nama_dokter FROM tb_jadwal JOIN tb_unit
                            ON tb_jadwal.id_unit = tb_unit.id JOIN tb_akun_user ON tb_unit.id_akun_dokter = tb_akun_user.id 
                            JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_jadwal.id_unit>1 ORDER BY tb_unit.nama_unit");
    }else{
        $loket_administrasi = select("SELECT tb_loket_administrasi.*,tb_akun_user.email FROM tb_loket_administrasi
                              JOIN tb_akun_user ON tb_loket_administrasi.id_assigned_user = tb_akun_user.id");
    }


$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Unit - Dashboard | I Clinic Unsoed</title>

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
            <h1 class="m-0 text-dark"><?= $data=='poli klinik'? 'Poli Klinik':'Administrasi' ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <?php if($data=='poli klinik') :?>
                <li class="breadcrumb-item active">List Poli Klinik</li>
              <?php elseif($data=='jadwal poli klinik') :?>
                <li class="breadcrumb-item active">Jadwal Poli Klinik</li>
              <?php else :?>
                <li class="breadcrumb-item active">Kelola Administrasi</li>
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
                <div class="d-flex justify-content-between ">
                <?php if($data=='poli klinik') :?>
                  <h5 class="my-auto">List Poli Klinik</h5>
                  <a href="insert.php?data=poli klinik" class="btn btn-sm btn-primary">+ Tambah Poli Klinik</a>
                <?php elseif($data=='jadwal poli klinik') :?>
                  <h5 class="my-auto">Jadwal Poli Klinik</h5>
                  <a href="insert.php?data=jadwal poli klinik" class="btn btn-sm btn-primary">+ Tambah Jadwal</a>
                <?php else :?>
                  <h5 class="my-auto">List Loket Administrasi</h5>
                  <a href="insert.php?data=administrasi" class="btn btn-sm btn-primary">+ Tambah Loket</a>
                <?php endif; ?>
                </div>
              </div>
              <div class="card-body">

                <!-- tabel list poli klinik -->
                <?php if($data == 'poli klinik') :?>
                <table id="example2" class="table table-bordered table-hover" >
                  <thead>
                  <tr class="text-center">
                    <th>No.</th>
                    <th>Nama Poli</th>
                    <th>Dokter</th>
                    <th>Max Kuota</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm-center">
                  <?php foreach($poliKlinik as $poli)  :?>
                  <tr>
                    <td class="font-weight-bold"><?= $no; ?></td>
                    <td><?= $poli['nama_unit']; ?></td>
                    <td><?= $poli['nama']; ?></td>
                    <td><?= $poli['max_kuota']; ?> Pasien</td>
                    <td class="text-<?= $poli['unit_status']=="Aktif"?'success':'danger' ?>"><?= $poli['unit_status']; ?></td>
                    <td class="text-center">
                        <a class="btn btn-info mx-1 my-1 my-md-0" href="edit.php?data=poli klinik&id=<?= $poli['id']; ?>"><i class="fa fa-pencil-alt"></i></a>
                        <a class="btn btn-danger mx-1 my-1 my-md-0 del-btn" data-id="<?= $poli['id']; ?>" data-type="poli" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>

                <!-- tabel list jadwal poli klinik -->
                <?php elseif($data == 'jadwal poli klinik') :?>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Poli</th>
                    <th>Hari Praktek</th>
                    <th>Waktu Praktek</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm-center">
                  <?php foreach($jadwalPoliKlinik as $jadwalPoli)  :?>
                  <tr>
                    <td class="font-weight-bold"><?= $no; ?></td>
                    <td><?= $jadwalPoli['nama_unit']; ?> (<?= $jadwalPoli['nama_dokter']; ?>)</td>
                    <td><?= $jadwalPoli['hari_praktek']; ?></td>
                    <td><?= date("H:i",strtotime($jadwalPoli['waktu_praktek'])); ?> WIB</td>
                    <td class="text-<?= $jadwalPoli['status_jadwal']=="Aktif"?'success':'danger' ?>"><?= $jadwalPoli['status_jadwal']; ?></td>
                    <td>
                        <a class="btn btn-info mx-1 my-1 my-md-0" href="edit.php?data=jadwal poli klinik&id=<?= $jadwalPoli['id']; ?>"><i class="fa fa-pencil-alt"></i></a>
                        <a class="btn btn-danger mx-1 my-1 my-md-0 del-btn" data-id="<?= $jadwalPoli['id']; ?>" data-type="jadwal poli" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>

                <!-- table list loket administrasi -->
                <?php else: ?>

                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr class="text-center">
                    <th>No.</th>
                    <th>Nomor Loket</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm-center">
                  <?php foreach($loket_administrasi as $loket_administrasi)  :?>
                  <tr>
                    <td class="font-weight-bold"><?= $no; ?></td>
                    <td><?= $loket_administrasi['no_loket']; ?></td>
                    <td><?= $loket_administrasi['email']; ?></td>
                    <td class="text-success font-weight-bold">Aktif</td>
                    <td>
                        <a class="btn btn-danger mx-1 my-1 my-md-0 del-btn" data-id="<?= $loket_administrasi['id']; ?>" data-type="administrasi" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>

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
<!-- DataTables -->
<script src="../src/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../src/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "columnDefs": [{
                    "orderable": false,
                    "targets": [4]
                }]
    });
  });
</script>   

<!-- script delete data -->
<script>
      $('.del-btn').on("click",async function(){
          let confirm = await swal({
              title: "Apakah anda yakin?",
              text: "Setelah dihapus, anda tidak akan bisa mendapatkan data ini lagi!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
              })
              .then((willDelete) => {
              if (willDelete) {
                  return true;
              } else {
                  return false;
              }
          });

          if(confirm==true){
              try {
                  let result = await delData(this.dataset.type,this.dataset.id);
                  if(result==1){
                    swal('Success!', ' Data Berhasil Dihapus', 'success')
                    .then(()=>{
                      location.reload();
                    });

                  }else{
                    swal('Error!', 'Data ini masih terhubung dengan database lain, silahkan cek kembali!', 'error');
                  }

              } catch (error) {
                  console.error(error);
              }
          }
      });

      function delData(type,id){
          return fetch("delete.php?data="+type+"&id="+id)
          .then(result=>result.text())
          .then(result=>result)
      }
</script>
</body>
</html>