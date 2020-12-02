<?php 
$page = $_GET['data'];
if(isset($_GET['queue'])){
  $queue = $_GET['queue'];
}

$list_poli_klinik = select("SELECT id,nama_unit FROM tb_unit WHERE id>1");

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
          <a href="" class="d-block">Dr. Ruly Adhika, S.Kom</a>
          <small class="text-muted">Developer</small>
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

          <li class="nav-item has-treeview <?= ($queue=='administrasi' || $queue=='poli')? 'menu-open' : '' ?>"> 
            <a href="#" class="nav-link <?= ($queue=='administrasi' || $queue=='poli')? 'active' : '' ?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Kelola Antrian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="queue.php?queue=administrasi&data=adm" class="nav-link <?= ($queue=='administrasi')? 'active' : '' ?>">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Administrasi</p>
                </a>
              </li>

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