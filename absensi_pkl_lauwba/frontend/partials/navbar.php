<?php
session_name("absenPklSession");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<section class="navbar-area navbar-nine">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav class="navbar navbar-expand-lg">
          <a class="navbar-brand" href="index.php">
            <img src="../frontend/template-user/assets/images/logo1.png" alt="Logo" />
          </a>


          <div class="collapse navbar-collapse sub-menu-bar" id="navbarNine">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="page-scroll active" href="#hero-area">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="page-scroll" href="#about">Tentang Kami</a>
              </li>
              <li class="nav-item">
                <a class="page-scroll" href="#absen">Absensi</a>
              </li>
               <li class="nav-item">
                <a class="page-scroll" href="#lokasi">Lokasi Kantor</a>
              </li>
             

              <?php if (isset($_SESSION['id_user'])): ?>
                <!-- Jika SUDAH login -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    👋 <?= htmlspecialchars($_SESSION['username']) ?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-dark" href="../frontend/riwayat.php">📜 Riwayat Absensi</a></li>
                    <li><a class="dropdown-item text-dark" href="../frontend/progres.php">📈 Progres Kehadiran</a></li>
                    <!-- <li><a class="dropdown-item text-dark" href="../profile.php">👤 Profil</a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="auth/logout.php">Logout</a></li>
                  </ul>
                </li>
              <?php else: ?>
                <!-- Jika BELUM login -->
                <li class="nav-item">
                  <a href="auth/login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                  <a href="auth/register.php" class="nav-link">Register</a>
                </li>
              <?php endif; ?>
            </ul>
          </div>

        
        </nav>
      </div>
    </div>
  </div>
</section>
