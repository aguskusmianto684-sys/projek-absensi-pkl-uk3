<?php
session_name("absenPklSession");
session_start();
include "../../config/connection.php"; // pastikan path benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = mysqli_real_escape_string($connect, $_POST['username']);
    $full_name  = mysqli_real_escape_string($connect, $_POST['full_name']);
    $email      = mysqli_real_escape_string($connect, $_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role       = 'peserta';
    $status     = 'aktif';

    // Cek username atau email sudah ada
    $cek = mysqli_query($connect, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = "Username atau email sudah digunakan!";
    } else {
        $query = "
            INSERT INTO users (username, password_hash, full_name, email, role, status, created_at, updated_at)
            VALUES ('$username', '$password', '$full_name', '$email', '$role', '$status', NOW(), NOW())
        ";
        $insert = mysqli_query($connect, $query);

        if ($insert) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['error'] = "Gagal menyimpan data: " . mysqli_error($connect);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - PKL Lauwba</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h3 class="text-center mb-3 text-primary">Daftar Akun Peserta PKL</h3>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
          <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100" type="submit">Daftar</button>
          </form>

          <p class="text-center mt-3">
            Sudah punya akun?
            <a href="login.php">Login di sini</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
