<?php 
session_start();
include "../utility/function.php";
define("root",true);

if (!isset($_SESSION['login'])){
    header("location: ../login.php");die;
}

if(isset($_POST['ganti'])){
    $result = ubahPassword($_POST);
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - I Clinic Unsoed</title>
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        .form-group{
            position: relative;
        }

        .lihat{
            position: absolute;
            top: 50%;
            right: 4%;
            transform: translate(-4%,-50%);
            color: rgba(189, 195, 199,0.5);
        }

        .lihat:hover{
            cursor: pointer;
            color: rgba(189, 195, 199,1);
        }
        
    </style>
</head>
<body>
<?php require_once '../components/nav-side-bar.php' ?>
    <div class="main">
        <div class="bar">
            <div class="bar-icon">
                <i class="fas fa-bars"></i>
            </div>
            <h3>Ubah Password</h3>
        </div>
        <div class="content">
            <div class="center">
                <form action="" method="POST">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <div class="grid-form">
                        <div class="form-group">
                            <label for="password">Password Lama</label>
                            <div class="form-group">
                                <input type="password" name="password_lama" placeholder="Masukan password lama" required>
                                <i class="fa fa-eye-slash lihat"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <div class="form-group">
                                <input type="password" name="password_1" placeholder="Masukan password baru" required>
                                <i class="fa fa-eye-slash lihat"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"> Ulangi Password Baru</label>
                            <input type="password" name="password_2" placeholder="Masukan ulang password baru" required>
                        </div>
                    </div>
                    <input type="submit" class="submit-btn" value="Ganti" name="ganti">
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- alert popUp area -->
    <?php if(isset($result)):?>
          <script>
            <?php if($result==(1)) :?>
                swal('Berhasil!', 'Password berhasil diubah! Silahkan log in kembali untuk melanjutkan', 'success')
                .then((value) => {
                    window.location.href = '../logout.php';
                });
            <?php elseif($result=='password tidak sama') :?>
                swal('Gagal!', 'Password yang anda masukan tidak sama, silahkan cek kembali!', 'error')
                .then((value) => {
                    window.location.href = './ubah-password.php';
                });
            <?php elseif($result=='password lama salah') :?>
                swal('Gagal!', 'Password yang anda masukan salah, silahkan cek kembali!', 'error')
                .then((value) => {
                    window.location.href = './ubah-password.php';
                });
            <?php elseif($result=='password minimal 8 karakter') :?>
                swal('Perhatian!', 'Password minimal 8 karakter!', 'warning')
                .then((value) => {
                    window.location.href = './ubah-password.php';
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

        $(".lihat").on("click",function(e){
            let elem = e.target.previousElementSibling;
            if(elem.getAttribute("type")=="password"){
                e.target.classList.remove("fa-eye-slash");
                e.target.classList.add("fa-eye");
                elem.setAttribute("type","text");
            }else{
                e.target.classList.remove("fa-eye");
                e.target.classList.add("fa-eye-slash");
                elem.setAttribute("type","password");
            }
        });
    </script>
</body>
</html>