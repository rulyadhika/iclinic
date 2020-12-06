<?php 
require './utility/function.php';

    //submit handler
    if(isset($_POST['register'])){
        var_dump( insertPendaftaran($_POST));die;
    }

    if($_GET['r']=='politersedia'){
        $tanggal_dipilih =strftime("%A, %d %B %Y",$_GET['d']);
        $hari_dipilih = strftime("%A",$_GET['d']);

        $jadwals = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_unit.dokter FROM tb_jadwal JOIN tb_unit ON tb_jadwal.id_unit = tb_unit.id 
                    WHERE tb_jadwal.hari_tersedia = '$hari_dipilih'");
        $poli_tersedia = [];

        //mengambil nama2 poli
        foreach($jadwals as $jadwal){
            if(!in_array($jadwal['nama_unit'],$poli_tersedia)){
               $poli_tersedia[] = $jadwal['nama_unit'];
            }
        }
    }elseif($_GET['r']=='konfirmasi'){
        $id_jadwal = $_GET['id'];
        $data = select("SELECT tb_jadwal.*,tb_unit.nama_unit,tb_unit.dokter FROM tb_jadwal JOIN tb_unit ON tb_jadwal.id_unit = tb_unit.id 
                    WHERE tb_jadwal.id = $id_jadwal ")[0];

        $tanggal_periksa = $_GET['d'];
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <?php if($_GET['r']=='tanggalperiksa') :?>
    <h6>Silahkan pilih tanggal periksa</h6>
    <select name="tanggal_periksa" id="">
        <option value="-" hidden>--Pilih tanggal--</option>
      <?php for($i=1;$i<=3;$i++) :?>
        <option value="<?= strtotime("+". $i ."Day",time()); ?>"><?= strftime("%A, %d %B %Y",strtotime("+". $i ."Day",time())); ?></option>
      <?php endfor; ?>
    </select>
    <a href="javascript:void(0)" class="continou-btn">Lanjut</a>

    <?php elseif($_GET['r']=='politersedia') :?>
    <h6>Poli tersedia untuk <?= $tanggal_dipilih; ?> </h6>
    
    <h6>Silahkan pilih jadwal</h6>
    <ul>
        <?php foreach($poli_tersedia as $poli) :?>
            <li>
                Poli <?= $poli; ?> 
                <?php foreach($jadwals as $jadwal) :?>
                    <?php if(strpos($poli,$jadwal['nama_unit'])!==false) :?>
                        (<?= $jadwal['dokter']; ?>) <br>
                      <input type="radio" name="poli" value="<?= $jadwal['id']; ?>"> <?= date("H:i",strtotime($jadwal['waktu_praktek'])); ?> WIB <br>
                    <?php endif; ?>
                <?php endforeach; ?> 
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="javascript:void(0)" class="continou-btn">Lanjut</a>

    <?php elseif($_GET['r']=='konfirmasi') :?>
        <li>Unit = Poli <?= $data['nama_unit']; ?></li>
        <li>Tanggal Periksa = <?= strftime("%A, %d %B %Y",$tanggal_periksa); ?> </li>
        <li>Waktu Periksa = <?= date("H:i",strtotime($data['waktu_praktek'])); ?> WIB </li>
        <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
        <button class="register-btn">Daftar</button>
    <?php endif; ?>


    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
   
    <?php if($_GET['r']=='tanggalperiksa') :?>
        <script>
            window.onload = ()=>{
                $("select[name=tanggal_periksa]").val('-');
            };

            $("select[name=tanggal_periksa]").on("input",function(){
                $('.continou-btn').attr("href","register.php?r=politersedia&d="+this.value);
            });
        </script>
    <?php elseif($_GET['r']=='politersedia') :?>
        <script>
            $("input[type=radio]").on('click',(e)=>{
                $('.continou-btn').attr("href","register.php?r=konfirmasi&d="+<?= json_encode($_GET['d']); ?>+"&id="+e.target.value);
            })
        </script>
    <?php elseif($_GET['r']=='konfirmasi') :?>
        <script>
            $(".register-btn").on('click',()=>{
                $.ajax({
                url: "register.php",
                type : "POST",
                data : { 
                        register : true,
                        id : <?= json_encode($id_jadwal) ?>,
                        d : <?= json_encode($tanggal_periksa) ?>
                    }, 
                success: function(result){
                    console.log(result);
                    $('.register-btn').text("Berhasil");
                    $('.register-btn').remove();
                    window.location.href = "cek.php";
                    // if(result==1){
                    //     swal('Berhasil', 'Tiket berhasil dicheckout, tekan OK untuk melanjutkan ke proses pembayaran', 'success')
                    //     .then((value) => {
                    //         window.location.href = 'account/dashboard.php?r=cart';
                    //     });
                    // }else if(result==(-2)){
                    //     swal("Maaf!", 'Tiket untuk kursi yang anda pilih telah dipesan, silahkan pilih kembali kursi', 'error')
                    //     .then((value) => {
                    //         window.location.href = 'booking.php?id=<?= json_encode($id_jadwal) ?>';
                    //     });
                    // }else{
                    //     swal('Gagal!', 'Tiket gagal dicheckout, silahkan hubungi customer service kami', 'warning')
                    //     .then((value) => {
                    //         window.location.href = '../index.php';
                    //     });
                    // }
                }});
            });
        </script>
    <?php endif; ?>

    

  </body>
</html>