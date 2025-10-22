<?php
include '../../../config/connection.php';
session_start();

$id = $_POST['id'] ?? null;
$verified = $_POST['verified'] ?? null;
$user_id = $_SESSION['user_id']; // ID pembimbing atau admin yang login

if (!$id) {
    http_response_code(400);
    echo "ID tidak valid";
    exit;
}

if ($verified == 1) {
    // SET TERVERIFIKASI
    $q = "UPDATE attendance 
          SET verified_by='$user_id', verified_at=NOW() 
          WHERE id='$id'";
} else {
    // BATALKAN VERIFIKASI
    $q = "UPDATE attendance 
          SET verified_by=NULL, verified_at=NULL 
          WHERE id='$id'";
}

$res = mysqli_query($connect, $q);

if ($res) {
    echo "OK";
} else {
    echo "ERROR: " . mysqli_error($connect);
}
