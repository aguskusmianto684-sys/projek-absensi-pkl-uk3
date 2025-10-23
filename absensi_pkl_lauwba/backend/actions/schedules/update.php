<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $id = (int) $_POST['id'];
    $date = escapeString($_POST['date']);
    $expected_in = escapeString($_POST['expected_in']);
    $expected_out = escapeString($_POST['expected_out']);
    $description = escapeString($_POST['description']);

    // Validasi wajib
    if (empty($id) || empty($date) || empty($expected_in) || empty($expected_out) || empty($description)) {
        echo "<script>
            alert('Harap isi semua field wajib!');
            window.location.href='../../pages/schedules/edit.php?id=$id';
        </script>";
        exit;
    }

    // Query update tanpa updated_at
    $qUpdate = "UPDATE schedules SET
        date = '$date',
        expected_in = '$expected_in',
        expected_out = '$expected_out',
        description = '$description'
        WHERE id = '$id'";

    $res = mysqli_query($connect, $qUpdate);

    if ($res) {
        echo "<script>
            alert('Jadwal berhasil diperbarui!');
            window.location.href='../../pages/schedules/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Gagal memperbarui jadwal: " . mysqli_error($connect) . "');
            window.location.href='../../pages/schedules/edit.php?id=$id';
        </script>";
        exit;
    }
}
