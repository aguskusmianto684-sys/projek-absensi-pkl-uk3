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
  <title>Register Peserta</title>
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

    .register-card {
      width: 420px;
      border-radius: 12px;
      background: #fff;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
      animation: fadeIn 0.8s ease;
    }

    .register-card-header {
      background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);
      color: #fff;
      text-align: center;
      padding: 18px;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .register-card-body {
      padding: 30px;
    }

    @keyframes fadeIn {
      from {opacity:0; transform: translateY(-20px);}
      to {opacity:1; transform: translateY(0);}
    }
  </style>
</head>

<body>
  <div class="register-card shadow">
    <div class="register-card-header">
      Register Peserta
    </div>
    <div class="register-card-body">
      <form action="../../actions/auth/register_proses.php" method="POST">
        <div class="mb-3">
          <label for="full_name" class="form-label">Nama Lengkap</label>
          <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye-slash" id="iconEye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-person-plus"></i> Daftar
        </button>
      </form>

      <p class="text-center mt-3 text-muted">Sudah punya akun? <a href="login.php">Login di sini</a></p>
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
