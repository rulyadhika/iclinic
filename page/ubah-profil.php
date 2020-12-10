<?php 
session_start();
include "../utility/function.php";

define("root",true);
if (!isset($_SESSION['login'])){
    header("location: ../login.php");die;
}

if(isset($_POST['simpan'])){
    $result = updateDataUser($_POST);
}

$id_user = $_SESSION['user_id'];

$data_user = select("SELECT tb_biodata_user.*,tb_akun_user.email FROM tb_biodata_user JOIN tb_akun_user ON
                    tb_biodata_user.id_akun = tb_akun_user.id WHERE tb_akun_user.id = $id_user")[0];

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
            <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?= $id_user; ?>">
                <div class="grid-form">
                    <div class="form-group">
                        <label for="nama_pasien">Nama Lengkap</label>
                        <input type="text" name="nama_pasien" value="<?= $data_user['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nik_nama_pasien">No. KTP / NIK</label>
                        <input type="number" name="nik_pasien" value="<?= $data_user['nik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_bpjs">No. BPJS (Bila Punya)</label>
                        <input type="number" name="nomor_bpjs" value="<?= $data_user['no_bpjs']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required>
                            <option hidden="" value="">--Pilih Jenis Kelamin--</option>
                            <option value="Laki - laki" <?= $data_user['jenis_kelamin']=="Laki - laki"?'selected':''; ?> >Laki-laki</option>
                            <option value="Perempuan" <?= $data_user['jenis_kelamin']=="Perempuan"?'selected':''; ?> >Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="<?= $data_user['tanggal_lahir']; ?>" required>
                    </div>
                    
                    <div class="form_group">
                        <label for="gol_darah">Golongan Darah</label>
                        <select name="gol_darah" id="gol_darah" required>
                            <option value="Belum Tahu" <?= $data_user['gol_darah']=="Belum Tahu"?'selected':''; ?>>Belum tau</option>
                            <option value="A" <?= $data_user['gol_darah']=="A"?'selected':''; ?> >A</option>
                            <option value="B" <?= $data_user['gol_darah']=="B"?'selected':''; ?> >B</option>
                            <option value="AB" <?= $data_user['gol_darah']=="AB"?'selected':''; ?> >AB</option>
                            <option value="O" <?= $data_user['gol_darah']=="O"?'selected':''; ?> >O</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Rumah</label>
                        <input type="text" class="lebar"name="alamat" value="<?= $data_user['alamat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="number" name="no_hp" value="0<?= $data_user['no_hp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?= $data_user['email']; ?>" disabled>
                    </div>
                </div>
                <input type="submit" class="submit-btn" value="Simpan" name="simpan">
            </form>
        </div>
    </div>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- alert popUp area -->
    <?php if(isset($result)):?>
          <script>
              <?php if($result==(1)) :?>
                  swal('Berhasil!', 'Data Berhasil Diubah', 'success')
                  .then((value) => {
                      window.location.href = 'ubah-profil.php';
                  });
              <?php else :?>
                  swal('Error!', 'Data Gagal Diubah', 'error')
                  .then((value) => {
                      window.location.href = 'ubah-profil.php';
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