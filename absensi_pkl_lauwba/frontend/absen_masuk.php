<?php
session_start();
include "../config/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = $_POST['participant_id'];
    $status = 'hadir';
    $check_in_location = 'Kampus Lauwba'; // nanti bisa pakai GPS

    $sql = "INSERT INTO attendance (participant_id, check_in, check_in_location, status)
            VALUES ('$participant_id', NOW(), '$check_in_location', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Absensi berhasil!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan absensi!');
            window.location.href = 'index.php';
        </script>";
    }
}
?>
