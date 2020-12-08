<?php 
session_start();
define("root",true);
if (!isset($_SESSION['login'])){
    header("location: ../login.php");
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
            <h3>Ubah Profil</h3>
        </div>
        <div class="content">
            <div class="grid-form">
                <div class="form-group">
                    <label for="nama_pasien">Nama Lengkap</label>
                    <input type="text" name="nama_pasien" required>
                </div>
                <div class="form-group">
                    <label for="nik_nama_pasien">No. KTP / NIK</label>
                    <input type="text" name="nik_nama_pasien">
                </div>
                <div class="form-group">
                    <label for="nomor_bpjs">No. BPJS (Bila Punya)</label>
                    <input type="text" name="nomor_bpjs">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required>
                        <option hidden="" value="">--Pilih Jenis Kelamin--</option>
                        <option value="pria">Laki-laki</option>
                        <option value="wanita">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required>
                </div>
                
                <div class="form_group">
                    <label for="gol_darah">Golongan Darah</label>
                    <select name="gol_darah" id="gol_darah" required>
                        <option value="belum_tahu">Belum tahu</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Rumah</label>
                    <input type="text" class="lebar"name="alamat" required>
                </div>
                <div class="form-group">
                    <label for="no_hp">Nomor HP</label>
                    <input type="text" name="no_hp">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
            </div>
            <input type="submit" class="submit-btn" value="Simpan">
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