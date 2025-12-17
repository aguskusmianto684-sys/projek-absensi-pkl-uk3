<?php
include __DIR__ . '/../../config/connection.php';

// Ambil data user dari DB berdasarkan session user_id
$user_id = $_SESSION['user_id'] ?? null;
$user_data = null;

if ($user_id) {
  $query = mysqli_query($connect, "SELECT username, full_name, role FROM users WHERE id = '$user_id' LIMIT 1");
  $user_data = mysqli_fetch_assoc($query);
}

// Jika user belum login
$username_display = $user_data['username'] ?? $_SESSION['username'] ?? 'Guest';
?>

<style>
  /* Navbar lembut */
  .navbar.navbar-header {
    background: #ffffffcc;
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .btn-danger:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.5);
    background: linear-gradient(135deg, #ff4d6d, #e63946) !important;
  }

  /* ===============================
     FIX DROPDOWN USER MOBILE
  ================================ */

  .main-header,
  .navbar,
  .navbar-header,
  .navbar-header-transparent {
    overflow: visible !important;
  }

  .dropdown-menu {
    z-index: 99999 !important;
  }

  @media (max-width: 991px) {
    .navbar .dropdown-user {
      position: fixed !important;
      top: 70px !important;
      right: 15px !important;
      left: auto !important;
      width: 260px;
      max-width: calc(100vw - 30px);
      border-radius: 14px;
      box-shadow: 0 12px 35px rgba(0,0,0,.25);
    }
  }

  .dropdown-user .user-box {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .dropdown-user .u-text h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
  }

  .dropdown-user .btn-danger {
    width: 100%;
    margin-top: 8px;
  }
</style>

<div class="main-panel">
  <div class="main-header">
    <div class="main-header-logo">
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
          <img
            src="../../template_admin/assets/img/kaiadmin/logolauwba.png"
            alt="navbar brand"
            class="navbar-brand"
            height="20" />
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

    <!-- NAVBAR -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
      <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

          <!-- USER DROPDOWN (FIXED) -->
          <li class="nav-item dropdown topbar-user">
            <a
              class="dropdown-toggle d-flex align-items-center gap-2"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false">

              <div class="avatar-sm d-flex justify-content-center align-items-center bg-light rounded-circle">
                <i class="fas fa-user-circle fa-2x text-dark"></i>
              </div>

              <span class="me-2 text-capitalize fw-bold d-none d-lg-inline">
                <?= htmlspecialchars($username_display, ENT_QUOTES, 'UTF-8') ?>
              </span>
            </a>

            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <li>
                <div class="user-box p-3">
                  <div class="avatar-sm d-flex justify-content-center align-items-center bg-light rounded-circle">
                    <i class="fas fa-user-circle fa-2x text-dark"></i>
                  </div>

                  <div class="u-text w-100">
                    <h4 class="text-capitalize">
                      <?= $_SESSION['username'] ?? 'Guest' ?>
                    </h4>

                    <a
                      href="/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/actions/auth/logout.php"
                      class="btn btn-danger btn-sm">
                      <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <!-- END USER DROPDOWN -->

        </ul>
      </div>
    </nav>
    <!-- END NAVBAR -->
  </div>
</div>
