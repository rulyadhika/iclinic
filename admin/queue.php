<?php 

require '../utility/function.php';

  //  handler tombol antrian berikutnya
  if(isset($_POST['next'])){
    echo updateCounterUnit($_POST);die;
  }elseif(isset($_POST['cek'])){
    //handler tombol cek data pasien
    $qr_code = $_POST['qr_code'];
    $data_pasien = select("SELECT * FROM tb_pendaftaran WHERE kd_pendaftaran = '$qr_code'");
    if(count($data_pasien)>0){
      echo json_encode($data_pasien[0]);die;
    }else{
      echo json_encode(['error'=>true]);die;
    }
  }

$queue = $_GET['queue'];
$data = $_GET['data'];
$no = 1;

    if($queue == 'poli'){
        $id_unit = $_GET['id'];
        $nomor_antrian_terakhir = select("SELECT nomor_antrian FROM tb_counter WHERE id_unit = $id_unit")[0]['nomor_antrian'];
    }else{
        //untuk keperluan antrian
        $id_unit = 1;
        $nomor_antrian_terakhir = select("SELECT nomor_antrian FROM tb_counter WHERE id_unit = 1")[0]['nomor_antrian'];

        //untuk keperluan registrasi offline
        $hari_ini = strftime("%A",time());
        $poli_tersedia_hari_ini = select("SELECT tb_jadwal.id as id_jadwal,tb_jadwal.waktu_praktek,tb_unit.nama_unit,tb_biodata_user.nama as nama_dokter
                                  FROM tb_jadwal JOIN tb_unit ON tb_jadwal.id_unit = tb_unit.id JOIN tb_akun_user ON tb_unit.id_akun_dokter = tb_akun_user.id 
                                  JOIN tb_biodata_user ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_jadwal.hari_praktek = '$hari_ini' 
                                  AND tb_jadwal.status_jadwal = 'Aktif'");
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
            <h1 class="m-0 text-dark" style="text-transform: capitalize;"><?= $queue=='poli'? 'Poli '.$data :'Administrasi' ?> Loket 1</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <?php if($queue=='poli') :?>
                <li class="breadcrumb-item active" style="text-transform: capitalize;" >Antrian Poli <?= $data; ?></li>
              <?php else :?>
                <li class="breadcrumb-item active">Antrian Administrasi</li>
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
          <div class="col-md-8">
            <div class="card ">
              <div class="card-header">
                <div class="d-flex justify-content-between ">
                  <h5 class="my-auto"><?= $queue=='poli'?'Cek Kode Pendaftaran':'Verifikasi Pendaftaran'; ?></h5>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-qrcode"></i></span>
                      </div>
                      <input type="text" class="form-control mr-1" name="kd_pendaftaran_input" placeholder="Masukan Kode Pendaftaran">
                      <button class="btn btn-info cek-btn">Cek</button>
                  </div>
                </div>

                <div class="table-data-pasien">
                  
                </div>

              </div>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="card ">
              <div class="card-header">
                <div class="d-flex justify-content-between ">
                  <h5 class="my-auto" >Nomor Urut</h5>
                </div>
              </div>
              <div class="card-body text-center">
                  <h1 class="font-weight-bold counter-display" style="font-size: 10rem;margin-top:-30px;"><?= $nomor_antrian_terakhir; ?></h1>
                    <button class="btn btn-info w-100 next-btn"><i class="fa fa-bullhorn mr-2"></i> Antrian Berikutnya</button>
              </div>
            </div> 
            <div class="card ">
              <div class="card-header">
                <div class="d-flex justify-content-between ">
                  <h5 class="my-auto" >Info Antrian Hari Ini</h5>
                </div>
              </div>
              <div class="card-body">
                <div class="info-box">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clinic-medical"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pasien BPJS</span>
                    <span class="info-box-number">
                      10
                      <small>Pasien</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>

                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clinic-medical"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pasien Umum</span>
                    <span class="info-box-number">
                      10
                      <small>Pasien</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
            </div> 
          </div>

          <?php if($queue == 'administrasi' ) :?>
          <div class="col-12">
            <div class="card ">
              <div class="card-header">
                <div class="d-flex justify-content-between ">
                  <h5 class="my-auto">Tambah Pendaftaran Offline</h5>
                </div>
              </div>
              <div class="card-body"> 
                <form action="" method="POST">
                  <input type="text" name="tipe_pendaftaran" value="offline">
                  <div class="form-group row">
                    <label for="nomor_bpjs" class="col-sm-2 col-form-label">Nomor BPJS</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nomor_bpjs" name="nomor_bpjs" placeholder="Masukan Nomor BPJS ( jika pasien umum silahkan isi dengan '-' tanpa tanda petik )" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nik_pasien" class="col-sm-2 col-form-label">NIK Pasien</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nik_pasien" name="nik_pasien" placeholder="Masukan NIK Pasien" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Pasien</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Masukan Nama Pasien" required>
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
                          <input class="form-check-input" type="radio" name="jenis_kelamin" id="pria" value="pria" required>
                          <label class="form-check-label" for="pria">Pria</label>
                        </div>
                        <div class="form-check my-auto mx-2">
                          <input class="form-check-input" type="radio" name="jenis_kelamin" id="wanita" value="wanita">
                          <label class="form-check-label" for="wanita">Wanita</label>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gol_darah" class="col-sm-2 col-form-label">Gol. Darah</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <select class="form-control" id="gol_darah" name="gol_darah" required>
                          <option hidden="" value="">-- Pilih Golongan Darah --</option>
                          <option value=="Tidak Tau">Tidak Tau</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="AB">AB</option>
                          <option value="O">O</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat Pasien</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Pasien" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="id_jadwal" class="col-sm-2 col-form-label">Poli Tujuan</label>
                    <div class="col-sm-10 d-flex flex-row">
                        <?php foreach($poli_tersedia_hari_ini as $poli) :?>
                          <div class="form-check my-auto mr-3">
                            <input class="form-check-input" type="radio" name="id_jadwal" id="<?= $poli['nama_unit']; ?>" value="<?= $poli['id_jadwal']; ?>" required>
                            <label class="form-check-label" for="<?= $poli['nama_unit']; ?>">
                              Poli <?= $poli['nama_unit']; ?> (<?= $poli['nama_dokter']; ?>) <br/> 
                              <?= date("H:i", strtotime($poli['waktu_praktek']));  ?> WIB
                            </label> 
                          </div>
                        <?php endforeach; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-info" type="submit">Tambah Pendaftaran</button>
                  </div>
                </form>
              </div>
            </div> 
          </div>

          <?php endif ;?>

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

<script>
    const sound_in = new Audio('../src/audio/antrian/in.wav');
    const sound_out = new Audio('../src/audio/antrian/out.wav');
    const nomor_urut = new Audio('../src/audio/antrian/nomor-urut.wav');
    const satu = new Audio('../src/audio/antrian/1.wav');
    const dua = new Audio('../src/audio/antrian/2.wav');
    const tiga = new Audio('../src/audio/antrian/3.wav');
    const empat = new Audio('../src/audio/antrian/4.wav');
    const lima = new Audio('../src/audio/antrian/5.wav');
    const enam = new Audio('../src/audio/antrian/6.wav');
    const tujuh = new Audio('../src/audio/antrian/7.wav');
    const delapan = new Audio('../src/audio/antrian/8.wav');
    const sembilan = new Audio('../src/audio/antrian/9.wav');
    const sepuluh = new Audio('../src/audio/antrian/sepuluh.wav');
    const sebelas = new Audio('../src/audio/antrian/sebelas.wav');
    const belas = new Audio('../src/audio/antrian/belas.wav');
    const puluh = new Audio('../src/audio/antrian/puluh.wav');
    const loket = new Audio('../src/audio/antrian/loket.wav');

    const angka = ["",satu,dua,tiga,empat,lima,enam,tujuh,delapan,sembilan,sepuluh,sebelas];

    let count;
    let no_loket = <?= $queue=='poli'?'1':'2'; ?>; //session no loket login user 
    
    $(".next-btn").on("click",()=>{
        // next-btn handler
        $.ajax({
        url: "queue.php",
        type : "POST",
        data : { 
                next : true,
                id : <?= json_encode($id_unit) ?>,
                loket : no_loket
            }, 
        success: function(result){
            count = result;

            $(".counter-display").text(count);
            if(count<12){
                satuan(count);
            }else if(count>=12 && count <20){
                belasan(count);
            }else if(count>=20){
                puluhan(count);
            }
        }});
    });

    let satuan = (count)=>{
        sound_in.play();
        setTimeout(()=>{nomor_urut.play()},4000);
        setTimeout(()=>{angka[count].play()},5500);
        setTimeout(()=>{loket.play()},6500);
        setTimeout(()=>{angka[no_loket].play()},7500);
        setTimeout(()=>{sound_out.play()},9000);
    }

    let belasan = (count)=>{
        count = count%10;
        sound_in.play();
        setTimeout(()=>{nomor_urut.play()},4000);
        setTimeout(()=>{angka[count].play()},5500);
        setTimeout(()=>{belas.play()},6500);
        setTimeout(()=>{loket.play()},7500);
        setTimeout(()=>{angka[no_loket].play()},8500);
        setTimeout(()=>{sound_out.play()},10000);
    }

    let puluhan = (count)=>{
        let angkaPertamaDariKanan =  Math.floor(( count / 1) % 10);
        let angkaKeduaDariKanan = Math.floor((count/10)%10);
        
        let tambahanWaktu = 0;

        sound_in.play();
        setTimeout(()=>{nomor_urut.play()},4000);
        setTimeout(()=>{angka[angkaKeduaDariKanan].play()},5500);
        setTimeout(()=>{puluh.play()},6500);
        if(angkaPertamaDariKanan!=0){
            setTimeout(()=>{angka[angkaPertamaDariKanan].play()},7500);
            tambahanWaktu = 1000;
        }
        setTimeout(()=>{loket.play()},7500+tambahanWaktu);
        setTimeout(()=>{angka[no_loket].play()},8500+tambahanWaktu);
        setTimeout(()=>{sound_out.play()},10000+tambahanWaktu);
    }
    
</script>

<script>
  $(".cek-btn").on("click",()=>{
    let code = $("input[name=kd_pendaftaran_input]").val();
    let data_pasien;
    
    //fetching data user berdasar qr code
    $.ajax({
      url: "queue.php",
      type : "POST",
      data : { 
              cek : true,
              qr_code : code
          }, 
      dataType: "json",
      success: function(result){
          data_pasien = result;
          console.log(data_pasien);

          if(data_pasien.hasOwnProperty('error')){
            $(".table-data-pasien").html(
              `<div>
                <span class="text-center d-block font-italic">Data pasien tidak terdaftar</span>
               </div>`
            );
          }else{
            $(".table-data-pasien").html(
              `
                <table class="table border-bottom">
                  <thead class="thead-light text-center">
                    <tr>
                      <th scope="col" colspan="2">Data Pendaftaran</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="font-weight-bold">
                      <td style="width:200px;">No. Antrian </td>
                      <td>: ${data_pasien.no_antrian_administrasi} </td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td>Poli Tujuan </td>
                      <td>: </td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td >Tanggal Periksa </td>
                      <td>: ${new Date(data_pasien.tanggal_periksa).toLocaleDateString("id",{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })} </td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td>Verifikasi Administrasi </td>
                      <td>: <span class="text-${data_pasien.verifikasi_administrasi=='Belum Verifikasi'?'danger':'success'}"> ${data_pasien.verifikasi_administrasi} </span></td>
                    </tr>

                    <thead class="thead-light text-center">
                      <tr>
                        <th scope="col" colspan="2">Data Pasien</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>

                    <tr class="font-weight-bold">
                      <td>Penjamin Pasien </td>
                      <td class="text-success">: BPJS </td>
                    </tr>
                    <tr class="font-weight-bold">
                      <td >Nomor BPJS </td>
                      <td>: 0123412312312 </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">NIK </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Nama Pasien </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">TTL </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Jenis Kelamin </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Agama </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Gol Darah </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">No.Hp </td>
                      <td>: </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Email </td>
                      <td>: </td>
                    </tr>
                  </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                  <button class="btn btn-info" ${data_pasien.verifikasi_administrasi=='Belum Verifikasi'?'':'disabled'}>Verifikasi Pasien</button>
                </div>
              `
            );

          }

    }});

  })
</script>

</body>
</html>