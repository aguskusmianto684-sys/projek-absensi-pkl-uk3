<?php
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan fungsi log aktivitas
session_start();

// ✅ Pastikan parameter ID ada dan valid
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<script>
        alert('ID peserta tidak valid!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

// ✅ Cek apakah data peserta ada
$qSelect = mysqli_query($connect, "SELECT * FROM participants WHERE id = $id");
if (!$qSelect || mysqli_num_rows($qSelect) === 0) {
    echo "<script>
        alert('Data peserta tidak ditemukan!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

$participant = mysqli_fetch_assoc($qSelect);

// ✅ Cek apakah peserta masih punya data absensi
$qCheckAbsensi = mysqli_query($connect, "SELECT COUNT(*) AS total_absen FROM attendance WHERE participant_id = $id");
$absensi = mysqli_fetch_assoc($qCheckAbsensi);

if ($absensi['total_absen'] > 0) {
    echo "<script>
        alert('⚠️ Peserta ini masih memiliki data absensi, tidak bisa dihapus!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

// ✅ Jika tidak ada absensi, lanjut hapus peserta
$qDelete = mysqli_query($connect, "DELETE FROM participants WHERE id = $id");

if ($qDelete) {
    // ✅ Catat aktivitas log
    if (isset($_SESSION['user_id'])) {
        $desc = "Menghapus data peserta: " . ($participant['name'] ?? 'Tidak diketahui') . 
                " (Sekolah: " . ($participant['school'] ?? '-') . ")";
        logActivity($connect, $_SESSION['user_id'], 'Hapus', $desc);
    }

    echo "<script>
        alert('✅ Data peserta berhasil dihapus!');
        window.location.href='../../pages/participants/index.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Data gagal dihapus: " . addslashes(mysqli_error($connect)) . "');
        window.location.href='../../pages/participants/index.php';
    </script>";
}
?>
