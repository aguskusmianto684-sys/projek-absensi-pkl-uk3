<?php
session_start();
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan fungsi log aktivitas

// Simpan dulu data user sebelum session dihancurkan
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Tidak diketahui';

// Jika user masih login, catat aktivitas logout
if ($user_id) {
    logActivity(
        $connect,
        $user_id,
        'Logout',
        'User ' . $username . ' telah logout dari sistem.'
    );
}

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman login
echo "<script>
    alert('Anda telah keluar dari sistem.');
    window.location.href='../../pages/user/login.php';
</script>";
exit();
?>
