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
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Absensi PKL Lauwba</title>
  <link
    rel="icon"
    href="../../template_admin/assets/img/kaiadmin/logolauwba.png"
    type="image/x-icon" />
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
    .login-card {
      width: 420px;
      border-radius: 15px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      animation: fadeIn 0.8s ease;
    }
    .login-header {
      background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);
      color: white;
      text-align: center;
      padding: 20px;
      font-weight: bold;
      font-size: 1.4rem;
    }
    @keyframes fadeIn {
      from {opacity:0; transform: translateY(-20px);}
      to {opacity:1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <div class="login-card shadow">
    <div class="login-header">
      <i class="bi bi-box-arrow-in-right"></i> Login Akun
    </div>
    <div class="card-body p-4">
      <form action="../../actions/auth/login_proses.php" method="POST">
        <div class="mb-3">
          <label for="login_id" class="form-label">Username atau Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="login_id" id="login_id" class="form-control" placeholder="Masukkan username atau email" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye-slash" id="iconEye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">
          <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
      </form>

      <p class="text-center mt-3 text-muted">
        Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold text-primary">Daftar di sini</a>
      </p>
    </div>
  </div>

  <script>
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const icon = document.getElementById("iconEye");

    toggle.addEventListener("click", () => {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    });
  </script>

</body>
</html>
