<?php
include '../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($connect, $_POST['role'] ?? 'peserta'); // default aman

    // Cek duplikat username/email
    $check = mysqli_query($connect, "SELECT id FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username atau email sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Simpan ke database
    $q = "
        INSERT INTO users (username, password_hash, full_name, email, role, status, created_at)
        VALUES ('$username', '$password', '$full_name', '$email', '$role', 'aktif', NOW())
    ";
    $res = mysqli_query($connect, $q);

    if ($res) {
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href='../../pages/user/login.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mendaftar: " . mysqli_error($connect) . "');
            window.history.back();
        </script>";
    }
}
?>
