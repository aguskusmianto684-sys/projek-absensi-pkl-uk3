<?php
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambah fungsi log aktivitas
session_start();

// Pastikan ada parameter ID
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>
        alert('ID jadwal tidak ditemukan!');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
}

// Ambil data jadwal untuk validasi (misal untuk deskripsi log)
$qSelect = mysqli_query($connect, "SELECT * FROM schedules WHERE id = '$id'") or die(mysqli_error($connect));
$data = mysqli_fetch_assoc($qSelect);

if (!$data) {
    echo "<script>
        alert('Data jadwal tidak ditemukan!');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
}

// Hapus data jadwal dari database
$qDelete = "DELETE FROM schedules WHERE id = '$id'";
$res = mysqli_query($connect, $qDelete);

if ($res) {

    // ✅ Catat log aktivitas (kalau user sedang login)
    if (isset($_SESSION['user_id'])) {
        $desc = "Menghapus jadwal (ID: $id) — Tanggal: " . ($data['schedule_date'] ?? '-') . 
                ", Kegiatan: " . ($data['activity'] ?? '-') . ".";
        logActivity($connect, $_SESSION['user_id'], 'Hapus', $desc);
    }

    echo "<script>
        alert('✅ Jadwal berhasil dihapus!');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
} else {
    echo "<script>
        alert('❌ Gagal menghapus jadwal: " . addslashes(mysqli_error($connect)) . "');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
}
?>
