<?php 
$conn = mysqli_connect("localhost","root","","si_klinik");

date_default_timezone_set('Asia/Jakarta');
$localtime_assoc = localtime(time(), true);
setlocale(LC_ALL, 'id-ID', 'id_ID');

    function select($query){
        global $conn;

        $result = mysqli_query($conn,$query);

        $rows = [];

        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }

        return $rows;
    }

    function login($data){
        global $conn;

        $email = $data['email'];
        $password = $data['password'];

        $result = mysqli_query($conn,"SELECT * FROM tb_akun_user WHERE email = '$email'");

        if(mysqli_num_rows($result)>0){
           $row = mysqli_fetch_assoc($result);

           if(password_verify($password,$row['password'])){
                $user_id = $row["id"];
                $user_name = select("SELECT tb_biodata_user.nama FROM tb_akun_user JOIN tb_biodata_user 
                                        ON tb_akun_user.id = tb_biodata_user.id_akun WHERE tb_akun_user.id = $user_id")[0]['nama'];
                $user_name = explode(" ", $user_name);

                if(count($user_name)>0){
                    $user_name = $user_name[0]." ".$user_name[1];
                }else{
                    $user_name = $user_name[0];
                }

                $_SESSION['user_name'] = $user_name;
                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["role"] = $row["user_role"];
                return $row["user_role"];
            }
           
        }

        return false;
    }

    function registerAkun($data){
        global $conn;

        $email = $data['email'];
        $password = $data['password'];
        $user_role = 'pasien';

        //memastikan jika register akun via dashboard admin
        if(isset($_SESSION['login'])){
            if($_SESSION['role']=='kepala klinik' || $_SESSION['role']=='dev'){
                $user_role = $data['role'];
            }
        }

        //cek apakah email sudah pernah terdaftar atau belum
        $result = mysqli_query($conn,"SELECT id FROM tb_akun_user WHERE email = '$email'");

        if(mysqli_num_rows($result)>0){
            return 'email sudah pernah didaftarkan';
        }

        if(strlen($password)<8){
            return 'password minimal 8 karakter';
        }

        $password = password_hash($password,PASSWORD_DEFAULT);

        $query = "INSERT INTO tb_akun_user VALUES(
            '',
            '$email',
            '$password',
            '$user_role'
        )";

        if(mysqli_query($conn, $query)){
            $id_akun = mysqli_insert_id($conn);
            return insertBiodataUser($data,$id_akun);
        }else{
            return "error";
        }

    }

    function insertBiodataUser($data,$id_akun){
        global $conn;

        $nama = $data['nama_pasien'];
        $nik = $data['nik_pasien'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $gol_darah = $data['gol_darah'];
        $no_hp = $data['no_hp'];
        $alamat = $data['alamat'];
        $no_bpjs = $data['nomor_bpjs'];

        //jika pasien tidak memiliki nomor bpjs
        if(strlen($no_bpjs)==0){
            $no_bpjs = "NULL";
        }

        $query = "INSERT INTO tb_biodata_user VALUES(
            '',
            $id_akun,
            '$nama',
            $nik,
            '$jenis_kelamin',
            '$tanggal_lahir',
            '$gol_darah',
            $no_hp,
            '$alamat',
            $no_bpjs
        )";

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function updateDataUser($data){
        global $conn;

        $nama = $data['nama_pasien'];
        $nik = $data['nik_pasien'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $gol_darah = $data['gol_darah'];
        $no_hp = $data['no_hp'];
        $alamat = $data['alamat'];
        $no_bpjs = $data['nomor_bpjs'];
        $id_user = $data['user_id'];

        //jika tidak memiliki nomor bpjs
        if(strlen($no_bpjs)==0){
            $no_bpjs = "NULL";
        }

        $query = "UPDATE tb_biodata_user SET nama = '$nama', nik = $nik , jenis_kelamin = '$jenis_kelamin' , 
            tanggal_lahir = '$tanggal_lahir', gol_darah = '$gol_darah', no_hp = $no_hp , alamat = '$alamat',
            no_bpjs = $no_bpjs WHERE id_akun = $id_user
        ";

        if(mysqli_query($conn,$query)){
            //update role
            //memastikan jika register akun via dashboard admin
            if($_SESSION['role']=='kepala klinik' || $_SESSION['role']=='dev'){
                $user_role = $data['role'];

                mysqli_query($conn,"UPDATE tb_akun_user SET user_role = '$user_role' WHERE id = $id_user");

                if(!mysqli_affected_rows($conn)>0){
                    return 1;
                }
            }

            return mysqli_affected_rows($conn);
        }else{
            return -1;
        }
    }

    function insertPendaftaranPeriksaOffline($data){
        global $conn;

        $no_bpjs = $data['nomor_bpjs'];
        $nik_pasien = $data['nik_pasien'];
        $nama_pasien = $data['nama_pasien'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $gol_darah = $data['gol_darah'];
        $alamat = $data['alamat'];

        //jika pasien tidak memiliki nomor bpjs
        if(strlen($no_bpjs)==0){
            $no_bpjs = "NULL";
        }

        $id_jadwal = $data["id_jadwal"];
        $kd_pendaftaran = uniqid('',true);
        $tanggal_periksa = date("Y-m-d",time());
        $verifikasi_pendaftaran = "Terverifikasi";

        $no_antrian_poli = insertAntrianPoli($tanggal_periksa,$id_jadwal);

        $query = "INSERT INTO tb_pendaftaran_offline VALUES(
            '',
            $id_jadwal,
            $no_antrian_poli,
            '$tanggal_periksa',
            $nik_pasien,
            '$nama_pasien',
            '$tanggal_lahir',
            '$jenis_kelamin',
            '$gol_darah',
            '$alamat',
            $no_bpjs,
            '$kd_pendaftaran',
            '$verifikasi_pendaftaran'
        )";

        if(mysqli_query($conn,$query)){
            $last_id = mysqli_insert_id($conn);
            return [mysqli_affected_rows($conn),$last_id];
        }else{
            return [-1,null];
        }

    }
        

    function insertPendaftaranPeriksaOnline($data){
        global $conn;

        $id_jadwal = $data["poli"];
        $kd_pendaftaran = uniqid('',true);
        $id_user = $_SESSION['user_id']; 
        $tanggal_periksa = date("Y-m-d",$data['tanggal_periksa']);
        $jenis_pembiayaan = $data['pembiayaan'];
        $verifikasi_pendaftaran = "Belum Verifikasi";
        
        $no_antrian_administrasi = insertAntrianAdministrasi($tanggal_periksa);
        $no_antrian_poli = insertAntrianPoli($tanggal_periksa,$id_jadwal);

        $query = "INSERT INTO tb_pendaftaran_online VALUES(
            '',
            $id_user,
            $id_jadwal,
            $no_antrian_administrasi,
            $no_antrian_poli,
            '$tanggal_periksa',
            '$kd_pendaftaran',
            '$jenis_pembiayaan',
            '$verifikasi_pendaftaran'
        )";

        if(mysqli_query($conn,$query)){
            $last_id = mysqli_insert_id($conn);
            return [mysqli_affected_rows($conn),$last_id];
        }else{
            return [-1,null];
        }


    }

    function sanitize_input($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function insertAntrianAdministrasi($tanggal_periksa){
        global $conn;

        // mencari id antrian terakhir untuk tanggal tertentu pada tabel antrian administrasi
        $id_antrian_terakhir_adm = select("SELECT id FROM tb_antrian_administrasi
        WHERE tanggal_antrian = '$tanggal_periksa'
        ORDER BY id DESC LIMIT 1");

        if(count($id_antrian_terakhir_adm)==0){
            $id_antrian_terakhir_adm = 0;
        }else{
            $id_antrian_terakhir_adm = $id_antrian_terakhir_adm[0]['id'];
        }

        $id_antrian_terakhir_adm_plus_one =  $id_antrian_terakhir_adm + 1;

        $query = "INSERT INTO tb_antrian_administrasi VALUES(
            $id_antrian_terakhir_adm_plus_one,
            '$tanggal_periksa'
        )";

        mysqli_query($conn,$query);

        
        return $id_antrian_terakhir_adm_plus_one;

    }

    function insertAntrianPoli($tanggal_periksa,$id_jadwal){
        global $conn;
    

         // mencari id antrian terakhir untuk tanggal tertentu pada tabel antrian poli
         $id_antrian_terakhir_poli = select("SELECT id FROM tb_antrian_poli WHERE id_jadwal = $id_jadwal AND 
         tanggal_antrian = '$tanggal_periksa' ORDER BY id DESC LIMIT 1");

        if(count($id_antrian_terakhir_poli)==0){
            $id_antrian_terakhir_poli = 0;
        }else{
            $id_antrian_terakhir_poli = $id_antrian_terakhir_poli[0]['id'];
        }

        $id_antrian_terakhir_poli_plus_one =  $id_antrian_terakhir_poli + 1;

        $query = "INSERT INTO tb_antrian_poli VALUES(
            $id_antrian_terakhir_poli_plus_one,
            $id_jadwal,
            '$tanggal_periksa'
        )";

        mysqli_query($conn,$query);
        
        return $id_antrian_terakhir_poli_plus_one;

    }

    function updateCounterUnit($data){
        global $conn;

        $id_unit = $data['id'];
        $no_loket = $data['loket'];
        $date_now = date("Y-m-d",time());

        $data_terakhir = select("SELECT nomor_antrian,tanggal_pengoperasian FROM tb_counter WHERE id_unit = $id_unit")[0];
        $nomor_antrian_terakhir= (int) $data_terakhir['nomor_antrian'];
        $tanggal_pengoperasian = $data_terakhir['tanggal_pengoperasian'];

        //auto update nomor antrian ke -0 ketika ganti hari
        if($date_now != $tanggal_pengoperasian){
            $nomor_antrian_terakhir = 0;
        }
        $nomor_antrian_terakhir++;
        
        $query = "UPDATE tb_counter SET nomor_antrian = $nomor_antrian_terakhir , no_loket = $no_loket, tanggal_pengoperasian = '$date_now' WHERE id_unit = $id_unit";

        mysqli_query($conn,$query);

        return $nomor_antrian_terakhir;
    }

    function insertLoketAdministrasi($data){
        global $conn;

        $no_loket = $data['no_loket'];
        $id_assigned_akun = $data['assign_akun'];

        $query = "INSERT INTO tb_loket_administrasi VALUES(
            '',
            $no_loket,
            $id_assigned_akun
        )";

        //cek apakah nomor loket sudah pernah didaftarakan atau belum
        $cek_no_loket = select("SELECT id FROM tb_loket_administrasi WHERE no_loket = $no_loket");

        if(count($cek_no_loket) == 0){
            mysqli_query($conn,$query);
        }else{
            return "nomor loket sudah pernah ditambahkan";
        }

        return mysqli_affected_rows($conn);
    }

    function insertPoliKlinik($data){
        global $conn;

        $nama_poli = $data['nama_poli'];
        $id_akun_dokter = $data['dokter'];
        $max_kuota = $data['max_kuota'];

        $query = "INSERT INTO tb_unit VALUES(
            '',
            '$nama_poli',
            $id_akun_dokter,
            $max_kuota,
            'Aktif'
        )";

        if(mysqli_query($conn,$query)){
            // $last_id = mysqli_insert_id($conn);
            // return insertTableCounter($last_id);
            return mysqli_affected_rows($conn);
        }else{
            return -1;
        }

    }

    // function insertTableCounter($id_poli_klinik){
    //     global $conn;

    //     $query = "INSERT INTO tb_counter VALUES(
    //         '',
    //         $id_poli_klinik,
    //         0,
    //         1,
    //         '0000-00-00'
    //     )";

    //     if(mysqli_query($conn,$query)){
    //         return mysqli_affected_rows($conn);
    //     }else{
    //         return -1;
    //     }
    // }

    function insertJadwalPoliKlinik($data){
        global $conn;

        $id_unit = $data['id_unit'];
        $hari_praktek = $data['hari_praktek'];
        $waktu_praktek = $data['waktu_praktek'];
        
        $query = "INSERT INTO tb_jadwal VALUES(
            '',
            $id_unit,
            '$hari_praktek',
            '$waktu_praktek',
            'Aktif'
        )";

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function updatePoliKlinik($data){
        global $conn;

        $id_poli = $data['id_unit'];
        $nama_poli = $data['nama_poli'];
        $id_dokter = $data['dokter'];
        $max_kuota = $data['max_kuota'];
        $status_poli = $data['status_poli'];

        $query = "UPDATE tb_unit SET nama_unit = '$nama_poli' , id_akun_dokter = $id_dokter , max_kuota = $max_kuota ,
                  unit_status = '$status_poli' WHERE id = $id_poli";

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function updateJadwalPoliKlinik($data){
        global $conn;

        $id_jadwal = $data['id_jadwal'];
        $hari_praktek = $data['hari_praktek'];
        $waktu_praktek = $data['waktu_praktek'];
        $status_jadwal = $data['status_jadwal'];

        $query = "UPDATE tb_jadwal SET hari_praktek = '$hari_praktek' , waktu_praktek = '$waktu_praktek' , 
                  status_jadwal = '$status_jadwal' WHERE id = $id_jadwal";

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function verifikasiPendaftaranOnline($data){
        global $conn;

        $id_pendaftaran = $data['id_pendaftaran'];

        mysqli_query($conn,"UPDATE tb_pendaftaran_online SET verifikasi_administrasi = 'Terverifikasi' 
                    WHERE id = $id_pendaftaran");

        return mysqli_affected_rows($conn);
    }

    function insertSaranMasukan($data){
        global $conn;

        $subject = $data['subject'];
        $pesan = $data['pesan'];
        $time = time();

        $query = "INSERT INTO tb_saran_masukan VALUES(
            '',
            '$subject',
            '$pesan',
            $time
        )";

        var_dump($time);

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function ubahPassword($data){
        global $conn;

        $user_id = $data['user_id'];
        $password_lama = $data['password_lama'];
        $password1 = $data['password_1'];
        $password2 = $data['password_2'];

        //mengambil password lama dari db
        $password_old = select("SELECT password FROM tb_akun_user WHERE id = $user_id")[0]["password"];
        
        if(password_verify($password_lama,$password_old)){
            if(strlen($password1)<8){
                return 'password minimal 8 karakter';
            }else{
                if($password1==$password2){
                    $password = password_hash($password1,PASSWORD_DEFAULT);

                    mysqli_query($conn,"UPDATE tb_akun_user SET password = '$password' WHERE id = $user_id");

                    return mysqli_affected_rows($conn);
                }else{
                    return "password tidak sama";
                }
            }

        }else{
            return "password lama salah";
        }

    }

    function delete($data){
        global $conn;

        $tabel = $data['tabel'];
        $id_data = $data['id'];

        //cek terlebih dahulu data apa yang akan dihapus
        if($tabel=='user'){
            if(mysqli_query($conn,"DELETE FROM tb_akun_user WHERE id = $id_data")){
                return mysqli_affected_rows($conn);
            };
        }else{
            mysqli_query($conn,"DELETE FROM $tabel WHERE id = $id_data");
            return mysqli_affected_rows($conn);
        }

    }
?>
