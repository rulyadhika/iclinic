<?php 
session_start();

// redirect handler
if(isset($_SESSION['login'])){
  header("Location:./index.php");die;
}

require './utility/function.php';

if(isset($_POST['login'])){
    $result = login($_POST);
    if($result!='pasien' && $result!=false){
        header("location:./admin/dashboard.php");die;
    }elseif($result=='pasien'){
        header("location:./index.php");die;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - I Clinic Unsoed</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <nav class="login">
        <div class="logo">
            <a href="./index.php"><h1>i-Clinic</h1></a>
        </div>
        <div class="tanya">
            <span>Belum Punya Akun?</span>
            <a href="register.php"><span>Daftar Sekarang</span></a>
        </div>
    </nav>
    <div class="container">
        <div class="banner"></div>
        <div class="main-form login">
            <h2>Login Reservasi Online</h2>
            <form action="" method="POST">
                <div class="grid-form">
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" placeholder="Masukkan Email Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                    </div>
                </div>
                <input type="submit" class="submit-btn" value="Login" name="login">
                <a href="cpanel.html">Lupa Password?</a>
            </form>
        </div>
    </div>
</body>

<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- alert popUp area -->
<?php if(isset($result)):?>
<script>
    <?php if($result==false) :?>
        swal('Gagal!', 'Email / Password salah! Silahkan periksa kembali', 'error')
        .then((value) => {
            window.location.href = './login.php';
        });
    <?php endif; ?>
</script> 
<?php endif; ?>
<!-- end of alert popup area -->
    
</html>