<?php
include '../../app.php'; // pastikan file app.php berisi koneksi $connect & fungsi escapeString()
include '../../../config/logActivity.php'; // ✅ Tambah fungsi log aktivitas
session_start();

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $date = escapeString($_POST['date']);
    $expected_in = escapeString($_POST['expected_in']);
    $expected_out = escapeString($_POST['expected_out']);
    $description = escapeString($_POST['description']);

    // Validasi input wajib
    if (empty($date) || empty($expected_in) || empty($expected_out) || empty($description)) {
        echo "<script>
            alert('⚠️ Harap isi semua field wajib!');
            window.location.href='../../pages/schedules/create.php';
        </script>";
        exit;
    }

    // Query insert
    $qInsert = "INSERT INTO schedules 
        (date, expected_in, expected_out, description, created_at) 
        VALUES ('$date', '$expected_in', '$expected_out', '$description', NOW())";

    $res = mysqli_query($connect, $qInsert);

    if ($res) {
        // ✅ Ambil ID jadwal terakhir yang baru ditambahkan
        $last_id = mysqli_insert_id($connect);

        // ✅ Catat aktivitas ke tabel logs
        if (isset($_SESSION['user_id'])) {
            $desc = "Menambahkan jadwal baru (ID: $last_id) — Tanggal: $date, Masuk: $expected_in, Pulang: $expected_out, Keterangan: $description";
            logActivity($connect, $_SESSION['user_id'], 'Tambah', $desc);
        }

        echo "<script>
            alert('✅ Jadwal berhasil ditambahkan!');
            window.location.href='../../pages/schedules/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('❌ Gagal menyimpan jadwal: " . addslashes(mysqli_error($connect)) . "');
            window.location.href='../../pages/schedules/create.php';
        </script>";
        exit;
    }
}
?>
