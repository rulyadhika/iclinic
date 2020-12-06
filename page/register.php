<?php 
require '../utility/function.php';

if(isset($_POST['register'])){
    $result = registerAkun($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../src/css/style.css">
</head>
<body>
    <nav class="login">
        <div class="logo">
            <h1>i-Clinic</h1>
        </div>
        <div class="tanya">
            <span>Sudah Punya Akun?</span>
            <a href="login.php"><span>Login Sekarang</span></a>
        </div>
    </nav>
    <div class="container">
        <div class="banner"></div>
        <div class="main-form">
            <h2>Daftar Reservasi Online</h2>
            <form action="" method="POST">
                <div class="grid-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Masukan Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Masukan Password" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_pasien">Nama Lengkap</label>
                        <input type="text" name="nama_pasien" placeholder="Masukan Nama Lengkap" required >
                    </div>
                    <div class="form-group">
                        <label for="nik_pasien">No. KTP / NIK</label>
                        <input type="number" name="nik_pasien" placeholder="Masukan NIK" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_bpjs">No. BPJS (Bila Ada)</label>
                        <input type="number" name="nomor_bpjs" placeholder="Kosongkan Bila Tidak Ada">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required>
                            <option hidden="" value="">--Pilih Jenis Kelamin--</option>
                            <option value="Laki - laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required>
                    </div>
                    
                    <div class="form_group">
                        <label for="gol_darah">Golongan Darah</label>
                        <select name="gol_darah" id="gol_darah" required>
                            <option hidden="" value="">--Pilih Golongan Darah --</option>
                            <option value="belum_tahu">Belum tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Rumah</label>
                        <input type="text" class="lebar"name="alamat" placeholder="Masukan Alamat Rumah" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="number" name="no_hp" placeholder="Masukan Nomor Hp" required >
                    </div>
                </div>
                <input type="submit" class="submit-btn" value="Daftar" name="register">
            </form>
        </div>
    </div>


<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- alert popUp area -->
<?php if(isset($result)):?>
<script>
    <?php if($result==(1)) :?>
        swal('Berhasil!', 'Akun berhasil dibuat! Klik ok untuk login', 'success')
        .then((value) => {
            window.location.href = 'login.php';
        });
    <?php elseif($result=='email sudah pernah didaftarkan') :?>
        swal('Gagal!', 'Email sudah pernah didaftarkan! Silahkan gunakan alamat email lain', 'error')
        .then((value) => {
            window.location.href = 'register.php';
        });
    <?php elseif($result=='password minimal 8 karakter') :?>
        swal('Perhatian!', 'Password minimal 8 karakter!', 'warning')
        .then((value) => {
            window.location.href = 'register.php';
        });
    <?php endif; ?>
</script> 
<?php endif; ?>
<!-- end of alert popup area -->
    
</body>
</html>