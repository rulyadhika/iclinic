<?php 
session_start();
include "./function.php";

  //redirect handler
  if(!isset($_GET['reg'])){
    header("Location:../index.php");die;
  }else{
    if(!isset($_GET['data-id'])){
      header("location:../index.php");die;
    }else{
      //print untuk pendaftaran online
      if($_GET['reg']=='online'){
          $id_pendaftaran = $_GET['data-id'];
          $user_id = $_SESSION["user_id"];

          $data_pendaftaran = select("SELECT tb_unit.nama_unit, tb_pendaftaran_online.*,tb_akun_user.email, tb_biodata_user.* 
                              FROM tb_unit JOIN tb_jadwal ON tb_unit.id = tb_jadwal.id_unit JOIN tb_pendaftaran_online 
                              ON tb_jadwal.id = tb_pendaftaran_online.id_jadwal JOIN tb_akun_user
                              ON tb_pendaftaran_online.id_user = tb_akun_user.id JOIN tb_biodata_user 
                              ON tb_akun_user.id = tb_biodata_user.id_akun 
                              WHERE tb_pendaftaran_online.id = $id_pendaftaran AND tb_pendaftaran_online.id_user = $user_id");

          /*pengecekan apakah data tersedia atau tidak dan id pada url(id pendaftaran) 
          dan id user ada pada satu record di tabel pendaftaran */
          if($data_pendaftaran == null){
            echo "<script>alert('Maaf data tidak ditemukan');
                          window.location.href = '../index.php';
                  </script>";die;
          }else{

            //pengecekan apakah data tanggal periksa pasien >= tanggal hari ini
            if($data_pendaftaran[0]['tanggal_periksa'] >= date("Y-m-d",time())){
              $data_pendaftaran = $data_pendaftaran[0];
            }else{
              echo "<script>alert('Maaf data ini sudah tidak bisa dicetak lagi, karena telah kadaluarsa');
                          window.location.href = '../index.php';
                    </script>";die;
            }

          }
      }elseif($_GET['reg']=='offline'){
      //print untuk pendaftaran offline
        
        //pengecekan siapa yg mengakses halaman ini
        if($_SESSION['role']=='pasien'){
          header("location:../index.php");die;  
        }else{
          $id_pendaftaran = $_GET['data-id'];
          $tanggal_hari_ini = date("Y-m-d",time());
          
          $data_pendaftaran = select("SELECT tb_unit.nama_unit, tb_pendaftaran_offline.no_antrian_poli,tb_pendaftaran_offline.kd_pendaftaran,tb_pendaftaran_offline.nama
                              FROM tb_unit JOIN tb_jadwal ON tb_unit.id = tb_jadwal.id_unit JOIN tb_pendaftaran_offline 
                              ON tb_jadwal.id = tb_pendaftaran_offline.id_jadwal
                              WHERE tb_pendaftaran_offline.id = $id_pendaftaran AND tanggal_periksa = '$tanggal_hari_ini'");

          //pengecekan apakah data tersedia atau tidak
          if($data_pendaftaran == null){
            echo "<script>alert('Maaf data tidak ditemukan');
                          window.location.href = '../admin/queue.php?queue=administrasi&data=adm';
                  </script>";die;
          }else{
            $data_pendaftaran = $data_pendaftaran[0];
          }
        }
      }elseif($_GET['reg']=='adm'){
        //pengecekan siapa yg mengakses halaman ini
        if($_SESSION['role']=='dev' || $_SESSION['role']=='antrian adm'){
          $nomor_antrian = $_GET['data-id'];

          // menambahkan digit '0'
          if(strlen($nomor_antrian)==1){
            $nomor_antrian = "00".$nomor_antrian;
          }elseif(strlen($nomor_antrian)==2){
            $nomor_antrian = "0".$nomor_antrian;
          }

        }else{
          header("location:../index.php");die;  
        }
      }else{
        // jika data reg dari url bukan offline/online/administrasi
        header("location:../index.php");die;
      }

    }
  }


?>

<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
            integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
            crossorigin="anonymous" />


        <title>Surat Pendaftaran Rawat Jalan Pasien - I Clinic Unsoed</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

            body{
                font-family: 'Poppins', sans-serif
            }

            .thermal-printer-ticket{
              font-size: 12px;
              font-family: 'Times New Roman';
            }

            td.value{
                width: 70px;
                max-width: 70px;
                word-break: break-all;
            }

            td.data{
                width: 85px;
                max-width: 85px;
                font-weight: bold;
            }

            .ticket {
                width: 155px;
                max-width: 155px;
            }

            img {
                padding: 10px;
                max-width: inherit;
                width: inherit;
            }

            @media print{
                #print{
                    display: none;
                }
            }
        </style>
    </head>

    <body>
        <div id="wrapper">

            <?php if($_GET['reg']=='online'):?>
            <!-- section untuk cetak surat pendaftaran -->

              <!-- Main content -->
              <section class="invoice">
                  <!-- title row -->
                  <div class="row">
                      <div class="col-12">
                          <h2 class="page-header">
                              <i class="fas fa-globe"></i> I-Clinic Unsoed
                              <small class="float-right">Date: <?= strftime("%d/%m/%Y", time()); ?></small>
                          </h2>
                      </div>
                      <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row header-info mt-3">
                      <div class="col-12 text-center">
                          <h3>Surat Pendaftaran Rawat Jalan Pasien</h3>
                          <h5>I-Clinic Universitas Jenderal Soedirman</h5>
                          <h6>Jl. Raya Mayjen Sungkono No.KM 5, Dusun 2, Blater, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah 53371</h6>
                      </div>
                      <div class="col-12 d-flex justify-content-center">
                          <div class="mx-2">
                              <i class="fa fa-envelope"></i>
                              <span>i-clinic@unsoed.ac.id</span>
                          </div>
                          <div class="mx-2">
                              <i class="fa fa-phone"></i>
                              <span>+6281 2000 3000</span>
                          </div>
                          <div class="mx-2">
                              <i class="fa fa-map-marker"></i>
                              <span>Purbalingga, Indonesia</span>
                          </div>
                      </div>
                  </div>
                  <!-- /.row -->

                  <!-- Table row -->
                  <div class="row mt-4">
                      <div class="col-12 table-responsive">
                          <table class="table border-bottom">
                              <thead class="thead-light text-center">
                                <tr>
                                  <th scope="col" colspan="2">Data Pendaftaran</th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="font-weight-bold">
                                  <td style="width:250px;">No. Antrian Administrasi</td>
                                  <td>: <?= $data_pendaftaran['no_antrian_administrasi']; ?> 
                                </tr>
                                <tr class="font-weight-bold">
                                  <td>Poli Tujuan </td>
                                  <td>: Poli <?= $data_pendaftaran['nama_unit']; ?> </td> 
                                </tr>
                                <tr class="font-weight-bold">
                                  <td >No. Antrian Poli </td>
                                  <td>: <?= $data_pendaftaran['no_antrian_poli']; ?> </td> 
                                </tr>
                                <tr class="font-weight-bold">
                                  <td >Tanggal Periksa </td>
                                  <td>: <?= strftime("%A, %d %B %Y", strtotime($data_pendaftaran['tanggal_periksa'])); ?> </td>
                                </tr>
            
                                <thead class="thead-light text-center">
                                  <tr>
                                    <th scope="col" colspan="2">Data Pasien</th>
                                    <th scope="col"></th>
                                  </tr>
                                </thead>
            
                                <tr class="font-weight-bold">
                                  <td>Jenis Pembiayaan </td>
                                  <td class="<?= $data_pendaftaran['jenis_pembiayaan']=="BPJS"?'text-success':'text-primary'; ?>">: <?= $data_pendaftaran['jenis_pembiayaan']; ?> </td> </td>
                                </tr>
                                <?php if($data_pendaftaran['jenis_pembiayaan']=="BPJS") :?>
                                  <tr class="font-weight-bold">
                                    <td >Nomor BPJS </td>
                                    <td>: <?= $data_pendaftaran['no_bpjs']; ?> </td>
                                  </tr>
                                <?php endif; ?>
                                <tr>
                                  <td class="font-weight-bold">NIK </td>
                                  <td>: <?= $data_pendaftaran['nik']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Nama Pasien </td>
                                  <td>: <?= $data_pendaftaran['nama']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Tanggal Lahir </td>
                                  <td>: <?= strftime("%d %B %Y", strtotime($data_pendaftaran['tanggal_lahir'])); ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Jenis Kelamin </td>
                                  <td>: <?= $data_pendaftaran['jenis_kelamin']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Gol Darah </td>
                                  <td>: <?= $data_pendaftaran['gol_darah']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Alamat </td>
                                  <td>: <?= $data_pendaftaran['alamat']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">No.Hp </td>
                                  <td>: 0<?= $data_pendaftaran['no_hp']; ?> </td>
                                </tr>
                                <tr>
                                  <td class="font-weight-bold">Email </td>
                                  <td>: <?= $data_pendaftaran['email']; ?> </td>
                                </tr>
                              </tbody>
                            </table>
                      </div>
                      <!-- /.col -->
                  </div>
                  <!-- /.row -->

                  <div class="row">
                      <!-- accepted payments column -->
                      <div class="col-6">
                          <p class="lead">Syarat - syarat:</p>
                          <p  style="margin-top: 10px;" class="mb-1">
                              Silahkan bawa surat ini pada saat anda berkunjung ke klinik disertai dengan berkas - berkas lainnya untuk dilakukan verifikasi pendaftaran. Berkas - berkas yang diperlukan :
                          </p>
                          <div >
                              <p class="mb-0">
                                  Pasien Umum : 
                              </p>
                              <ul class="mb-1">
                                  <li>KTP atau KK</li>
                              </ul>
                          </div>
                          <div>
                              <p class="mb-0">
                                  Pasien BPJS : 
                              </p>
                              <ul>
                                  <li>Kartu JKN - KIS / BPJS / Askes Asli / KIS Digital</li>
                                  <li>Kartu Identitas(KK / KTP / SIM)</li>
                                  <li>Bagi pasien anak menunjukkan KK / KTP / KTP Orang tua</li>
                              </ul>
                          </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-6">
                          <p class="lead text-center">Tunjukan kode qr dibawah ini kepada petugas</p>
                          <div class="text-center mt-4" >
                              <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= $data_pendaftaran['kd_pendaftaran']; ?> </td>&color=3d3d3d" alt="">
                          </div>
                      </div>
                      <div class="col-12 mt-3 font-italic text-danger">
                          <p>*Dimohon untuk melakukan proses verifikasi pendaftaran di klinik sebelum jam 12.00 siang dihari yang sama dengan jadwal periksa anda.</p>
                      </div>
                      <!-- /.col -->
                  </div>
                  <!-- /.row -->
              </section>
              <!-- /.content -->

            <?php elseif($_GET['reg']=='offline') :?>
              <!-- section untuk cetak tiket nomor antrian poli -->

              <section class="thermal-printer-ticket">
                <div class="ticket">
                  <p class="text-center mb-0">Nomor Antrian Poli
                      <br>I-Clinic Unsoed
                  </p>
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= $data_pendaftaran['kd_pendaftaran']; ?>" alt="">
                  <p class="text-center mb-0">Tanggal : <?= strftime("%d/%m/%Y", time()); ?></p>
                  <table class="mt-2">
                    <tbody>
                        <tr>
                          <td class="data">Nomor Antrian</td>
                          <td class="value">: <?= $data_pendaftaran['no_antrian_poli']; ?></td>
                        </tr>
                        <tr>
                            <td class="data">Nama</td>
                            <td class="value">: <?= $data_pendaftaran['nama']; ?></td>
                        </tr>
                        <tr>
                            <td class="data">Poli Tujuan</td>
                            <td class="value">: <?= $data_pendaftaran['nama_unit']; ?></td>
                        </tr>
                    </tbody>
                  </table>
                  <p class="text-center mt-2">Nomor antrian berlaku sesuai dengan tanggal dikeluarkan
                </div>
              </section>

              <?php elseif($_GET['reg']=='adm') :?>
              <!-- section untuk cetak tiket nomor antrian administrasi -->

              <section class="thermal-printer-ticket">
                <div class="ticket">
                  <p class="text-center mb-0">Nomor Antrian Administrasi
                      <br>I-Clinic Unsoed
                  </p>
                  <h1 class="display-1 font-weight-bold text-center mb-0"><?= $nomor_antrian; ?></h1>
                  <p class="text-center mb-0">Tanggal : <?= strftime("%d/%m/%Y", time()); ?></p>
                  <p class="text-center mt-2 mb-0">Nomor antrian berlaku sesuai dengan tanggal dikeluarkan.</p>
                  <p class="text-center mb-2">Terimakasih atas kunjungan anda.</p>
                  <p class="text-center">Pendaftaran antrian online kunjungi : iclinicunsoed.com</p>
                </div>
              </section>

            <?php endif; ?>
        </div>
        <!-- thanks to parzibyte.me/blog -->
        <!-- ./wrapper -->

        <button id='print'>Cetak PDF</button>

        <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
        </script>


        <script type="text/javascript">
            window.onload = ()=>{
              window.print();
            }

            $('#print').click(function () {
                window.print();
            });
        </script>
    </body>


</html>