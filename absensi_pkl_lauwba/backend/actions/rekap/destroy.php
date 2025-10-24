<?php
include '../../app.php';

// Pastikan ada parameter ID
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>
        alert('ID jadwal tidak ditemukan!');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
}

// Ambil data jadwal untuk validasi
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
    echo "<script>
        alert('Jadwal berhasil dihapus!');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
} else {
    echo "<script>
        alert('Gagal menghapus jadwal: " . mysqli_error($connect) . "');
        window.location.href='../../pages/schedules/index.php';
    </script>";
    exit;
}
