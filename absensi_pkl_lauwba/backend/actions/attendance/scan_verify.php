<?php
include '../../app.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'peserta') {
    echo "Akses ditolak!";
    exit;
}

$user_id  = $_SESSION['user_id'];
$token    = $_POST['token'] ?? null;
$location = $_POST['location'] ?? null;

if (!$token) {
    echo "QR tidak valid!";
    exit;
}

// ✅ Cek QR valid & aktif
$q = mysqli_query($connect, "
    SELECT * FROM qr_sessions 
    WHERE token='$token' AND expired_at > NOW()
    LIMIT 1
");
$qr = mysqli_fetch_assoc($q);

if (!$qr) {
    echo "QR sudah kadaluarsa atau tidak valid!";
    exit;
}

// ✅ Ambil participant_id peserta login
$qP = mysqli_query($connect, "SELECT id FROM participants WHERE user_id='$user_id' LIMIT 1");
$p = mysqli_fetch_assoc($qP);

if (!$p) {
    echo "Peserta tidak ditemukan!";
    exit;
}

$participant_id = $p['id'];
$tanggal = date('Y-m-d');

// ✅ Cek apakah sudah absen (check-in) hari ini
$qCheck = mysqli_query($connect, "
    SELECT id, check_in, check_out FROM attendance
    WHERE participant_id='$participant_id'
    AND DATE(check_in)= '$tanggal'
    LIMIT 1
");

if (mysqli_num_rows($qCheck) == 0) {

    // ✅ Check-IN baru
    mysqli_query($connect, "
        INSERT INTO attendance (
            participant_id, check_in, check_in_location, status, note, created_at
        ) VALUES (
            '$participant_id',
            NOW(),
            '$location',
            'hadir',
            'Check-in via QR',
            NOW()
        )
    ");

    echo "✅ Check-in berhasil!";
    exit;

} else {

    $row = mysqli_fetch_assoc($qCheck);

    // ✅ Jika sudah check-out juga → Tidak boleh absen lagi
    if ($row['check_out']) {
        echo "⛔ Kamu sudah Check-out hari ini!";
        exit;
    }

    // ✅ Check-OUT
    mysqli_query($connect, "
        UPDATE attendance SET 
            check_out = NOW(),
            check_out_location = '$location',
            updated_at = NOW(),
            note = 'Check-out via QR'
        WHERE id = '".$row['id']."'
    ");

    echo "✅ Check-out berhasil!";
    exit;
}
