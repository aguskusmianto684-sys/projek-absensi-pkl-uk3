<?php
if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID peserta tidak ditemukan!');
        window.location.href='../../pages/participants/index.php';
    </script>";
    exit;
}

$id = $_GET['id'];

// Ambil data peserta berdasarkan ID
$qSelect = "SELECT * FROM participants WHERE id = '$id'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil hasil query
$participant = $result->fetch_object();

if (!$participant) {
    die("Data peserta tidak ditemukan");
}
