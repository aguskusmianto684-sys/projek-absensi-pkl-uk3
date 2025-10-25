<?php
session_start();
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Catat aktivitas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data login
    $login_id = mysqli_real_escape_string($connect, $_POST['login_id']);
    $password = $_POST['password'];

    // Cek username atau email
    $query = "SELECT * FROM users WHERE username = '$login_id' OR email = '$login_id' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // ✅ Cek status akun
        if ($user['status'] !== 'aktif') {
            echo "<script>
                alert('Akun Anda nonaktif. Silakan hubungi admin.');
                window.location.href='../../pages/user/login.php';
            </script>";
            exit();
        }

        // ✅ Verifikasi password
        if (password_verify($password, $user['password_hash'])) {
            // Simpan ke session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];

            // ✅ Catat aktivitas login
            logActivity(
                $connect,
                $user['id'],
                'Login',
                'User ' . $user['username'] . ' berhasil login ke sistem.'
            );

            // ✅ Redirect sesuai role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../../pages/dashboard/index.php");
                    break;
                case 'pembimbing':
                    header("Location: ../../pages/attendance/index.php");
                    break;
                case 'peserta':
                    header("Location: ../../pages/attendance/index.php");
                    break;
                default:
                    header("Location: ../../pages/user/login.php");
                    break;
            }
            exit();

        } else {
            echo "<script>
                alert('❌ Password salah! Silakan coba lagi.');
                window.location.href='../../pages/user/login.php';
            </script>";
            exit();
        }

    } else {
        echo "<script>
            alert('❌ Username atau email tidak ditemukan!');
            window.location.href='../../pages/user/login.php';
        </script>";
        exit();
    }
}
?>
