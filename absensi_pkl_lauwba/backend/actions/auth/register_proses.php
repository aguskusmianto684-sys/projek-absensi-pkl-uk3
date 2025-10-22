<?php
session_start();
include '../../app.php'; // koneksi ke database

// Pastikan form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];
    $full_name = mysqli_real_escape_string($connect, $_POST['full_name'] ?? $username); // default nama = username jika kosong

    // Cek apakah email atau username sudah terdaftar
    $cekQuery = "SELECT * FROM users WHERE email = '$email' OR username = '$username' LIMIT 1";
    $result = mysqli_query($connect, $cekQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<script>
            alert('Email atau username sudah terdaftar!');
            window.location.href='../../pages/user/register.php';
        </script>";
        exit();
    }

    // Enkripsi password pakai hash
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // Nilai default
    $role = 'peserta';
    $status = 'aktif';

    // Simpan data ke tabel users
    $insertQuery = "
        INSERT INTO users (username, password_hash, full_name, email, role, status)
        VALUES ('$username', '$hashPassword', '$full_name', '$email', '$role', '$status')
    ";

    if (mysqli_query($connect, $insertQuery)) {
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href='../../pages/user/login.php';
        </script>";
        exit();
    } else {
        echo '<pre>Kesalahan SQL: ' . mysqli_error($connect) . '</pre>';
        echo "<script>
            alert('Terjadi kesalahan saat menyimpan data.');
            window.location.href='../../pages/user/register.php';
        </script>";
        exit();
    }
}
?>
