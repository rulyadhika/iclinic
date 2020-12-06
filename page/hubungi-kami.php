<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Online</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/fontawesome-free-5.15.1-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <nav>
        <div class="logo">
            <h1>i-Clinic</h1>
        </div>
        <div class="user">
            <i class="fas fa-user-circle"></i>
            Hallo, Febri!
        </div>
    </nav>
    <ul class="sidebar">
        <div class="close-icon">
            <i class="fas fa-times"></i>
        </div>
        <li><a href="cpanel.html"><i class="fas fa-home"></i>Beranda</a></li>
        <li><a href="ubah_profil.html"><i class="fas fa-user"></i>Ubah Profil</a></li>
        <li><a href="ubah_password.html"><i class="fas fa-lock"></i>Ubah Password</a></li>
        <li><a href="riwayat_antrian.html"><i class="fas fa-history"></i>Riwayat Antrian</a></li>
        <li><a href="hubungi_kami.html"><i class="fas fa-phone-alt"></i>Hubungi Kami</a></li>
        <li><a href="login.html"><i class="fas fa-sign-out-alt"></i>Keluar</a></li>
    </ul>
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
                <form action="" method="post">
                    <h3>Saran atau Masukan</h3>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <textarea name="pesan" id="pesan" placeholder="Tulis di sini" cols="30" rows="10"></textarea>
                    <input type="submit" class="submit-btn" value="Kirim">
                </form>
            </div>
        </div>
    </div>
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