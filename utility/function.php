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

    function insertPendaftaran($data){
        global $conn;

        $id_jadwal = $data["id_jadwal"];
        $kd_pendaftaran = uniqid('',true);

 
        //pendaftaran secara offline
        if(isset($data['tipe_pendaftaran'])){
            if($data['tipe_pendaftaran'] == 'offline'){
                $tanggal_periksa = date("Y-m-d",time());
                $verifikasi_pendaftaran = "Sudah Verifikasi";
            }
        }
        //pendaftaran secara online
        else{
            $id_user = 5;   //session id login
            $tanggal_periksa = date("Y-m-d",$data['date']);
            $verifikasi_pendaftaran = "Belum Verifikasi";
        }

        $no_antrian_administrasi = insertAntrianAdministrasi($tanggal_periksa);
        $no_antrian_poli = insertAntrianPoli($tanggal_periksa,$id_jadwal);

        $query = "INSERT INTO tb_pendaftaran VALUES(
            '',
            $id_user,
            $id_jadwal,
            $no_antrian_administrasi,
            $no_antrian_poli,
            '$tanggal_periksa',
            '$kd_pendaftaran',
            '',
            '$verifikasi_pendaftaran'
        )";

        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);

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
            $last_id = mysqli_insert_id($conn);
            return insertTableCounter($last_id);
        }else{
            return -1;
        }

    }

    function insertTableCounter($id_poli_klinik){
        global $conn;

        $query = "INSERT INTO tb_counter VALUES(
            '',
            $id_poli_klinik,
            0,
            1,
            '0000-00-00'
        )";

        if(mysqli_query($conn,$query)){
            return mysqli_affected_rows($conn);
        }else{
            return -1;
        }
    }

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


?>
