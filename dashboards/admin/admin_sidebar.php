<?php
function isActive($page) {
    $current_page = basename($_SERVER['PHP_SELF']);
    return ($current_page == $page) ? 'active' : '';
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Remobil</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user1-128x128.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="admin_dashboard.php" class="nav-link <?php echo isActive('admin_dashboard.php'); ?>">
              <i class="nav-icon fas fa-house"></i>
              <p>Home</p>
            </a>
          </li>

          <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas'): ?>
          <li class="nav-header">ADMIN ONLY</li>
          <li class="nav-item">
            <a href="../../data_mobil.php" class="nav-link <?php echo isActive('data_mobil.php'); ?>">
              <i class="nav-icon fas fa-car"></i>
              <p>Data Mobil</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../../data_rental.php" class="nav-link <?php echo isActive('data_rental.php'); ?>">
              <i class="nav-icon fas fa-hand-holding"></i>
              <p>Data Rental</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../../data_pembayaran.php" class="nav-link <?php echo isActive('data_pembayaran.php'); ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>Data Pembayaran</p>
            </a>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['role'] == 'admin'): ?>
          <li class="nav-header">ADMIN ONLY</li>
          <li class="nav-item">
            <a href="../../data_users.php" class="nav-link <?php echo isActive('data_users.php'); ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>Data Anggota</p>
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-item">
            <a href="../../logout.php" class="nav-link">
              <i class="nav-icon fas fa-door-open"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>