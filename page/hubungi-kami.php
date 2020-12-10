<?php 
require '../utility/function.php';
session_start();
define("root",true);

if(isset($_POST['submit'])){
    $result = insertSaranMasukan($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Online</title>
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
            <h3>Hubungi Kami</h3>
        </div>
        <div class="content">
            <div class="grid-form pcenter">
                <div>
                    <i class="fas fa-phone-alt"></i> +6281 2000 3000
                </div>
                <div>
                    <i class="fas fa-envelope"></i> i-clinic@unsoed.ac.id
                </div>
                <div>
                    <i class="fas fa-map-marker"></i> Purbalingga, Indonesia
                </div>
            </div>
            <div class="saran">
                <form action="" method="POST">
                    <h3>Saran atau Masukan</h3>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <textarea name="pesan" id="pesan" placeholder="Tulis pesan di sini" cols="30" rows="10"></textarea>
                    <input type="submit" class="submit-btn" value="Kirim" name="submit">
                </form>
            </div>
        </div>
    </div>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- alert popUp area -->
    <?php if(isset($result)):?>
          <script>
              <?php if($result==(1)) :?>
                  swal('Berhasil!', 'Pesan Berhasil Dikirimkan, Terimakasih atas saran dan masukan yang anda berikan', 'success')
                  .then((value) => {
                      window.location.href = 'hubungi-kami.php';
                  });
              <?php else :?>
                  swal('Error!', 'Pesan Gagal Dikirimkan', 'error')
                  .then((value) => {
                      window.location.href = 'hubungi-kami.php';
                  });
              <?php endif; ?>
          </script> 
    <?php endif; ?>

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
    </script>
</body>
</html>