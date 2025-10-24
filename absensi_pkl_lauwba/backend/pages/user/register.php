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
  <link
    rel="icon"
    href="../../template_admin/assets/img/kaiadmin/logolauwba.png"
    type="image/x-icon" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register PKL / Magang</title>
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
      width: 440px;
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
      font-size: 1.4rem;
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
      Registrasi Akun PKL / Magang
    </div>
    <div class="register-card-body">
      <form action="../../actions/auth/register_proses.php" method="POST">
        
        <!-- Nama -->
        <div class="mb-3">
          <label for="full_name" class="form-label">Nama Lengkap</label>
          <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye-slash" id="iconEye"></i>
            </button>
          </div>
        </div>

        <!-- Role -->
        <div class="mb-3">
          <label for="role" class="form-label">Daftar Sebagai</label>
          <select name="role" id="role" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            <option value="peserta">Peserta PKL / Magang</option>
            <option value="pembimbing">Pembimbing Lapangan</option>
          </select>
        </div>

        <!-- Tambahan untuk Peserta -->
        <div id="extraPeserta">
          <div class="mb-3">
            <label for="school" class="form-label">Asal Sekolah</label>
            <input type="text" name="school" id="school" class="form-control" placeholder="Masukkan nama sekolah">
          </div>

          <div class="mb-3">
            <label for="program_study" class="form-label">Program Studi / Jurusan</label>
            <input type="text" name="program_study" id="program_study" class="form-control" placeholder="Masukkan jurusan">
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-person-plus"></i> Daftar Sekarang
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

    // tampilkan input sekolah & jurusan hanya jika role = peserta
    const roleSelect = document.getElementById("role");
    const extraPeserta = document.getElementById("extraPeserta");
    roleSelect.addEventListener("change", () => {
      if (roleSelect.value === "peserta") {
        extraPeserta.style.display = "block";
      } else {
        extraPeserta.style.display = "none";
      }
    });
    extraPeserta.style.display = "none";
  </script>
</body>
</html>
