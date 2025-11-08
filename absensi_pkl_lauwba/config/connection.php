<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "absensi_pkl_lauwba";

$connect = mysqli_connect($hostname, $username, $password, $database);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
