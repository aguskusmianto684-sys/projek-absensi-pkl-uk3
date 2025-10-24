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

  /* Kalau mau efek lebih lembut */
  .navbar.navbar-header {
    background: #ffffffcc; /* sedikit transparan */
    backdrop-filter: blur(6px); /* efek kaca lembut */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }


  .btn-danger:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.5);
    background: linear-gradient(135deg, #ff4d6d, #e63946) !important;
  }
</style>
<div class="main-panel">
  <div class="main-header">
    <div class="main-header-logo">
      <!-- Logo Header -->
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
      <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
      <div class="container-fluid">


        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li
            class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
            <a
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-expanded="false"
              aria-haspopup="true">
              <i class="fa fa-search"></i>
            </a>
            <ul class="dropdown-menu dropdown-search animated fadeIn">
              <form class="navbar-left navbar-form nav-search">
                <div class="input-group">
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control" />
                </div>
              </form>
            </ul>
          </li>
          <li class="nav-item topbar-icon dropdown hidden-caret">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="messageDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <i class="fa fa-envelope"></i>
            </a>
            <ul
              class="dropdown-menu messages-notif-box animated fadeIn"
              aria-labelledby="messageDropdown">
              <li>
                <div
                  class="dropdown-title d-flex justify-content-between align-items-center">
                  Messages
                  <a href="#" class="small">Mark all as read</a>
                </div>
              </li>
              <li>
                <div class="message-notif-scroll scrollbar-outer">
                  <div class="notif-center">
                    <a href="#">
                      <div class="notif-img">
                        <img
                          src="../../template_admin/assets/img/jm_denis.jpg"
                          alt="Img Profile" />
                      </div>
                      <div class="notif-content">
                        <span class="subject">Jimmy Denis</span>
                        <span class="block"> How are you ? </span>
                        <span class="time">5 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-img">
                        <img
                          src="../../template_admin/assets/img/chadengle.jpg"
                          alt="Img Profile" />
                      </div>
                      <div class="notif-content">
                        <span class="subject">Chad</span>
                        <span class="block"> Ok, Thanks ! </span>
                        <span class="time">12 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-img">
                        <img
                          src="../../template_admin/assets/img/mlane.jpg"
                          alt="Img Profile" />
                      </div>
                      <div class="notif-content">
                        <span class="subject">Jhon Doe</span>
                        <span class="block">
                          Ready for the meeting today...
                        </span>
                        <span class="time">12 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-img">
                        <img
                          src="../../template_admin/assets/img/talha.jpg"
                          alt="Img Profile" />
                      </div>
                      <div class="notif-content">
                        <span class="subject">Talha</span>
                        <span class="block"> Hi, Apa Kabar ? </span>
                        <span class="time">17 minutes ago</span>
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              <li>
                <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item topbar-icon dropdown hidden-caret">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="notifDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <i class="fa fa-bell"></i>
              <span class="notification">4</span>
            </a>
            <ul
              class="dropdown-menu notif-box animated fadeIn"
              aria-labelledby="notifDropdown">
              <li>
                <div class="dropdown-title">
                  You have 4 new notification
                </div>
              </li>
              <li>
                <div class="notif-scroll scrollbar-outer">
                  <div class="notif-center">
                    <a href="#">
                      <div class="notif-icon notif-primary">
                        <i class="fa fa-user-plus"></i>
                      </div>
                      <div class="notif-content">
                        <span class="block"> New user registered </span>
                        <span class="time">5 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-icon notif-success">
                        <i class="fa fa-comment"></i>
                      </div>
                      <div class="notif-content">
                        <span class="block">
                          Rahmad commented on Admin
                        </span>
                        <span class="time">12 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-img">
                        <img
                          src="../../template_admin/assets/img/profile2.jpg"
                          alt="Img Profile" />
                      </div>
                      <div class="notif-content">
                        <span class="block">
                          Reza send messages to you
                        </span>
                        <span class="time">12 minutes ago</span>
                      </div>
                    </a>
                    <a href="#">
                      <div class="notif-icon notif-danger">
                        <i class="fa fa-heart"></i>
                      </div>
                      <div class="notif-content">
                        <span class="block"> Farrah liked Admin </span>
                        <span class="time">17 minutes ago</span>
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              <li>
                <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item topbar-user dropdown hidden-caret">
            <a
              class="dropdown-toggle profile-pic"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false">
              <div class="avatar-sm d-flex justify-content-center align-items-center bg-light rounded-circle">
                <i class="fas fa-user-circle fa-2x text-dark"></i>
              </div>
              <span class="me-2 text-capitalize" style="font-weight: bold; font-size: 16px;">
  <?= htmlspecialchars($username_display, ENT_QUOTES, 'UTF-8') ?>
</span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-sm d-flex justify-content-center align-items-center bg-light rounded-circle">
                      <i class="fas fa-user-circle fa-2x text-dark"></i>
                    </div>
                    <div class="u-text">
                      <h4 class="text-capitalize"><?= $_SESSION['username'] ?? 'Guest' ?></h4>
                      <a href="  /pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba/backend/actions/auth/logout.php" class="btn btn-xs btn-danger btn-sm">Logout</a>
                    </div>

                  </div>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  </div>