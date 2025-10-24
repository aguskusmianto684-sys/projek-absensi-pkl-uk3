<?php
include '../../../config/connection.php';
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
  exit;
}

$id = mysqli_real_escape_string($connect, $_POST['id'] ?? '');
$value = mysqli_real_escape_string($connect, $_POST['setting_value'] ?? '');

if (empty($id) || empty($value)) {
  echo json_encode(['status' => 'error', 'message' => '⚠️ Harap isi semua field!']);
  exit;
}

$q = "UPDATE settings SET setting_value = '$value', updated_at = NOW() WHERE id = '$id'";
$update = mysqli_query($connect, $q);

if ($update) {
  echo json_encode(['status' => 'success', 'message' => '✅ Pengaturan berhasil diperbarui!']);
} else {
  echo json_encode(['status' => 'error', 'message' => '❌ Gagal memperbarui data: ' . mysqli_error($connect)]);
}
?>
