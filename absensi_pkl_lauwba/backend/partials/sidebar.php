<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/dashboard/index.php" class="logo d-flex align-items-center">
        <img
          src="../../template_admin/assets/img/kaiadmin/logolauwba.png"
          alt="navbar brand"
          class="navbar-brand me-0"
          height="50" />
        <span class="text-white fw-bold fs-5">Lauwba Academy</span>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
  </div>

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <!-- === DASHBOARD (Semua Role Bisa) === -->
        <li class="nav-item <?= ($page == 'dashboard') ? 'active' : '' ?>">
          <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/dashboard/index.php">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- === ABSENSI (Admin, Pembimbing, Peserta) === -->
        <?php if (in_array($_SESSION['role'], ['admin', 'pembimbing', 'peserta'])): ?>
          <li class="nav-item <?= ($page == 'attendance') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/attendance/index.php">
              <i class="fas fa-user-check"></i>
              <p>Absensi</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- === JADWAL (Admin & Pembimbing) === -->
        <?php if (in_array($_SESSION['role'], ['admin', 'pembimbing'])): ?>
          <li class="nav-item <?= ($page == 'schedules') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/schedules/index.php">
              <i class="fas fa-calendar-alt"></i>
              <p>Jadwal</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- === REKAP / LAPORAN (Semua Role Bisa) === -->
        <?php if (in_array($_SESSION['role'], ['admin', 'pembimbing', 'peserta'])): ?>
          <li class="nav-item <?= ($page == 'rekap') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/rekap/index.php">
              <i class="fas fa-file-alt"></i>
              <p>Laporan</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- === MENU ADMIN KHUSUS === -->
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <!-- Manajemen Peserta -->
          <li class="nav-item <?= ($page == 'participants') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/participants/index.php">
              <i class="fas fa-users"></i>
              <p>Peserta</p>
            </a>
          </li>

          <!-- Manajemen Pembimbing -->
          <li class="nav-item <?= ($page == 'supervisors') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/supervisors/index.php">
              <i class="fas fa-chalkboard-teacher"></i>
              <p>Pembimbing</p>
            </a>
          </li>

          <!-- User Management -->
          <li class="nav-item <?= ($page == 'users') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/users/index.php">
              <i class="fas fa-user-cog"></i>
              <p>Pengguna</p>
            </a>
          </li>

          <!-- Aktivitas / Log -->
          <li class="nav-item <?= ($page == 'logs') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/logs/index.php">
              <i class="fas fa-list-alt"></i>
              <p>Aktivitas</p>
            </a>
          </li>

          <!-- Pengaturan -->
          <li class="nav-item <?= ($page == 'settings') ? 'active' : '' ?>">
            <a href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/pages/settings/index.php">
              <i class="fas fa-cog"></i>
              <p>Setting</p>
            </a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->
