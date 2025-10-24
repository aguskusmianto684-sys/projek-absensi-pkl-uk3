<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan untuk mencatat log
session_start();

if (isset($_POST['tombol'])) {
  $username = mysqli_real_escape_string($connect, $_POST['username']);
  $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $password = $_POST['password'];
  $role = mysqli_real_escape_string($connect, $_POST['role']);
  $status = mysqli_real_escape_string($connect, $_POST['status']);

  // ✅ Validasi wajib diisi
  if (empty($username) || empty($email) || empty($password) || empty($role)) {
    echo "<script>
      alert('Harap isi semua field wajib!');
      window.location.href='../../pages/users/create.php';
    </script>";
    exit;
  }

  // ✅ Cek apakah email atau username sudah terdaftar
  $check = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' OR username='$username'");
  if (mysqli_num_rows($check) > 0) {
    echo "<script>
      alert('Username atau Email sudah digunakan!');
      window.location.href='../../pages/users/create.php';
    </script>";
    exit;
  }

  // ✅ Hash password untuk keamanan
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // ✅ Simpan data user baru
  $query = "
    INSERT INTO users (username, password_hash, full_name, email, role, status, created_at, updated_at)
    VALUES ('$username', '$password_hash', '$full_name', '$email', '$role', '$status', NOW(), NOW())
  ";

  $result = mysqli_query($connect, $query);

  if ($result) {
    // ✅ Catat log aktivitas
    if (isset($_SESSION['user_id'])) {
      $desc = "Menambahkan user baru: Username = $username, Nama Lengkap = $full_name, Role = $role, Status = $status";
      logActivity($connect, $_SESSION['user_id'], 'Tambah', $desc);
    }

    echo "<script>
      alert('✅ Data user berhasil ditambahkan!');
      window.location.href='../../pages/users/index.php';
    </script>";
  } else {
    echo "<script>
      alert('❌ Gagal menyimpan data: " . addslashes(mysqli_error($connect)) . "');
      window.location.href='../../pages/users/create.php';
    </script>";
  }
}
?>
