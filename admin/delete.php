<?php 
session_start();
require '../utility/function.php';

// redirect handler
if(!isset($_SESSION['login'])){
  header("Location:../login.php");die;
}else{
    // cek terlebih dahulu siapa yang mengkases halaman ini
    if($_SESSION['role']=='petugas administrasi' || $_SESSION['role']=='dev' || $_SESSION['role']=='kepala klinik'){
        $data = $_GET['data'];
        $id = $_GET['id'];

        if($data == 'administrasi'){
            $result = delete(['tabel'=>'tb_loket_administrasi','id'=>$id]);

            echo $result;die;
        }elseif($data == 'poli'){
            $result = delete(['tabel'=>'tb_unit','id'=>$id]);

            echo $result;die;
        }elseif($data == 'jadwal poli'){
            $result = delete(['tabel'=>'tb_jadwal','id'=>$id]);

            echo $result;die;
        }elseif($data == 'user'){
            $result = delete(['tabel'=>'user','id'=>$id]);

            echo $result;die;
        }else{
            header("Location:../index.php");die;
        }


    }else{
        header("Location:../index.php");die;
    }
}

?>