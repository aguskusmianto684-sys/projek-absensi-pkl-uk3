<?php
require_once '../../app.php';
if (!isset($_GET['id'])) {
    echo "<script>alert('Tidak Bisa memilih ID ini'); window.location.href = '../../pages/blog/index.php';</script>";
    exit;
}

$id = $_GET['id'];
$qSelect = "SELECT * FROM blogs WHERE id='$id'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));
$blog = $result->fetch_object();
if (!$blog) {
    echo "<script>alert('Data tidak ditemukan'); window.location.href = '../../pages/blog/index.php';</script>";
    exit;
}
