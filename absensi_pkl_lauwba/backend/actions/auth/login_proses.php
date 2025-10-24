<?php
session_start();
include '../../app.php';
include '../../../config/logActivity.php'; // ✅ Tambahkan fungsi log aktivitas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data login
    $login_id = mysqli_real_escape_string($connect, $_POST['login_id']);
    $password = $_POST['password'];

    // Cek apakah login pakai username atau email
    $query = "SELECT * FROM users WHERE username = '$login_id' OR email = '$login_id' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Pastikan akun aktif
        if ($user['status'] !== 'aktif') {
            echo "<script>
                alert('Akun Anda nonaktif. Silakan hubungi admin.');
                window.location.href='../../pages/user/login.php';
            </script>";
            exit();
        }

        // Verifikasi password
        if (password_verify($password, $user['password_hash'])) {

            // Simpan data user ke session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];

            // ✅ Catat log aktivitas login
            logActivity(
                $connect,
                $user['id'],
                'Login',
                'User ' . $user['username'] . ' berhasil login ke sistem.'
            );

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: ../../pages/dashboard/index.php");
            } elseif ($user['role'] === 'pembimbing') {
                header("Location: ../../pages/attendance/index.php");
            } else {
                header("Location: ../../pages/participants/index.php");
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
