<?php
session_name("absenPklSession");
session_start();
include "../../config/connection.php"; // pastikan path sesuai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];

    // Cek user berdasarkan username
    $query = mysqli_query($connect, "SELECT * FROM users WHERE username='$username' LIMIT 1");

    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        // Cek status aktif
        if ($user['status'] !== 'aktif') {
            $_SESSION['error'] = "Akun Anda nonaktif. Hubungi admin.";
        } elseif (password_verify($password, $user['password_hash'])) {
            // Login berhasil
            $_SESSION['id_user']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['status']    = $user['status'];

            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - PKL Lauwba</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h3 class="text-center mb-3 text-primary">Login Peserta PKL</h3>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100" type="submit">Login</button>
          </form>

          <p class="text-center mt-3">
            Belum punya akun?
            <a href="register.php">Daftar di sini</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
