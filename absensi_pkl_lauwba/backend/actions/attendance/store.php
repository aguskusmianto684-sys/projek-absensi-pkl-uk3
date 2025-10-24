<?php
// backend/actions/attendance/store.php

include '../../app.php';
include '../../../config/logActivity.php';
session_start();

if (!isset($_POST['tombol'])) {
    // akses langsung tanpa form
    echo "<script>
        alert('Akses tidak valid.');
        window.location.href='../../pages/attendance/index.php';
    </script>";
    exit;
}

// Ambil dan amankan input
$participant_id = escapeString($_POST['participant_id'] ?? '');
$check_in = escapeString($_POST['check_in'] ?? '');
$check_in_location = escapeString($_POST['check_in_location'] ?? '');
$check_out = escapeString($_POST['check_out'] ?? '');
$check_out_location = escapeString($_POST['check_out_location'] ?? '');
$status = escapeString($_POST['status'] ?? '');
$note = escapeString($_POST['note'] ?? '');

// Validasi sederhana
if (empty($participant_id) || empty($status)) {
    echo "<script>
        alert('Harap isi semua field wajib!');
        window.location.href='../../pages/attendance/create.php';
    </script>";
    exit;
}

// Susun nilai untuk INSERT (NULL jika kosong)
$check_in_sql = !empty($check_in) ? "'{$check_in}'" : "NULL";
$check_in_location_sql = !empty($check_in_location) ? "'{$check_in_location}'" : "NULL";
$check_out_sql = !empty($check_out) ? "'{$check_out}'" : "NULL";
$check_out_location_sql = !empty($check_out_location) ? "'{$check_out_location}'" : "NULL";

// Query insert
$qInsert = "
    INSERT INTO attendance 
    (participant_id, check_in, check_in_location, check_out, check_out_location, status, note, created_at, updated_at)
    VALUES
    ('{$participant_id}', {$check_in_sql}, {$check_in_location_sql}, {$check_out_sql}, {$check_out_location_sql}, '{$status}', '{$note}', NOW(), NOW())
";

$res = mysqli_query($connect, $qInsert);

if ($res) {
    // Ambil nama peserta (melalui tabel participants -> users) agar log lebih informatif
    $nama_peserta = 'Tidak Diketahui';
    $qPeserta = mysqli_query($connect, "
        SELECT u.full_name
        FROM participants p
        LEFT JOIN users u ON p.user_id = u.id
        WHERE p.id = '{$participant_id}' LIMIT 1
    ");
    if ($qPeserta && mysqli_num_rows($qPeserta) > 0) {
        $r = mysqli_fetch_assoc($qPeserta);
        if (!empty($r['full_name'])) $nama_peserta = $r['full_name'];
    }

    // Susun deskripsi log (aman dari injection karena sudah di-escape sebelumnya)
    $descParts = [];
    $descParts[] = "Nama Peserta: {$nama_peserta}";
    $descParts[] = "Participant ID: {$participant_id}";
    $descParts[] = "Status: {$status}";
    $descParts[] = "Check-in: " . ($check_in ?: '-');
    $descParts[] = "Lokasi Check-in: " . ($check_in_location ?: '-');
    $descParts[] = "Check-out: " . ($check_out ?: '-');
    $descParts[] = "Lokasi Check-out: " . ($check_out_location ?: '-');
    $descParts[] = "Catatan: " . ($note ?: '-');

    $description = implode(' | ', $descParts);
    // Pastikan description di-escape untuk query INSERT log (logActivity melakukan escape sendiri,
    // namun kita tetap pass string yang bersih)
    if (isset($_SESSION['user_id'])) {
        logActivity($connect, $_SESSION['user_id'], 'Tambah Absensi', $description);
    }

    echo "<script>
        alert('✅ Data absensi berhasil ditambahkan!');
        window.location.href='../../pages/attendance/index.php';
    </script>";
    exit;
} else {
    $err = mysqli_error($connect);
    echo "<script>
        alert('❌ Gagal menyimpan data: " . addslashes($err) . "');
        window.location.href='../../pages/attendance/create.php';
    </script>";
    exit;
}
