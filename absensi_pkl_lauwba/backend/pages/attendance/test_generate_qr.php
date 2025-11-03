<?php
// --- Pastikan user login dulu ---
session_start();
if (!isset($_SESSION['logged_in'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
    exit();
}

// --- Load koneksi & library QR ---
include __DIR__ . '/../../../config/connection.php';
include __DIR__ . '/../../../library/phpqrcode/qrlib.php';

// --- Folder penyimpanan QR Code ---
$qrcodeDir = __DIR__ . '/../../../storages/qrcode/';
if (!is_dir($qrcodeDir)) {
    mkdir($qrcodeDir, 0777, true);
}

// --- Contoh data untuk generate QR ---
$user_id = $_SESSION['user_id'];
$unique_code = uniqid('absen_', true);
$qrData = "https://localhost/pkl_lauwba/backend/pages/attendance/scan_verify.php?code=" . urlencode($unique_code);

// --- Nama file QR ---
$fileName = 'qr_' . $user_id . '_' . time() . '.png';
$filePath = $qrcodeDir . $fileName;

// --- Generate QR ---
QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 6, 2);

// --- Tampilkan hasil di browser ---
echo "<h3>✅ QR Code Berhasil Digenerate!</h3>";
echo "<p>Data QR: <strong>$qrData</strong></p>";
echo "<img src='../../../storages/qrcode/$fileName' alt='QR Code'><br><br>";
echo "<p>File tersimpan di: <code>storages/qrcode/$fileName</code></p>";
