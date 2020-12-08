<?php 

//handler jika file ini diakses langsung dari url
if(!defined('root')){
  header('location:'.BASEURL);die;
}

if(!defined('BASEURL')){
  define('BASEURL',"http://localhost/web/webKlinik/");
}


if(isset($_GET['data'])){
  $page = $_GET['data'];
}else{
  $page = null;
}

if(isset($_GET['queue'])){
  $queue = $_GET['queue'];
}else{
  $queue = null;
}

//untuk list menu antrian apa saja yg akan ditampilkan
if($_SESSION['role'] === 'dev' || $_SESSION['role'] === 'kepala klinik'){
  $list_poli_klinik = select("SELECT id,nama_unit FROM tb_unit WHERE id>1");
}elseif($_SESSION['role'] === 'petugas administrasi'){
  $list_poli_klinik = [];

  $id_akun_adm = $_SESSION['user_id'];
  //cek apakah akun petugas administrasi telah diassigned kan untuk loket tertentu
  $akun_adm_assigned = select("SELECT id FROM tb_loket_administrasi WHERE id_assigned_user = $id_akun_adm");
}elseif(strpos($_SESSION['role'],'dokter')!==false){
  //cek apakah user yg login dokter
  $user_id = $_SESSION['user_id'];
  $list_poli_klinik = select("SELECT id,nama_unit FROM tb_unit WHERE id_akun_dokter = $user_id");
}


?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link text-center">
      <span class="brand-text font-weight-light">Klinik Soedirman</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image my-auto">
          <img src="https://ui-avatars.com/api/?name=Ruly Adhika&size=64&background=bdc3c7&color=00000&format=svg" class="img-circle elevation-2" alt="">
        </div>
        <div class="info my-auto">
          <a href="" class="d-block"><?= $_SESSION['user_name']; ?></a>
          <small class="text-muted" style="text-transform: capitalize;"><?= $_SESSION['role']; ?></small>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
      
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

           
          <?php if(strpos($_SESSION['role'],'dokter')===false) :?> 
            <!-- jika role user bukan dokter -->
          <li class="nav-item has-treeview <?= ($data=='administrasi' || $data=='poli klinik' || $data=='jadwal poli klinik')? 'menu-open' : '' ?>"> 
            <a href="#" class="nav-link <?= ($data=='administrasi' || $data=='poli klinik' || $data=='jadwal poli klinik')? 'active' : '' ?>">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>
                Kelola Unit
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="unit.php?data=administrasi" class="nav-link <?= ($data=='administrasi')? 'active' : '' ?>">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Administrasi</p>
                </a>
              </li>
              <li class="nav-item has-treeview <?= ($data=='poli klinik' || $data=='jadwal poli klinik')? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?= ($data=='poli klinik' || $data=='jadwal poli klinik')? 'active' : '' ?>">
                  <i class="fas fa-clinic-medical nav-icon"></i>
                  <p>
                    Poli Klinik
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="unit.php?data=poli klinik" class="nav-link <?= ($data=='poli klinik')? 'active' : '' ?>">
                            <i class="fa fa-list nav-icon"></i>
                            <p>List Poli Klinik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="unit.php?data=jadwal poli klinik" class="nav-link <?= ($data=='jadwal poli klinik')? 'active' : '' ?>">
                            <i class="far fa-calendar nav-icon"></i>
                            <p>Jadwal Poli Klinik</p>
                        </a>
                    </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- kelola user -->

          <li class="nav-item"> 
            <a href="list.php?data=user" class="nav-link <?= ($data=='user')? 'active' : '' ?>">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Kelola User
              </p>
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-item has-treeview <?= ($queue=='administrasi' || $queue=='poli')? 'menu-open' : '' ?>"> 
            <a href="#" class="nav-link <?= ($queue=='administrasi' || $queue=='poli')? 'active' : '' ?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Kelola Antrian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
              <?php if($_SESSION['role'] == 'petugas administrasi') :?>
                <li class="nav-item">
                  <?php if(count($akun_adm_assigned)>0) :?>
                    <a href="queue.php?queue=administrasi&data=adm" class="nav-link <?= ($queue=='administrasi')? 'active' : '' ?>">
                      <i class="fa fa-home nav-icon"></i>
                      <p>Administrasi</p>
                    </a>
                  <?php else :?>
                    <a href="javascript:void(0)"  class="nav-link">
                      <i class="fa fa-times nav-icon"></i>
                      <p>Administrasi</p>
                    </a>
                  <?php endif; ?>
                </li>
            <?php endif; ?>

              <?php foreach($list_poli_klinik as $poli) :?>
              <li class="nav-item"> 
                <a href="queue.php?queue=poli&data=<?= strtolower($poli['nama_unit']); ?>&id=<?= $poli['id']; ?>" class="nav-link <?= ($data == strtolower($poli['nama_unit']))? 'active' : '' ?>">
                  <i class="fas fa-clinic-medical nav-icon"></i>
                  <p>
                    Poli <?= $poli['nama_unit']; ?>
                  </p>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>