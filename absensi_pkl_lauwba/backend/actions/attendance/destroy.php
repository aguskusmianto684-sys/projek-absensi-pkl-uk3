<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php';
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

// Ambil data absensi sebelum dihapus (agar bisa dicatat di log)
$qCheck = mysqli_query($connect, "
    SELECT 
        a.*, 
        u.full_name AS nama_peserta
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    WHERE a.id = '$id'
");

if (mysqli_num_rows($qCheck) === 0) {
    echo "<script>
        alert('Data absensi tidak ditemukan!');
        window.location.href='../../pages/attendance/index.php';
    </script>";
    exit;
}

$data = mysqli_fetch_assoc($qCheck);

// Jalankan hapus data
$qDelete = "DELETE FROM attendance WHERE id = '$id'";
$result = mysqli_query($connect, $qDelete);

if ($result) {
    // ✅ Catat ke tabel logs
    if (isset($_SESSION['user_id'])) {
        $description = "Menghapus data absensi milik peserta: " . ($data['nama_peserta'] ?? '-') .
            " | ID Absensi: {$id}" .
            " | Status: " . ($data['status'] ?? '-') .
            " | Check-in: " . ($data['check_in'] ?? '-') .
            " | Check-out: " . ($data['check_out'] ?? '-') .
            " | Catatan: " . ($data['note'] ?? '-');

        logActivity($connect, $_SESSION['user_id'], 'Hapus Absensi', $description);
    }

    echo "<script>
        alert('✅ Data absensi berhasil dihapus!');
        window.location.href='../../pages/attendance/index.php';
    </script>";
    exit;
} else {
    echo "<script>
        alert('❌ Gagal menghapus data absensi: " . addslashes(mysqli_error($connect)) . "');
        window.location.href='../../pages/attendance/index.php';
    </script>";
    exit;
}
