<?php
include '../../app.php';
session_start();

if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['role'], ['admin', 'pembimbing'])) {
    echo "Akses ditolak!";
    exit;
}

$token = bin2hex(random_bytes(16));

// atur jam absensi
$valid_from = "07:00:00";
$valid_until = "18:00:00";

// expired otomatis hari ini jam 18:00
$expired = date('Y-m-d') . " 18:00:00";

$q = mysqli_query($connect, "
    INSERT INTO qr_sessions(token, created_at, expired_at, valid_from, valid_until)
    VALUES('$token', NOW(), '$expired', '$valid_from', '$valid_until')
");

echo "<script>
    alert('QR baru berhasil dibuat dan hanya bisa dipakai jam 07.00 - 18.00 hari ini');
    window.location.href='../../pages/attendance/generate_qr.php';
</script>";
