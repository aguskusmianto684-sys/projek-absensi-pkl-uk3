<?php
// config/logActivity.php

/**
 * Fungsi untuk mencatat aktivitas user ke tabel logs
 * 
 * @param mysqli $connect Koneksi database
 * @param int $user_id ID user yang melakukan aktivitas
 * @param string $action Aksi utama (contoh: Login, Logout, Tambah, Hapus)
 * @param string|null $description Deskripsi tambahan (opsional)
 */
function logActivity($connect, $user_id, $action, $description = null)
{
    // Hindari SQL injection
    $user_id = intval($user_id);
    $action = mysqli_real_escape_string($connect, $action);
    $description = mysqli_real_escape_string($connect, $description ?? '');

    $query = "
        INSERT INTO logs (user_id, action, description, created_at)
        VALUES ('$user_id', '$action', '$description', NOW())
    ";

    if (!mysqli_query($connect, $query)) {
        // Kalau error, bisa dicetak untuk debugging
        error_log('Gagal mencatat log aktivitas: ' . mysqli_error($connect));
    }
}
?>
