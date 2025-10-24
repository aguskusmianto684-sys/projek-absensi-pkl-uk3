<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan pencatatan log
session_start();

$id = $_POST['id'] ?? null;
$verified = $_POST['verified'] ?? null;
$user_id = $_SESSION['user_id'] ?? null; // ID pembimbing/admin yang login

if (!$id) {
    http_response_code(400);
    echo "ID tidak valid";
    exit;
}

// 🔹 Tentukan query update berdasarkan aksi
if ($verified == 1) {
    // ✅ SET TERVERIFIKASI
    $q = "UPDATE attendance 
          SET verified_by='$user_id', verified_at=NOW() 
          WHERE id='$id'";
    $aksi = 'Verifikasi';
    $desc = "Memverifikasi data absensi ID: $id";
} else {
    // ❌ BATALKAN VERIFIKASI
    $q = "UPDATE attendance 
          SET verified_by=NULL, verified_at=NULL 
          WHERE id='$id'";
    $aksi = 'Batalkan Verifikasi';
    $desc = "Membatalkan verifikasi absensi ID: $id";
}

$res = mysqli_query($connect, $q);

// 🔹 Cek hasil query
if ($res) {
    // ✅ Catat log hanya jika user login
    if ($user_id) {
        logActivity($connect, $user_id, $aksi, $desc);
    }
    echo "OK";
} else {
    echo "ERROR: " . mysqli_error($connect);
}
?>
