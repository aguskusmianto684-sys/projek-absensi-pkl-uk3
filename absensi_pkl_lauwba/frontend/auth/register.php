<?php
session_name("ecommerceUserSession");
session_start();
include "../../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nama     = mysqli_real_escape_string($connect, $_POST['nama_lengkap']);
    $email    = mysqli_real_escape_string($connect, $_POST['email']);
    $alamat   = mysqli_real_escape_string($connect, $_POST['alamat']);
    $telepon  = mysqli_real_escape_string($connect, $_POST['no_telepon']);

    $q = "INSERT INTO users (username, password, nama_lengkap, email, alamat, no_telepon, hak_akses, tanggal_registrasi)
          VALUES ('$username', '$password', '$nama', '$email', '$alamat', '$telepon', 'pembeli', NOW())";
    
    if (mysqli_query($connect, $q)) {
        $_SESSION['success'] = "Registrasi berhasil, silakan login!";
        header("Location: login.php");
        exit;
    } else {
        $error = "Registrasi gagal: " . mysqli_error($connect);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
  <h2 class="text-2xl font-bold mb-6">Register</h2>

  <?php if (isset($error)): ?>
    <p class="text-red-600 mb-4"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded mb-3">
    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded mb-3">
    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required class="w-full p-3 border rounded mb-3">
    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border rounded mb-3">
    <input type="text" name="alamat" placeholder="Alamat" required class="w-full p-3 border rounded mb-3">
    <input type="text" name="no_telepon" placeholder="Nomor Telepon" required class="w-full p-3 border rounded mb-3">
    
    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">Daftar</button>
  </form>

  <p class="mt-4 text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-green-600">Login</a></p>
</div>

</body>
</html>
