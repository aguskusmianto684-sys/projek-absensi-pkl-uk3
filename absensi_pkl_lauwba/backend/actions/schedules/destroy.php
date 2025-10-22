<?php
include '../../app.php';

// Pastikan ada parameter ID
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>
        alert('ID peserta tidak ditemukan!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

// Ambil data peserta untuk validasi
$qSelect = mysqli_query($connect, "SELECT * FROM participants WHERE id = '$id'") or die(mysqli_error($connect));
$data = mysqli_fetch_assoc($qSelect);

if (!$data) {
    echo "<script>
        alert('Data peserta tidak ditemukan!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

// Hapus data peserta dari database
$qDelete = "DELETE FROM participants WHERE id = '$id'";
$res = mysqli_query($connect, $qDelete);

if ($res) {
    echo "<script>
        alert('Data peserta berhasil dihapus!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
} else {
    echo "<script>
        alert('Data gagal dihapus: " . mysqli_error($connect) . "');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}
