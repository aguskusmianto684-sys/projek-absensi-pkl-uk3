<?php
session_start();
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Catat aktivitas logout

// Simpan data user untuk pencatatan log
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

// ✅ Hapus semua session
$_SESSION = [];          // kosongkan array session
session_unset();         // hapus semua variabel session
session_destroy();       // hancurkan session di server

// ✅ Hapus cookie session dari browser (biar benar-benar fresh)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// ✅ Nonaktifkan cache agar browser gak menampilkan halaman lama
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// ✅ Redirect ke halaman login (frontend/backend tergantung kebutuhan)
echo "<script>
    alert('Anda telah keluar dari sistem.');
    window.location.href='../../pages/user/login.php';
</script>";
exit();
?>
