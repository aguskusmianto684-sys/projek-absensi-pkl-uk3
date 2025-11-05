<?php
session_start();
include __DIR__ . '/../../../config/connection.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'pembimbing'])) {
    echo "Unauthorized";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance_id = $_POST['id'] ?? 0;
    $verified = $_POST['verified'] ?? 0;
    $user_id = $_SESSION['user_id'];
    
    if ($verified == 1) {
        // Verifikasi absensi
        $query = "UPDATE attendance SET verified_by = '$user_id', verified_at = NOW() WHERE id = '$attendance_id'";
    } else {
        // Batalkan verifikasi
        $query = "UPDATE attendance SET verified_by = NULL, verified_at = NULL WHERE id = '$attendance_id'";
    }
    
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($connect);
    }
}
?>