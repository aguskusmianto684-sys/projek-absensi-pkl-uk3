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
            <img src="../frontend/template-user/assets/images/white-logo.svg" alt="Logo" />
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNine"
            aria-controls="navbarNine" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse sub-menu-bar" id="navbarNine">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="page-scroll active" href="#hero-area">Home</a>
              </li>
              <li class="nav-item">
                <a class="page-scroll" href="#services">Services</a>
              </li>
              <li class="nav-item">
                <a class="page-scroll" href="#pricing">Pricing</a>
              </li>
              <li class="nav-item">
                <a class="page-scroll" href="#contact">Contact</a>
              </li>

              <?php if (isset($_SESSION['id_user'])): ?>
                <!-- Jika SUDAH login -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    👋 <?= htmlspecialchars($_SESSION['username']) ?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../absen.php">Absen</a></li>
                    <li><a class="dropdown-item" href="../profile.php">Profil</a></li>
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

          <div class="navbar-btn d-none d-lg-inline-block">
            <a class="menu-bar" href="#side-menu-left"><i class="lni lni-menu"></i></a>
          </div>
        </nav>
      </div>
    </div>
  </div>
</section>
