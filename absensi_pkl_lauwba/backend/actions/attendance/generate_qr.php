<?php
// backend/actions/attendance/generate_qr.php
include '../../../config/connection.php';
session_start();

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda belum login!']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 1️⃣ Generate token unik
$token = md5(uniqid(rand(), true));

// 2️⃣ Tentukan masa berlaku QR (5 menit)
$expired_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

// 3️⃣ Simpan ke tabel qr_sessions
$query = "
    INSERT INTO qr_sessions (token, expired_at, created_by, created_at)
    VALUES ('$token', '$expired_at', '$user_id', NOW())
";

if (mysqli_query($connect, $query)) {

    // 4️⃣ URL tujuan QR
    // Ganti domain sesuai lokasi sistemmu
    $domain = "http://localhost/pkl_lauwba/projek_absensi_pkl_uk3/absensi_pkl_lauwba";
    $qr_url = $domain . "/backend/actions/attendance/scan_qr.php?token=" . $token;

    echo json_encode([
        'status' => 'success',
        'message' => 'QR Code berhasil dibuat!',
        'token' => $token,
        'expired_at' => $expired_at,
        'url' => $qr_url
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan data QR: ' . mysqli_error($connect)
    ]);
}
?>
