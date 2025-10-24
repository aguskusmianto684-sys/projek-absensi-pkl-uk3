<?php
session_start();
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan untuk mencatat log

// ✅ 1. Pastikan user sudah login
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
    alert('Silakan login terlebih dahulu!');
    window.location.href='../../pages/user/login.php';
  </script>";
  exit();
}

// ✅ 2. Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>
    alert('ID user tidak valid!');
    window.location.href='../../pages/users/index.php';
  </script>";
  exit();
}

$id = intval($_GET['id']);

// ✅ 3. Cegah penghapusan user admin utama (opsional, keamanan tambahan)
if ($id === 1) {
  echo "<script>
    alert('⚠️ User admin utama tidak dapat dihapus!');
    window.location.href='../../pages/users/index.php';
  </script>";
  exit();
}

// ✅ 4. Cek apakah user ada di database
$qCheck = mysqli_query($connect, "SELECT * FROM users WHERE id = '$id'");
if (!$qCheck || mysqli_num_rows($qCheck) === 0) {
  echo "<script>
    alert('Data user tidak ditemukan!');
    window.location.href='../../pages/users/index.php';
  </script>";
  exit();
}

$data = mysqli_fetch_assoc($qCheck);

// ✅ 5. Jalankan query hapus
$qDelete = "DELETE FROM users WHERE id = '$id'";
$result = mysqli_query($connect, $qDelete);

// ✅ 6. Jika sukses, catat log aktivitas
if ($result) {
  if (isset($_SESSION['user_id'])) {
    $deskripsi = "Menghapus user dengan ID: $id, Username: {$data['username']}, Role: {$data['role']}";
    logActivity($connect, $_SESSION['user_id'], 'Hapus', $deskripsi);
  }

  echo "<script>
    alert('✅ Data user berhasil dihapus!');
    window.location.href='../../pages/users/index.php';
  </script>";
} else {
  echo "<script>
    alert('❌ Gagal menghapus data: " . addslashes(mysqli_error($connect)) . "');
    window.location.href='../../pages/users/index.php';
  </script>";
}
?>
