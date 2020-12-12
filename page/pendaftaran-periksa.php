<?php 
include "../utility/function.php";
session_start();
if (!isset($_SESSION['login'])){
    header("location: ../login.php");die;
}
define("root",true);

    //submit pendaftaran handler
    if(isset($_POST['daftar_periksa'])){
        $result = insertPendaftaranPeriksaOnline($_POST);
    }

    //mencari poli tersedia sesuai tanggal yg dpilih pasien via ajax
    if(isset($_POST['check'])){
        $hari_dipilih = strftime("%A",$_POST['date']);
        $poli_tersedia = select("SELECT tb_unit.nama_unit,tb_jadwal.id as id_jadwal FROM tb_unit JOIN tb_jadwal ON
                         tb_unit.id = tb_jadwal.id_unit WHERE tb_jadwal.hari_praktek = '$hari_dipilih'");
        echo json_encode($poli_tersedia);die;
    }

    //cek apakah user sudah memasukan nomor bpjs
    $id_user = $_SESSION['user_id'];
    $nomor_bpjs = select("SELECT tb_biodata_user.no_bpjs FROM tb_biodata_user JOIN tb_akun_user 
                          ON tb_biodata_user.id_akun = tb_akun_user.id WHERE tb_akun_user.id = $id_user")[0]['no_bpjs'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - I Clinic Unsoed</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php require_once '../components/nav-side-bar.php' ?>
    <div class="main">
        <div class="bar">
            <div class="bar-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h3>Ambil Antrian</h3>
        </div>
        <div class="content">
            <div class="center">
                <form action="" method="POST">
                    <div class="grid-form">
                        <div class="form-group">
                            <label for="tanggal_periksa">Tanggal Periksa</label>
                            <select name="tanggal_periksa" id="tanggal_periksa" required>
                                <option value="" hidden>--Pilih tanggal--</option>
                            <?php for($i=1;$i<= 3;$i++) :?>
                                <option value="<?= strtotime("+". $i ."Day",time()); ?>"> <?= strftime("%A, %d %B %Y",strtotime("+". $i ."Day",time())); ?> </option>
                            <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pembiayaan">Pembiayaan</label>
                            <select name="pembiayaan" id="pembiayaan" required>
                                <option hidden="" value="">--Pilih Pembiayaan--</option>
                                <option value="Umum">Umum</option>
                                <?php if($nomor_bpjs!=NULL) :?>
                                    <option value="BPJS">BPJS</option>
                                <?php else :?>
                                    <option value="" disabled>--BPJS belum ditambahkan--</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="poli">Poli Klinik</label>
                            <select name="poli" id="poli" disabled required>
                                <option value="" hidden>--Pilih Poli--</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="submit-btn" value="Ambil Antrian" name="daftar_periksa">
                </form>
            </div>
        </div>
    </div>

    
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- alert popUp area -->
    <?php if(isset($result)):?>
    <!-- popup alert untuk registrasi pendaftaran  -->
        <script>
            <?php if($result[0]>0) :?>
                swal({
                        title: "Berhasil!",
                        text: "Data Pendaftaran Berhasil Ditambahkan",
                        icon: "success",
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                        button: "Cetak Pdf",
                    })
                .then((value) => {
                    window.open("../utility/print.php?reg=online&data-id="+<?= json_encode($result[1])?>);
                })
                .then(()=>{
                    window.location.href = 'riwayat-antrian.php';
                });
            <?php else :?>
                swal('Error!', 'Data Pendaftaran Gagal Ditambahkan', 'error')
                .then((value) => {
                    window.location.href = 'pendaftaran-periksa.php';
                });
            <?php endif; ?>
        </script> 
    <?php endif; ?>
    <!-- end of alert popup area -->


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


        setInterval(()=>{
            window.location.href = "pendaftaran-periksa.php";
        },300000)
    </script>

    <script>
        $("select[name=tanggal_periksa]").on("input",function(){
            $("select[name=poli]").html(`
                <option value="" hidden>--Pilih Poli--</option>
            `);
            $.ajax({
                url: "pendaftaran-periksa.php",
                type : "POST",
                data : { 
                        check : true,
                        date : this.value,
                    }, 
                dataType : 'JSON',
                success: function(result){
                    $("select[name=poli]").prop("disabled", false);
                    if(result.length>0){
                        result.forEach(result=>{
                            $("select[name=poli]").append(`
                                <option value="${result.id_jadwal}">${result.nama_unit}</option>
                            `);
                        })
                    }else{
                        $("select[name=poli]").append(`
                            <option value="" disabled>Tidak ada jadwal poli yang tersedia</option>
                        `);
                    }
                }});
        })
    </script>
</body>
</html>