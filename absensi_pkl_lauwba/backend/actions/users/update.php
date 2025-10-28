<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php';
session_start();

if (isset($_POST['tombol'])) {
  // Amankan input
  $id         = mysqli_real_escape_string($connect, $_POST['id']);
  $username   = mysqli_real_escape_string($connect, $_POST['username']);
  $full_name  = mysqli_real_escape_string($connect, $_POST['full_name']);
  $email      = mysqli_real_escape_string($connect, $_POST['email']);
  $phone      = mysqli_real_escape_string($connect, $_POST['phone']); // ✅ tambah phone
  $role       = mysqli_real_escape_string($connect, $_POST['role']);
  $status     = mysqli_real_escape_string($connect, $_POST['status']);
  $password   = $_POST['password'];

  // Validasi field wajib
  if (empty($id) || empty($username) || empty($full_name) || empty($email) || empty($role) || empty($status) || empty($phone)) {
    echo "<script>
      alert('⚠️ Harap isi semua field wajib!');
      window.history.back();
    </script>";
    exit;
  }

  // Cek apakah kolom updated_at ada di tabel users
  $checkCol = mysqli_query($connect, "SHOW COLUMNS FROM users LIKE 'updated_at'");
  $hasUpdatedAt = mysqli_num_rows($checkCol) > 0;

  // Tentukan query update (dengan atau tanpa password)
  if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "
      UPDATE users 
      SET 
        username = '$username',
        full_name = '$full_name',
        email = '$email',
        phone = '$phone',  -- ✅ tambahkan phone di update
        role = '$role',
        status = '$status',
        password_hash = '$hashed' " . 
        ($hasUpdatedAt ? ", updated_at = NOW()" : "") . "
      WHERE id = '$id'
    ";
  } else {
    $query = "
      UPDATE users 
      SET 
        username = '$username',
        full_name = '$full_name',
        email = '$email',
        phone = '$phone',  -- ✅ tambahkan phone di update
        role = '$role',
        status = '$status' " . 
        ($hasUpdatedAt ? ", updated_at = NOW()" : "") . "
      WHERE id = '$id'
    ";
  }

  $update = mysqli_query($connect, $query);

  if ($update) {
    // Catat log aktivitas
    if (isset($_SESSION['user_id'])) {
      $desc = "Memperbarui data user ID: $id, Username: $username, Nama: $full_name, Phone: $phone, Role: $role, Status: $status";
      logActivity($connect, $_SESSION['user_id'], 'Edit', $desc);
    }

    echo "<script>
      alert('✅ Data user berhasil diperbarui!');
      window.location.href='../../pages/users/index.php';
    </script>";
  } else {
    echo "<script>
      alert('❌ Gagal memperbarui data: " . addslashes(mysqli_error($connect)) . "');
      window.history.back();
    </script>";
  }
}
?>
