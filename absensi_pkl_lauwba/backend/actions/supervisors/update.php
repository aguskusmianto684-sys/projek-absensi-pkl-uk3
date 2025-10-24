<?php
session_start();
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ untuk mencatat log aktivitas

if (isset($_POST['tombol'])) {
  // Amankan input
  $id = mysqli_real_escape_string($connect, $_POST['id']);
  $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);
  $department = mysqli_real_escape_string($connect, $_POST['department']);
  $phone = mysqli_real_escape_string($connect, $_POST['phone']);
  $note = mysqli_real_escape_string($connect, $_POST['note']);

  // Validasi input wajib
  if (empty($id) || empty($user_id) || empty($department) || empty($phone)) {
    echo "<script>
      alert('⚠️ Harap isi semua field wajib!');
      window.history.back();
    </script>";
    exit;
  }

  // 🔹 Cek apakah kolom updated_at ada di tabel supervisors
  $checkCol = mysqli_query($connect, "SHOW COLUMNS FROM supervisors LIKE 'updated_at'");
  $hasUpdatedAt = mysqli_num_rows($checkCol) > 0;

  // 🔹 Sesuaikan query tergantung kolom updated_at
  if ($hasUpdatedAt) {
    $query = "
      UPDATE supervisors 
      SET 
        user_id = '$user_id',
        department = '$department',
        phone = '$phone',
        note = '$note',
        updated_at = NOW()
      WHERE id = '$id'
    ";
  } else {
    $query = "
      UPDATE supervisors 
      SET 
        user_id = '$user_id',
        department = '$department',
        phone = '$phone',
        note = '$note'
      WHERE id = '$id'
    ";
  }

  $update = mysqli_query($connect, $query);

  if ($update) {
    // ✅ Catat log aktivitas
    if (isset($_SESSION['user_id'])) {
      $deskripsi = "Memperbarui data pembimbing ID: $id (User ID: $user_id, Department: $department, Telepon: $phone)";
      logActivity($connect, $_SESSION['user_id'], 'Edit', $deskripsi);
    }

    echo "<script>
      alert('✅ Data pembimbing berhasil diperbarui!');
      window.location.href='../../pages/supervisors/index.php';
    </script>";
  } else {
    echo "<script>
      alert('❌ Gagal memperbarui data: " . addslashes(mysqli_error($connect)) . "');
      window.history.back();
    </script>";
  }
}
?>
