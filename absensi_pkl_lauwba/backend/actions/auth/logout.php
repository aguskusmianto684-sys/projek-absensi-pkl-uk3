<?php
include '../../app.php';

session_start();
// Hapus semua sesion
session_unset();
// Hapus session ID
session_destroy();

echo "<script>
        alert('Anda telah keluar!');
        window.location.href='../../pages/user/login.php'; //redirect ke halaman login
    </script>";
?>