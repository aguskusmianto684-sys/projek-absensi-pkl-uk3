<?php
session_name("ecommerceUserSession");
session_start();
include "../../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];

    $q = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($connect, $q);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['hak_akses'] = $user['hak_akses'];

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
  <h2 class="text-2xl font-bold mb-6">Login</h2>

  <?php if (isset($error)): ?>
    <p class="text-red-600 mb-4"><?= $error ?></p>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <p class="text-green-600 mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded mb-3">
    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded mb-3">
    
    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">Login</button>
  </form>

  <p class="mt-4 text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-green-600">Register</a></p>
</div>

</body>
</html>
