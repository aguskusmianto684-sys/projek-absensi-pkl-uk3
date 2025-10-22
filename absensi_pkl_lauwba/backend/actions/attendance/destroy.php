<?php
include '../../../config/connection.php';
session_start();

// Pastikan ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
    alert('ID absensi tidak ditemukan!');
    window.location.href='../../pages/attendance/index.php';
  </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data lama (untuk validasi atau jika nanti ingin hapus file bukti absen)
$qCheck = mysqli_query($connect, "SELECT * FROM attendance WHERE id = '$id'");
if (mysqli_num_rows($qCheck) === 0) {
    echo "<script>
    alert('Data absensi tidak ditemukan!');
    window.location.href='../../pages/attendance/index.php';
  </script>";
    exit;
}

// Jalankan hapus
$qDelete = "DELETE FROM attendance WHERE id = '$id'";
$result = mysqli_query($connect, $qDelete);

if ($result) {
    echo "<script>
    alert('Data absensi berhasil dihapus!');
    window.location.href='../../pages/attendance/index.php';
  </script>";
} else {
    echo "<script>
    alert('Gagal menghapus data absensi!');
    window.location.href='../../pages/attendance/index.php';
  </script>";
}
