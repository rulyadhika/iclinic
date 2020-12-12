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

//constant agar bisa mengakses components navbar dan sidebar
define("root",true);

$data = $_GET['data'];

if($_SESSION['role']=='dev' || $_SESSION['role']=='kepala klinik'){
  if($data=='user'){
        $list_users = select("SELECT tb_akun_user.id,tb_akun_user.email,tb_akun_user.user_role,tb_biodata_user.nama,
                        tb_biodata_user.no_hp,tb_biodata_user.alamat FROM tb_akun_user JOIN tb_biodata_user 
                        ON tb_akun_user.id = tb_biodata_user.id_akun");
    }elseif($data=='pesan'){
        $pesan = select("SELECT * FROM tb_saran_masukan ORDER BY waktu_submit DESC");
    }
}else{
  header("Location:./dashboard.php");die;
}

$no = 1;

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
            <h1 class="m-0 text-dark"><?= $data=='user'? 'Kelola User':'Saran Masukan' ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <?php if($data=='user') :?>
                <li class="breadcrumb-item active">List User</li>
              <?php elseif($data=='pesan') :?>
                <li class="breadcrumb-item active">Saran Masukan</li>
              <?php else :?>
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
                <?php if($data=='user') :?>
                  <h5 class="my-auto">List User</h5>
                  <a href="insert.php?data=user" class="btn btn-sm btn-primary">+ Tambah User</a>
                <?php elseif($data=='pesan') :?>
                  <h5 class="my-auto">List Saran Masukan</h5>
                <?php else :?>
                <?php endif; ?>
                </div>
              </div>
              <div class="card-body">

                <?php if($data == 'user') :?>
                  <!-- tabel list data user -->
                <table id="example2" class="table table-bordered table-hover" >
                  <thead>
                  <tr class="text-center">
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm-center">
                  <?php foreach($list_users as $list_user)  :?>
                  <tr>
                    <td class="font-weight-bold"><?= $no; ?></td>
                    <td><?= $list_user['nama']; ?></td>
                    <td><?= $list_user['email']; ?></td>
                    <td>0<?= $list_user['no_hp']; ?></td>
                    <td><?= $list_user['alamat']; ?></td>
                    <td style="text-transform: capitalize;"><?= $list_user['user_role']; ?></td>
                    <td class="text-center">
                        <a class="btn btn-info mx-1 my-1 my-md-0" href="edit.php?data=user&id=<?= $list_user['id']; ?>"><i class="fa fa-pencil-alt"></i></a>
                        <a class="btn btn-danger mx-1 my-1 my-md-0" href=""><i class="fa fa-times"></i></a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                
                <?php elseif($data=='pesan') :?>
                <!-- list pesan saran dan masukan -->
                <table id="example2" class="table table-stripe table-hover" >
                  <thead>
                  <tr class="text-center">
                    <th>No.</th>
                    <th>Subject</th>
                    <th>Pesan</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm-center">
                  <?php foreach($pesan as $pesan)  :?>
                  <tr>
                    <td class="font-weight-bold"><?= $no; ?></td>
                    <td ><?= $pesan['subject']; ?></td>
                    <td style="text-align: left;"><?= $pesan['pesan']; ?> <br> <br>
                      <small class="font-italic text-muted">Dikirim pada : <?= strftime("%A, %d %B %Y",$pesan['waktu_submit'])." (".date("H:i:s",$pesan['waktu_submit']); ?> WIB) </small>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                

                <?php else: ?>

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
    });
  });
</script>    
</body>
</html>