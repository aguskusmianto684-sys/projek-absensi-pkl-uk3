<?php
include '../../app.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'peserta') {
    echo "Akses ditolak!";
    exit;
}

$user_id = $_SESSION['user_id'];
$status  = $_POST['status'];
$note    = $_POST['note'];
$today   = date('Y-m-d');

// Ambil participant_id
$qP = mysqli_query($connect, "SELECT id FROM participants WHERE user_id='$user_id' LIMIT 1");
$p = mysqli_fetch_assoc($qP);

if (!$p) {
    echo "<script>alert('Data peserta tidak ditemukan'); window.location.href='../../pages/attendance/index.php';</script>";
    exit;
}

$participant_id = $p['id'];

// cek apakah sudah ada absensi hari ini
$cek = mysqli_query($connect, "
    SELECT id FROM attendance 
    WHERE participant_id='$participant_id' AND DATE(created_at)='$today' LIMIT 1
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Absensi hari ini sudah tercatat!'); window.location.href='../../pages/attendance/index.php';</script>";
    exit;
}

// upload bukti file
$file_name = null;
if (!empty($_FILES['bukti']['name'])) {
    $tmp = $_FILES['bukti']['tmp_name'];
    $file_name = time() . "_" . $_FILES['bukti']['name'];
    move_uploaded_file($tmp, "../../../storage/" . $file_name);
}

// simpan izin / sakit
mysqli_query($connect, "
    INSERT INTO attendance (participant_id, status, note, bukti, created_at)
    VALUES ('$participant_id', '$status', '$note', '$file_name', NOW())
");

echo "<script>alert('Pengajuan $status berhasil!'); window.location.href='../../pages/attendance/index.php';</script>";
