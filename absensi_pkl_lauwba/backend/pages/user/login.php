<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  echo "<script>
        alert('Anda sudah login');
        window.location.href='../../pages/dashboard/index.php';
    </script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login & Register - Lauwba Academy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      background: linear-gradient(135deg, #0077b6, #90e0ef);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      width: 420px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      background: #fff;
      transition: 0.3s ease-in-out;
    }

    .card-header {
      background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);
      color: #fff;
      text-align: center;
      padding: 18px;
      font-size: 1.4rem;
      font-weight: bold;
    }

    .form-switcher {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
    }

    .form-switcher a {
      color: #0077b6;
      font-weight: 600;
      text-decoration: none;
    }

    .form-switcher a:hover {
      text-decoration: underline;
    }

    .hidden {
      display: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #0077b6, #0096c7);
      border: none;
    }
  </style>
</head>
<body>

  <!-- Kartu utama -->
  <div class="card" id="authCard">
    <!-- Login Form -->
    <div id="loginForm">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="../../actions/auth/login_proses.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Username atau Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="login_id" class="form-control" placeholder="Masukkan username atau email" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="bi bi-eye-slash" id="iconEye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-3">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
          </button>
        </form>

        <div class="form-switcher">
          Belum punya akun? <a href="#" id="showRegister">Daftar Sekarang</a>
        </div>
      </div>
    </div>

    <!-- Register Form -->
    <div id="registerForm" class="hidden">
      <div class="card-header">Register</div>
      <div class="card-body">
        <form action="../../actions/auth/register_proses.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
              <input type="text" name="full_name" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
              <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password" id="registerPassword" class="form-control" placeholder="Masukkan password" required>
              <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                <i class="bi bi-eye-slash" id="iconEyeReg"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn btn-success w-100 mt-3">
            <i class="bi bi-person-plus me-1"></i> Register
          </button>
        </form>

        <div class="form-switcher">
          Sudah punya akun? <a href="#" id="showLogin">Login di sini</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const iconEye = document.getElementById("iconEye");

    togglePassword.addEventListener("click", () => {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      iconEye.classList.toggle("bi-eye");
      iconEye.classList.toggle("bi-eye-slash");
    });

    const toggleRegisterPassword = document.getElementById("toggleRegisterPassword");
    const regPassword = document.getElementById("registerPassword");
    const iconEyeReg = document.getElementById("iconEyeReg");

    toggleRegisterPassword.addEventListener("click", () => {
      const type = regPassword.getAttribute("type") === "password" ? "text" : "password";
      regPassword.setAttribute("type", type);
      iconEyeReg.classList.toggle("bi-eye");
      iconEyeReg.classList.toggle("bi-eye-slash");
    });

    // Ganti antara login & register
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    document.getElementById('showRegister').addEventListener('click', () => {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
    });
    document.getElementById('showLogin').addEventListener('click', () => {
      registerForm.classList.add('hidden');
      loginForm.classList.remove('hidden');
    });
  </script>

</body>
</html>
