<?php
include __DIR__ . '/../../../config/connection.php';
session_start();

// Ambil kode dari URL
$code = $_GET['code'] ?? '';

if (empty($code)) {
    echo "<h3>❌ QR Code tidak valid!</h3>";
    exit;
}

// --- Contoh validasi QR (opsional jika kamu ingin simpan kode di DB)
if (strpos($code, 'absen_') !== 0) {
    echo "<h3>⚠️ QR Code tidak dikenali!</h3>";
    exit;
}

// Pastikan user sudah login (peserta)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'peserta') {
    echo "<script>
        alert('Silakan login sebagai peserta untuk scan QR!');
        window.location.href='../../pages/user/login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil participant_id dari user
$qPart = mysqli_query($connect, "SELECT id FROM participants WHERE user_id='$user_id' LIMIT 1");
if (!$qPart || mysqli_num_rows($qPart) == 0) {
    echo "<h3>⚠️ Data peserta tidak ditemukan!</h3>";
    exit;
}
$participant = mysqli_fetch_assoc($qPart);
$participant_id = $participant['id'];

// Cek apakah hari ini sudah ada absen
$tanggal = date('Y-m-d');
$qCek = mysqli_query($connect, "
    SELECT id, check_in, check_out
    FROM attendance
    WHERE participant_id='$participant_id' 
    AND DATE(created_at) = '$tanggal'
    LIMIT 1
");

if ($qCek && mysqli_num_rows($qCek) > 0) {
    // Sudah ada data hari ini
    $row = mysqli_fetch_assoc($qCek);

    if (empty($row['check_out'])) {
        // Lakukan check-out
        $qUpdate = mysqli_query($connect, "
            UPDATE attendance 
            SET check_out = NOW(), updated_at = NOW() 
            WHERE id = '{$row['id']}'
        ");
        if ($qUpdate) {
            echo "<h3>✅ Berhasil Check-out pada " . date('H:i:s') . "</h3>";
        } else {
            echo "<h3>❌ Gagal menyimpan data Check-out!</h3>";
        }
    } else {
        echo "<h3>⚠️ Anda sudah Check-out hari ini.</h3>";
    }
} else {
    // Belum ada absensi → lakukan Check-in baru
    $qInsert = mysqli_query($connect, "
        INSERT INTO attendance (participant_id, check_in, status, note, created_at, updated_at)
        VALUES ('$participant_id', NOW(), 'hadir', 'Absen via QR', NOW(), NOW())
    ");

    if ($qInsert) {
        echo "<h3>✅ Berhasil Check-in pada " . date('H:i:s') . "</h3>";
    } else {
        echo "<h3>❌ Gagal menyimpan data Check-in!</h3>";
    }
}
?>
