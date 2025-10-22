<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $id = (int) $_POST['id'];
    $user_id = (int) $_POST['user_id'];
    $school = escapeString($_POST['school']);
    $program_study = escapeString($_POST['program_study']);
    $start_date = escapeString($_POST['start_date']);
    $end_date = escapeString($_POST['end_date']);
    $supervisor_id = (int) $_POST['supervisor_id'];
    $supervisor_name = escapeString($_POST['supervisor_name']);

    if (empty($id) || empty($user_id) || empty($school) || empty($program_study) || empty($start_date) || empty($end_date)) {
        echo "<script>
            alert('Harap isi semua field wajib!');
            window.location.href='../../pages/participants/edit.php?id=$id';
        </script>";
        exit;
    }

    $qUpdate = "UPDATE participants SET
        user_id = '$user_id',
        school = '$school',
        program_study = '$program_study',
        start_date = '$start_date',
        end_date = '$end_date',
        supervisor_id = '$supervisor_id',
        supervisor_name = '$supervisor_name',
        updated_at = NOW()
        WHERE id = '$id'";

    $res = mysqli_query($connect, $qUpdate);

    if ($res) {
        echo "<script>
            alert('Data peserta berhasil diperbarui!');
            window.location.href='../../pages/participants/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal memperbarui data: " . mysqli_error($connect) . "');
            window.location.href='../../pages/participants/edit.php?id=$id';
        </script>";
    }
}
