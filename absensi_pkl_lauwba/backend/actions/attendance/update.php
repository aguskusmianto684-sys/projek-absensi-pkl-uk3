<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan untuk mencatat log
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $participant_id = $_POST['participant_id'];
    $check_in = $_POST['check_in'] ?: null;
    $check_in_location = $_POST['check_in_location'] ?: null;
    $check_out = $_POST['check_out'] ?: null;
    $check_out_location = $_POST['check_out_location'] ?: null;
    $status = $_POST['status'];
    $note = $_POST['note'] ?: null;

    // Ambil data lama (supaya bisa dicatat di log)
    $oldData = mysqli_query($connect, "
        SELECT 
            a.*, 
            u.full_name AS nama_peserta 
        FROM attendance a
        LEFT JOIN participants p ON a.participant_id = p.id
        LEFT JOIN users u ON p.user_id = u.id
        WHERE a.id = '$id'
    ");
    $old = mysqli_fetch_assoc($oldData);

    // Update data
    $query = "
        UPDATE attendance SET 
            participant_id = '$participant_id',
            check_in = " . ($check_in ? "'$check_in'" : "NULL") . ",
            check_in_location = " . ($check_in_location ? "'$check_in_location'" : "NULL") . ",
            check_out = " . ($check_out ? "'$check_out'" : "NULL") . ",
            check_out_location = " . ($check_out_location ? "'$check_out_location'" : "NULL") . ",
            status = '$status',
            note = " . ($note ? "'$note'" : "NULL") . ",
            updated_at = NOW()
        WHERE id = '$id'
    ";

    if (mysqli_query($connect, $query)) {
        // ✅ Catat ke log aktivitas
        if (isset($_SESSION['user_id'])) {
            $description = "
                Mengedit data absensi ID: {$id} 
                | Peserta: " . ($old['nama_peserta'] ?? '-') . " 
                | Status Lama: " . ($old['status'] ?? '-') . " → Baru: {$status}
                | Check-in Lama: " . ($old['check_in'] ?? '-') . " → Baru: " . ($check_in ?: '-') . "
                | Check-out Lama: " . ($old['check_out'] ?? '-') . " → Baru: " . ($check_out ?: '-') . "
                | Catatan: " . ($note ?: '-');

            logActivity($connect, $_SESSION['user_id'], 'Edit Absensi', $description);
        }

        echo "<script>
            alert('✅ Data absensi berhasil diperbarui!');
            window.location.href='../../pages/attendance/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('❌ Gagal memperbarui data: " . addslashes(mysqli_error($connect)) . "');
            window.location.href='../../pages/attendance/edit.php?id=$id';
        </script>";
        exit;
    }
}
?>
