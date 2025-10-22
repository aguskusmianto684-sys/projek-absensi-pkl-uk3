<?php
include '../../../config/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $participant_id = $_POST['participant_id'];
    $check_in = $_POST['check_in'] ?: null;
    $check_in_location = $_POST['check_in_location'] ?: null;
    $check_out = $_POST['check_out'] ?: null;
    $check_out_location = $_POST['check_out_location'] ?: null;
    $status = $_POST['status'];
    $note = $_POST['note'] ?: null;

    $query = "UPDATE attendance SET 
      participant_id = '$participant_id',
      check_in = " . ($check_in ? "'$check_in'" : "NULL") . ",
      check_in_location = " . ($check_in_location ? "'$check_in_location'" : "NULL") . ",
      check_out = " . ($check_out ? "'$check_out'" : "NULL") . ",
      check_out_location = " . ($check_out_location ? "'$check_out_location'" : "NULL") . ",
      status = '$status',
      note = " . ($note ? "'$note'" : "NULL") . ",
      updated_at = NOW()
    WHERE id = '$id'";

    if (mysqli_query($connect, $query)) {
        echo "<script>
      alert('Data absensi berhasil diperbarui!');
      window.location.href='../../pages/attendance/index.php';
    </script>";
    } else {
        echo "<script>
      alert('Gagal memperbarui data!');
      window.location.href='../../pages/attendance/edit.php?id=$id';
    </script>";
    }
}
