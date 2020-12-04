<?php 

if(!defined('BASEURL')){
  define('BASEURL',"http://localhost/web/webKlinik/");
}

//handler jika file ini diakses langsung dari url
if(!defined('root')){
  header('location:'.BASEURL);die;
}

?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item border-right">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block ml-3">
        <div class="dateDisplay font-weight-bold text-black-50"></div>
        <div class="clockDisplay text-black-50"></div>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-cog"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <i class="fa fa-home mr-2"></i> Homepage
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= BASEURL ?>page/account/logout.php" class="dropdown-item">
            <i class="fa fa-sign-out-alt mr-2"></i> Log out
          </a>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item dropdown-header">Setting</span>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script src="../src/js/clock.js"></script>