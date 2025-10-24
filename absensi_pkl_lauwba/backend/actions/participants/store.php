<?php
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan fungsi log aktivitas
session_start();

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $user_id = (int) $_POST['user_id']; // ID peserta
    $school = escapeString($_POST['school']);
    $program_study = escapeString($_POST['program_study']);
    $start_date = escapeString($_POST['start_date']);
    $end_date = escapeString($_POST['end_date']);
    $supervisor_name = escapeString($_POST['supervisor_name']); // nama pembimbing sekolah
    $supervisor_id = (int) $_POST['supervisor_id']; // ID pembimbing (integer)

    // Validasi input wajib
    if (empty($user_id) || empty($school) || empty($program_study) || empty($start_date) || empty($end_date)) {
        echo "<script>
            alert('Harap isi semua field wajib!');
            window.location.href='../../pages/participants/create.php';
        </script>";
        exit;
    }

    // Query insert
    $qInsert = "
        INSERT INTO participants 
        (user_id, school, program_study, start_date, end_date, supervisor_name, supervisor_id, created_at, updated_at)
        VALUES 
        ('$user_id', '$school', '$program_study', '$start_date', '$end_date', '$supervisor_name', '$supervisor_id', NOW(), NOW())
    ";

    $res = mysqli_query($connect, $qInsert);

    if ($res) {
        // ✅ Catat log aktivitas
        if (isset($_SESSION['user_id'])) {
            $desc = "Menambahkan peserta baru dari sekolah: $school, program: $program_study, dengan pembimbing: $supervisor_name.";
            logActivity($connect, $_SESSION['user_id'], 'Tambah', $desc);
        }

        echo "<script>
            alert('✅ Data peserta berhasil ditambahkan!');
            window.location.href='../../pages/participants/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('❌ Gagal menyimpan data: " . addslashes(mysqli_error($connect)) . "');
            window.location.href='../../pages/participants/create.php';
        </script>";
        exit;
    }
}
?>
