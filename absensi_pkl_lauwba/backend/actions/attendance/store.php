<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $participant_id = escapeString($_POST['participant_id']);
    $check_in = escapeString($_POST['check_in']);
    $check_in_location = escapeString($_POST['check_in_location']);
    $check_out = escapeString($_POST['check_out']);
    $check_out_location = escapeString($_POST['check_out_location']);
    $status = escapeString($_POST['status']);
    $note = escapeString($_POST['note']);

    // Validasi sederhana
    if (empty($participant_id) || empty($status)) {
        echo "<script>
            alert('Harap isi semua field wajib!');
            window.location.href='../../pages/attendance/create.php';
        </script>";
        exit;
    }

    // Simpan ke database
    $qInsert = "INSERT INTO attendance 
        (participant_id, check_in, check_in_location, check_out, check_out_location, status, note, created_at, updated_at)
        VALUES 
        ('$participant_id', 
         " . (!empty($check_in) ? "'$check_in'" : "NULL") . ", 
         " . (!empty($check_in_location) ? "'$check_in_location'" : "NULL") . ",
         " . (!empty($check_out) ? "'$check_out'" : "NULL") . ",
         " . (!empty($check_out_location) ? "'$check_out_location'" : "NULL") . ",
         '$status', 
         '$note', 
         NOW(), NOW()
        )";

    $res = mysqli_query($connect, $qInsert);

    if ($res) {
        echo "<script>
            alert('Data absensi berhasil ditambahkan!');
            window.location.href='../../pages/attendance/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data: " . mysqli_error($connect) . "');
            window.location.href='../../pages/attendance/create.php';
        </script>";
    }
}
