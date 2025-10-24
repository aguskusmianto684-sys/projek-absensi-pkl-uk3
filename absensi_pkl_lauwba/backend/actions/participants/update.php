<?php
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan fungsi log aktivitas
session_start();

if (isset($_POST['tombol'])) {
    $id = (int) $_POST['id'];
    $user_id = (int) $_POST['user_id'];
    $school = escapeString($_POST['school']);
    $program_study = escapeString($_POST['program_study']);
    $start_date = escapeString($_POST['start_date']);
    $end_date = escapeString($_POST['end_date']);
    $supervisor_id = (int) $_POST['supervisor_id'];
    $supervisor_name = escapeString($_POST['supervisor_name']);

    // ✅ Validasi wajib
    if (empty($id) || empty($user_id) || empty($school) || empty($program_study) || empty($start_date) || empty($end_date)) {
        echo "<script>
            alert('Harap isi semua field wajib!');
            window.location.href='../../pages/participants/edit.php?id=$id';
        </script>";
        exit;
    }

    // ✅ Update data peserta
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
        // ✅ Catat log aktivitas
        if (isset($_SESSION['user_id'])) {
            $desc = "Mengedit data peserta (ID: $id) - Sekolah: $school, Program: $program_study, Pembimbing: $supervisor_name.";
            logActivity($connect, $_SESSION['user_id'], 'Edit', $desc);
        }

        echo "<script>
            alert('✅ Data peserta berhasil diperbarui!');
            window.location.href='../../pages/participants/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('❌ Gagal memperbarui data: " . addslashes(mysqli_error($connect)) . "');
            window.location.href='../../pages/participants/edit.php?id=$id';
        </script>";
        exit;
    }
}
?>
