<?php
session_start();
include '../../../config/connection.php';

// ✅ 1. Cek login
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
    alert('ID pembimbing tidak valid!');
    window.location.href='../../pages/supervisors/index.php';
  </script>";
  exit();
}

$id = intval($_GET['id']);

// ✅ 3. Cek apakah data pembimbing ada
$qCheck = mysqli_query($connect, "SELECT * FROM supervisors WHERE id = '$id'");
if (!$qCheck || mysqli_num_rows($qCheck) === 0) {
  echo "<script>
    alert('Data pembimbing tidak ditemukan!');
    window.location.href='../../pages/supervisors/index.php';
  </script>";
  exit();
}

$data = mysqli_fetch_assoc($qCheck);

// ✅ 4. Jalankan query hapus
$qDelete = "DELETE FROM supervisors WHERE id = '$id'";
$result = mysqli_query($connect, $qDelete);

if ($result) {
  echo "<script>
    alert('✅ Data pembimbing berhasil dihapus!');
    window.location.href='../../pages/supervisors/index.php';
  </script>";
} else {
  echo "<script>
    alert('❌ Gagal menghapus data: " . addslashes(mysqli_error($connect)) . "');
    window.location.href='../../pages/supervisors/index.php';
  </script>";
}
?>
